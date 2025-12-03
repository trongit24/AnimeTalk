<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MemoryReaction extends Model
{
    protected $fillable = [
        'memory_id',
        'user_id',
        'reaction',
    ];

    /**
     * Get the memory that owns the reaction.
     */
    public function memory()
    {
        return $this->belongsTo(CommunityMemory::class, 'memory_id');
    }

    /**
     * Get the user that made the reaction.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'uid');
    }
}
