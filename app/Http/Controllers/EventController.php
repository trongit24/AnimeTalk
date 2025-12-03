<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\User;
use App\Models\EventNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class EventController extends Controller
{
    public function index(Request $request)
    {
        $query = Event::with(['owner'])
            ->withCount('participants')
            ->orderBy('start_time', 'asc');

        // Filter by upcoming/past
        if ($request->has('filter')) {
            if ($request->filter === 'upcoming') {
                $query->where('start_time', '>=', now());
            } elseif ($request->filter === 'past') {
                $query->where('start_time', '<', now());
            } elseif ($request->filter === 'my-events' && auth()->check()) {
                $query->where('user_id', auth()->user()->uid);
            } elseif ($request->filter === 'joined' && auth()->check()) {
                $query->whereHas('participants', function($q) {
                    $q->where('user_id', auth()->user()->uid)
                      ->where('status', 'going');
                });
            }
        } else {
            // Default: show upcoming events
            $query->where('start_time', '>=', now());
        }

        $events = $query->paginate(12);

        return view('events.index', compact('events'));
    }

    public function create()
    {
        return view('events.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'description' => 'nullable|max:5000',
            'location' => 'nullable|max:255',
            'start_time' => 'required|date|after:now',
            'end_time' => 'nullable|date|after:start_time',
            'cover_image' => 'nullable|image|max:2048',
            'privacy' => 'required|in:public,private,friends',
        ]);

        $event = Event::create([
            'user_id' => Auth::user()->uid,
            'title' => $validated['title'],
            'description' => $validated['description'] ?? null,
            'location' => $validated['location'],
            'start_time' => $validated['start_time'],
            'end_time' => $validated['end_time'],
            'privacy' => $validated['privacy'],
        ]);

        if ($request->hasFile('cover_image')) {
            $coverUrl = $this->cloudinary->uploadImage($request->file('cover_image'), 'animetalk/events/covers');
            if ($coverUrl) {
                $event->update(['cover_image' => $coverUrl]);
            }
        }

        // Add creator as participant (going)
        $event->participants()->attach(Auth::user()->uid, ['status' => 'going']);
        $event->update(['participants_count' => 1]);

        return redirect()->route('events.show', $event->id)
            ->with('success', 'Event created successfully!');
    }

    public function show($id)
    {
        $event = Event::with(['owner', 'participants'])
            ->withCount('participants')
            ->findOrFail($id);

        $goingUsers = $event->participants()->wherePivot('status', 'going')->get();
        $interestedUsers = $event->participants()->wherePivot('status', 'interested')->get();

        return view('events.show', compact('event', 'goingUsers', 'interestedUsers'));
    }

    public function edit($id)
    {
        $event = Event::findOrFail($id);

        if (!$event->isOwner(Auth::user())) {
            abort(403, 'Only the event owner can edit this event.');
        }

        return view('events.edit', compact('event'));
    }

    public function update(Request $request, $id)
    {
        $event = Event::findOrFail($id);

        if (!$event->isOwner(Auth::user())) {
            abort(403, 'Only the event owner can update this event.');
        }

        $validated = $request->validate([
            'title' => 'required|max:255',
            'description' => 'nullable|max:5000',
            'location' => 'nullable|max:255',
            'start_time' => 'required|date',
            'end_time' => 'nullable|date|after:start_time',
            'cover_image' => 'nullable|image|max:2048',
            'privacy' => 'required|in:public,private,friends',
        ]);

        $event->update([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'location' => $validated['location'],
            'start_time' => $validated['start_time'],
            'end_time' => $validated['end_time'],
            'privacy' => $validated['privacy'],
        ]);

        if ($request->hasFile('cover_image')) {
            $path = $request->file('cover_image')->store('events/covers', 'public');
            $event->update(['cover_image' => $path]);
        }

        return redirect()->route('events.show', $event->id)
            ->with('success', 'Event updated successfully!');
    }

    public function destroy($id)
    {
        $event = Event::findOrFail($id);

        if (!$event->isOwner(Auth::user())) {
            abort(403, 'Only the event owner can delete this event.');
        }

        if ($event->cover_image) {
            Storage::disk('public')->delete($event->cover_image);
        }

        $event->delete();

        return redirect()->route('events.index')
            ->with('success', 'Event deleted successfully!');
    }

    public function respond(Request $request, $id)
    {
        $event = Event::findOrFail($id);
        $status = $request->input('status'); // going, interested, declined

        if (!in_array($status, ['going', 'interested', 'declined'])) {
            return back()->with('error', 'Invalid status!');
        }

        // Check if already participant
        $existingParticipant = $event->participants()->where('user_id', Auth::user()->uid)->first();

        if ($existingParticipant) {
            // Update status
            $event->participants()->updateExistingPivot(Auth::user()->uid, ['status' => $status]);
        } else {
            // Add new participant
            $event->participants()->attach(Auth::user()->uid, ['status' => $status]);
        }

        // Update participants count (only count 'going')
        $goingCount = $event->participants()->wherePivot('status', 'going')->count();
        $event->update(['participants_count' => $goingCount]);

        $statusText = [
            'going' => 'You are going to this event!',
            'interested' => 'You are interested in this event!',
            'declined' => 'You declined this event.',
        ];

        return back()->with('success', $statusText[$status]);
    }

    public function invite(Request $request, $id)
    {
        $event = Event::findOrFail($id);

        if (!$event->isOwner(Auth::user())) {
            abort(403, 'Only the event owner can invite users.');
        }

        $validated = $request->validate([
            'user_ids' => 'required|array',
            'user_ids.*' => 'exists:users,uid',
        ]);

        foreach ($validated['user_ids'] as $userId) {
            // Check if already participant
            $existing = $event->participants()->where('user_id', $userId)->first();
            if (!$existing) {
                $event->participants()->attach($userId, ['status' => 'invited']);
                
                // Create notification for invited user
                EventNotification::create([
                    'event_id' => $event->id,
                    'user_id' => $userId,
                    'type' => 'event_invitation',
                    'message' => Auth::user()->name . ' đã mời bạn tham gia sự kiện "' . $event->title . '"',
                ]);
            }
        }

        return back()->with('success', 'Invitations sent successfully!');
    }
}
