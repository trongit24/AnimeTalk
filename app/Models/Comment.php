<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'post_id',
        'content',
        'image',
        'likes',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'uid');
    }

    public function post()
    {
        return $this->belongsTo(Post::class);
    }

    public function isOwnedBy($user)
    {
        if (!$user) return false;
        return $this->user_id === $user->uid;
    }
}
