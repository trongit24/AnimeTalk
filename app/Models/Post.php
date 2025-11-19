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
    ];

    protected $casts = [
        'is_pinned' => 'boolean',
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
}
