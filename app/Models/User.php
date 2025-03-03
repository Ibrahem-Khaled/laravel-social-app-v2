<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use HasApiTokens, HasFactory, Notifiable;
    protected static function booted()
    {
        static::creating(function ($user) {
            $user->uuid = random_int(1000000000, 9999999999);
        });
    }
    protected $appends = ['user_followers_count', 'user_following_count', 'user_posts_count', 'user_gifts_count', 'is_current_user'];
    protected $guarded = ['id'];
    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function addCoins($amount)
    {
        $this->increment('coins', $amount);
    }

    public function subtractCoins($amount)
    {
        $this->decrement('coins', $amount);
    }

    public function scopeGender($query, $gender)
    {
        return $query->where('gender', $gender);
    }

    public function scopeCountry($query, $country)
    {
        return $query->where('country', $country);
    }

    // relations //
    public function posts()
    {
        return $this->hasMany(Post::class);
    }
    public function latestPost()
    {
        return $this->hasOne(Post::class)->latestOfMany();
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
        return $this->hasMany(PostLike::class);
    }

    public function commentedPosts()
    {
        return $this->hasMany(PostComment::class);
    }

    public function gifts()
    {
        return $this->belongsToMany(Gift::class, 'user_gifts')
            ->withPivot('sender_id', 'quantity')
            ->withTimestamps();
    }

    //this accessors methods
    public function getUserFollowersCountAttribute()
    {
        return $this->followers()->count();
    }

    public function getUserFollowingCountAttribute()
    {
        return $this->followings()->count();
    }

    public function getUserPostsCountAttribute()
    {
        return $this->posts()->count();
    }

    public function getUserGiftsCountAttribute()
    {
        return $this->gifts()->count();
    }

    public function getIsCurrentUserAttribute()
    {
        return $this->id == auth()->guard('api')->id();
    }

    //this method is used to get the identifier that will be stored in the subject claim of the JWT
    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }
}
