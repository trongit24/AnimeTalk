<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'community_id',
        'title',
        'slug',
        'category',
        'content',
        'background',
        'image',
        'video',
        'views',
        'likes',
        'is_pinned',
        'is_hidden',
        'hidden_at',
        'hidden_reason',
    ];

    protected $casts = [
        'is_pinned' => 'boolean',
        'is_hidden' => 'boolean',
        'hidden_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'uid');
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function community()
    {
        return $this->belongsTo(Community::class);
    }

    public function likes()
    {
        return $this->hasMany(PostLike::class);
    }

    public function likedBy($user)
    {
        if (!$user) return false;
        return $this->likes()->where('user_id', $user->uid)->exists();
    }

    public function isOwnedBy($user)
    {
        if (!$user) return false;
        return $this->user_id === $user->uid;
    }

    public function reports()
    {
        return $this->hasMany(PostReport::class);
    }

    public function reportedBy($user)
    {
        if (!$user) return false;
        return $this->reports()->where('user_id', $user->uid)->exists();
    }

    public function hide($reason = 'Vi phạm chính sách cộng đồng')
    {
        $this->update([
            'is_hidden' => true,
            'hidden_at' => now(),
            'hidden_reason' => $reason,
        ]);
    }

    public function unhide()
    {
        $this->update([
            'is_hidden' => false,
            'hidden_at' => null,
            'hidden_reason' => null,
        ]);
    }

    public function scopeVisible($query)
    {
        return $query->where('is_hidden', false);
    }

    public function scopeHidden($query)
    {
        return $query->where('is_hidden', true);
    }
}
