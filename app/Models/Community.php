<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Community extends Model
{
    protected $fillable = [
        'user_id',
        'name',
        'slug',
        'description',
        'icon',
        'banner',
        'category',
        'members_count',
        'is_private',
    ];

    protected $casts = [
        'is_private' => 'boolean',
    ];

    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'uid');
    }

    // Alias for admin panel compatibility
    public function creator(): BelongsTo
    {
        return $this->owner();
    }

    public function members(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'community_members', 'community_id', 'user_id', 'id', 'uid')
            ->withPivot('role')
            ->withTimestamps();
    }

    public function posts()
    {
        return $this->hasMany(Post::class, 'community_id');
    }

    public function activities()
    {
        return $this->hasMany(CommunityActivity::class);
    }

    public function isOwner($user): bool
    {
        if (!$user) return false;
        return $this->user_id === $user->uid;
    }

    public function isMember($user): bool
    {
        if (!$user) return false;
        return $this->members()->where('users.uid', $user->uid)->exists();
    }

    public function getMemberRole($user): ?string
    {
        if (!$user) return null;
        $member = $this->members()->where('user_id', $user->uid)->first();
        return $member ? $member->pivot->role : null;
    }
}
