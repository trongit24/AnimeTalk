<?php

namespace App\Http\Controllers;

use App\Models\Community;
use App\Models\CommunityMemory;
use App\Models\MemoryReaction;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class CommunityMemoryController extends Controller
{
    /**
     * Store a newly created memory.
     */
    public function store(Request $request, Community $community)
    {
        $request->validate([
            'image' => 'required|image|max:10240', // 10MB max
            'caption' => 'nullable|string|max:500',
        ]);

        // Check if user is member
        if (!$community->isMember(Auth::user())) {
            return back()->with('error', 'Bạn phải là thành viên để tạo kỷ niệm!');
        }

        // Store image
        $imagePath = $request->file('image')->store('memories', 'public');

        // Create memory
        $memory = CommunityMemory::create([
            'community_id' => $community->id,
            'user_id' => Auth::user()->uid,
            'image' => $imagePath,
            'caption' => $request->caption,
            'status' => 'pending', // Default to pending approval
        ]);

        // Send notification to community owner
        Notification::create([
            'user_id' => $community->user_id,
            'type' => 'memory_pending',
            'title' => 'Kỷ niệm mới chờ duyệt',
            'message' => Auth::user()->name . ' đã tạo kỷ niệm mới trong cộng đồng ' . $community->name,
            'data' => json_encode([
                'memory_id' => $memory->id,
                'community_slug' => $community->slug,
                'user_name' => Auth::user()->name,
                'user_avatar' => Auth::user()->avatar,
            ]),
            'action_url' => route('communities.show', $community->slug),
        ]);

        return back()->with('success', 'Kỷ niệm đã được gửi và đang chờ duyệt!');
    }

    /**
     * Delete a memory.
     */
    public function destroy(CommunityMemory $memory)
    {
        // Check if user owns the memory or is community owner
        if ($memory->user_id !== Auth::user()->uid && 
            $memory->community->user_id !== Auth::user()->uid) {
            abort(403, 'Unauthorized action.');
        }

        // Delete image file
        if (Storage::disk('public')->exists($memory->image)) {
            Storage::disk('public')->delete($memory->image);
        }

        $memory->delete();

        return back()->with('success', 'Kỷ niệm đã được xóa!');
    }

    /**
     * Toggle reaction on a memory.
     */
    public function toggleReaction(Request $request, CommunityMemory $memory)
    {
        $request->validate([
            'reaction' => 'required|string|max:10',
        ]);

        $userId = Auth::user()->uid;
        $reaction = $request->reaction;

        // Check if user already reacted
        $existingReaction = MemoryReaction::where('memory_id', $memory->id)
            ->where('user_id', $userId)
            ->first();

        if ($existingReaction) {
            // Same reaction? Remove it
            if ($existingReaction->reaction === $reaction) {
                $existingReaction->delete();
                $action = 'removed';
            } else {
                // Different reaction? Update it
                $existingReaction->update(['reaction' => $reaction]);
                $action = 'updated';
            }
        } else {
            // Create new reaction
            MemoryReaction::create([
                'memory_id' => $memory->id,
                'user_id' => $userId,
                'reaction' => $reaction,
            ]);
            $action = 'added';
        }

        // Get updated reaction counts
        $reactionCounts = $memory->reactions()
            ->selectRaw('reaction, COUNT(*) as count')
            ->groupBy('reaction')
            ->get()
            ->mapWithKeys(fn($item) => [$item->reaction => $item->count]);

        return response()->json([
            'success' => true,
            'action' => $action,
            'reactionCounts' => $reactionCounts,
            'totalReactions' => $memory->reactions()->count(),
        ]);
    }

    /**
     * Approve a pending memory.
     */
    public function approve(CommunityMemory $memory)
    {
        // Check if user is community owner
        if ($memory->community->user_id !== Auth::user()->uid) {
            abort(403, 'Chỉ chủ cộng đồng mới có thể duyệt kỷ niệm.');
        }

        $memory->approve();

        // Send notification to memory creator
        Notification::create([
            'user_id' => $memory->user_id,
            'type' => 'memory_approved',
            'title' => 'Kỷ niệm đã được duyệt',
            'message' => 'Kỷ niệm của bạn trong cộng đồng ' . $memory->community->name . ' đã được duyệt!',
            'data' => json_encode([
                'memory_id' => $memory->id,
                'community_slug' => $memory->community->slug,
                'community_name' => $memory->community->name,
            ]),
            'action_url' => route('communities.show', $memory->community->slug),
        ]);

        return back()->with('success', 'Kỷ niệm đã được duyệt!');
    }

    /**
     * Reject a pending memory.
     */
    public function reject(CommunityMemory $memory)
    {
        // Check if user is community owner
        if ($memory->community->user_id !== Auth::user()->uid) {
            abort(403, 'Chỉ chủ cộng đồng mới có thể từ chối kỷ niệm.');
        }

        $memory->reject();

        // Send notification to memory creator
        Notification::create([
            'user_id' => $memory->user_id,
            'type' => 'memory_rejected',
            'title' => 'Kỷ niệm bị từ chối',
            'message' => 'Kỷ niệm của bạn trong cộng đồng ' . $memory->community->name . ' đã bị từ chối.',
            'data' => json_encode([
                'community_slug' => $memory->community->slug,
                'community_name' => $memory->community->name,
            ]),
            'action_url' => route('communities.show', $memory->community->slug),
        ]);

        return back()->with('success', 'Kỷ niệm đã bị từ chối!');
    }
}
