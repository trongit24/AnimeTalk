<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

/**
 * @method bool save(array $options = [])
 */
class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'uid';

    /**
     * The "type" of the primary key ID.
     *
     * @var string
     */
    protected $keyType = 'string';

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'uid',
        'name',
        'email',
        'password',
        'bio',
        'profile_photo',
        'cover_photo',
        'role',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function posts()
    {
        return $this->hasMany(Post::class, 'user_id', 'uid');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class, 'user_id', 'uid');
    }

    public function communities()
    {
        return $this->belongsToMany(Community::class, 'community_members', 'user_id', 'community_id', 'uid');
    }

    public function postLikes()
    {
        return $this->hasMany(PostLike::class, 'user_id', 'uid');
    }

    public function sentMessages()
    {
        return $this->hasMany(Message::class, 'sender_id', 'uid');
    }

    public function receivedMessages()
    {
        return $this->hasMany(Message::class, 'receiver_id', 'uid');
    }

    public function friendshipsInitiated()
    {
        return $this->hasMany(Friendship::class, 'user_id', 'uid');
    }

    public function friendshipsReceived()
    {
        return $this->hasMany(Friendship::class, 'friend_id', 'uid');
    }

    public function events()
    {
        return $this->hasMany(Event::class, 'user_id', 'uid');
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class, 'user_id', 'uid');
    }

    public function eventNotifications()
    {
        return $this->hasMany(EventNotification::class, 'user_id', 'uid');
    }

    public function communityPosts()
    {
        return $this->hasMany(CommunityPost::class, 'user_id', 'uid');
    }

    public function communityMessages()
    {
        return $this->hasMany(CommunityMessage::class, 'user_id', 'uid');
    }

    public function communityMemories()
    {
        return $this->hasMany(CommunityMemory::class, 'user_id', 'uid');
    }

    public function memoryReactions()
    {
        return $this->hasMany(MemoryReaction::class, 'user_id', 'uid');
    }

    public function postReports()
    {
        return $this->hasMany(PostReport::class, 'user_id', 'uid');
    }

    public function ownedCommunities()
    {
        return $this->hasMany(Community::class, 'user_id', 'uid');
    }

    /**
     * Check if user is admin.
     */
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    /**
     * Boot function for User model.
     */
    protected static function boot()
    {
        parent::boot();

        // Generate UID automatically when creating new user
        static::creating(function ($user) {
            if (empty($user->uid)) {
                $user->uid = self::generateUID();
            }
        });
    }

    /**
     * Generate unique UID for user.
     */
    private static function generateUID()
    {
        do {
            $uid = 'U' . str_pad(random_int(1, 9999999999), 10, '0', STR_PAD_LEFT);
        } while (self::where('uid', $uid)->exists());
        
        return $uid;
    }
}
