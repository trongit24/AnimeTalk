<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CommunityActivity extends Model
{
    protected $fillable = [
        'community_id',
        'user_id',
        'type',
        'description',
        'post_id',
    ];

    public function community()
    {
        return $this->belongsTo(Community::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'uid');
    }

    public function post()
    {
        return $this->belongsTo(Post::class);
    }
}
