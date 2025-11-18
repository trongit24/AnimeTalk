<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EventController extends Controller
{
    public function index(Request $request)
    {
        $query = Event::with(['owner'])
            ->withCount('participants')
            ->orderBy('created_at', 'desc');

        if ($request->has('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        $events = $query->paginate(20);
        $totalEvents = Event::count();
        $upcomingEvents = Event::where('start_time', '>=', now())->count();
        $pastEvents = Event::where('start_time', '<', now())->count();

        return view('admin.events.index', compact('events', 'totalEvents', 'upcomingEvents', 'pastEvents'));
    }

    public function show($id)
    {
        $event = Event::with(['owner', 'participants'])->withCount('participants')->findOrFail($id);
        return view('admin.events.show', compact('event'));
    }

    public function destroy($id)
    {
        $event = Event::findOrFail($id);

        if ($event->cover_image) {
            Storage::disk('public')->delete($event->cover_image);
        }

        $event->delete();

        return redirect()->route('admin.events.index')
            ->with('success', 'Event deleted successfully!');
    }

    public function destroyMultiple(Request $request)
    {
        $validated = $request->validate([
            'event_ids' => 'required|array',
            'event_ids.*' => 'exists:events,id',
        ]);

        foreach ($validated['event_ids'] as $eventId) {
            $event = Event::find($eventId);
            if ($event) {
                if ($event->cover_image) {
                    Storage::disk('public')->delete($event->cover_image);
                }
                $event->delete();
            }
        }

        return redirect()->route('admin.events.index')
            ->with('success', count($validated['event_ids']) . ' events deleted successfully!');
    }
}
