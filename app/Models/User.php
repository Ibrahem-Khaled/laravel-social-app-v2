<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    protected static function booted()
    {
        static::creating(function ($user) {
            $user->uuid = random_int(1000000000, 9999999999);
        });
    }
    protected $fillable = [
        'name',
        'email',
        'password',
    ];
    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public function sentMessages()
    {
        return $this->hasMany(Message::class, 'sender_id');
    }

    public function receivedMessages()
    {
        return $this->hasMany(Message::class, 'receiver_id');
    }

    public function conversations()
    {
        return $this->hasMany(Conversation::class, 'user_one')
            ->orWhere('user_two', $this->id);
    }

    // المستخدمون الذين يتابعهم هذا المستخدم
    public function followings()
    {
        return $this->belongsToMany(User::class, 'follows', 'follower_id', 'following_id');
    }

    // المستخدمون الذين يتابعون هذا المستخدم
    public function followers()
    {
        return $this->belongsToMany(User::class, 'follows', 'following_id', 'follower_id');
    }

    public function likedPosts()
    {
        return $this->belongsToMany(Post::class, 'post_likes', 'user_id', 'post_id');
    }

    public function commentedPosts()
    {
        return $this->belongsToMany(Post::class, 'post_comments', 'user_id', 'post_id');
    }

    public function gifts()
    {
        return $this->belongsToMany(Gift::class, 'user_gifts', 'user_id', 'gift_id');
    }
}
