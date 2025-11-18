<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'description',
        'location',
        'cover_image',
        'start_time',
        'end_time',
        'privacy',
        'participants_count',
    ];

    protected $casts = [
        'start_time' => 'datetime',
        'end_time' => 'datetime',
    ];

    public function owner()
    {
        return $this->belongsTo(User::class, 'user_id', 'uid');
    }

    public function participants()
    {
        return $this->belongsToMany(User::class, 'event_participants', 'event_id', 'user_id', 'id', 'uid')
            ->withPivot('status')
            ->withTimestamps();
    }

    public function isOwner($user): bool
    {
        if (!$user) return false;
        return $this->user_id === $user->uid;
    }

    public function isParticipant($user): bool
    {
        if (!$user) return false;
        return $this->participants()->where('users.uid', $user->uid)->exists();
    }

    public function getParticipantStatus($user): ?string
    {
        if (!$user) return null;
        $participant = $this->participants()->where('user_id', $user->uid)->first();
        return $participant ? $participant->pivot->status : null;
    }

    public function isPast(): bool
    {
        return $this->start_time->isPast();
    }

    public function isUpcoming(): bool
    {
        return $this->start_time->isFuture();
    }

    public function isToday(): bool
    {
        return $this->start_time->isToday();
    }

    public function isTomorrow(): bool
    {
        return $this->start_time->isTomorrow();
    }
}
