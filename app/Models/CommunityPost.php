<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CommunityPost extends Model
{
    protected $fillable = [
        'community_id',
        'user_id',
        'content',
        'image',
        'video',
        'status',
        'reviewed_by',
        'reviewed_at',
        'reject_reason',
    ];

    protected $casts = [
        'reviewed_at' => 'datetime',
    ];

    public function community()
    {
        return $this->belongsTo(Community::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'uid');
    }

    public function reviewer()
    {
        return $this->belongsTo(User::class, 'reviewed_by', 'uid');
    }

    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }

    public function likes()
    {
        return $this->morphMany(PostLike::class, 'likeable');
    }

    // Scope để lấy bài viết đã duyệt
    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    // Scope để lấy bài viết chờ duyệt
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    // Scope để lấy bài viết bị từ chối
    public function scopeRejected($query)
    {
        return $query->where('status', 'rejected');
    }

    // Approve post
    public function approve($reviewerId)
    {
        $this->update([
            'status' => 'approved',
            'reviewed_by' => $reviewerId,
            'reviewed_at' => now(),
            'reject_reason' => null,
        ]);
    }

    // Reject post
    public function reject($reviewerId, $reason = null)
    {
        $this->update([
            'status' => 'rejected',
            'reviewed_by' => $reviewerId,
            'reviewed_at' => now(),
            'reject_reason' => $reason,
        ]);
    }
}
