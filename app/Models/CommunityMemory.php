<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CommunityMemory extends Model
{
    protected $fillable = [
        'community_id',
        'user_id',
        'image',
        'caption',
        'status',
        'approved_at',
    ];

    /**
     * Get the community that owns the memory.
     */
    public function community()
    {
        return $this->belongsTo(Community::class);
    }

    /**
     * Get the user that created the memory.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'uid');
    }

    /**
     * Get all reactions for the memory.
     */
    public function reactions()
    {
        return $this->hasMany(MemoryReaction::class, 'memory_id');
    }

    /**
     * Get comments for the memory (polymorphic).
     */
    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }

    /**
     * Get reaction count grouped by emoji.
     */
    public function getReactionCountsAttribute()
    {
        return $this->reactions()
            ->selectRaw('reaction, COUNT(*) as count')
            ->groupBy('reaction')
            ->pluck('count', 'reaction');
    }

    /**
     * Scope to get only approved memories.
     */
    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    /**
     * Scope to get pending memories.
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    /**
     * Check if memory is approved.
     */
    public function isApproved()
    {
        return $this->status === 'approved';
    }

    /**
     * Approve this memory.
     */
    public function approve()
    {
        $this->update([
            'status' => 'approved',
            'approved_at' => now(),
        ]);
    }

    /**
     * Reject this memory.
     */
    public function reject()
    {
        $this->update(['status' => 'rejected']);
    }
}
