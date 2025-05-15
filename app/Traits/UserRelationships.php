<?php

namespace App\Traits;

use App\Models\CallLog;
use App\Models\Conversation;
use App\Models\Gift;
use App\Models\Message;
use App\Models\Notification;
use App\Models\Post;
use App\Models\PostComment;
use App\Models\PostLike;
use App\Models\SocialMediaAccounts;
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
        return $this->belongsToMany(Conversation::class, 'conversation_users')
            ->withPivot('role', 'is_blocked')
            ->withTimestamps();
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
        return $this->belongsToMany(User::class, 'blocked_users', 'user_id', 'blocked_user_id')->withTimestamps();
    }

    public function socialMedia()
    {
        return $this->hasOne(SocialMediaAccounts::class);
    }

    public function sentCalls()
    {
        // جميع المكالمات التي أرسلها المستخدم
        return $this->hasMany(CallLog::class, 'sender_id');
    }

    public function receivedCalls()
    {
        // جميع المكالمات التي استقبلها المستخدم
        return $this->hasMany(CallLog::class, 'recipient_id');
    }


    public function userNotifications()
    {
        return $this->hasMany(Notification::class);
    }
}
