<?php

namespace App\Traits;

use App\Models\Conversation;
use App\Models\Gift;
use App\Models\Message;
use App\Models\Post;
use App\Models\PostComment;
use App\Models\PostLike;
use App\Models\User;

trait UserRelationships
{
    // relations //
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

    // المستخدمون الذين يتابعون هذا المستخدم
    public function followers()
    {
        return $this->belongsToMany(User::class, 'follows', 'following_id', 'follower_id');
    }


    // المستخدمون الذين يتابعهم هذا المستخدم
    public function followings()
    {
        return $this->belongsToMany(User::class, 'follows', 'follower_id', 'following_id');
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

    // العلاقات للمستخدم الذي قام بحظر مستخدمين آخرين
    public function blockedUsers()
    {
        return $this->belongsToMany(User::class, 'blocked_users', 'user_id', 'blocked_user_id');
    }

}
