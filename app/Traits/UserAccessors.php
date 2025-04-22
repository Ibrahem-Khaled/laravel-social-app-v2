<?php

namespace App\Traits;

trait UserAccessors
{
    //this accessors methods
    public function getAvatarUrlAttribute()
    {
        // إذا كانت قيمة avatar موجودة تُبنى باستخدام asset() مع مجلد storage
        return $this->avatar ? asset(env('APP_URL') . $this->avatar) :
            ($this->gender == 'male' ? asset(env('APP_URL') . '/assets/img/avatar-male.jpeg')
                : asset(env('APP_URL') . '/assets/img/avatar-female.jpeg'));
    }
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

    public function getQuestionsCountAttribute()
    {
        return $this->receivedMessages()->where('type_message', 'anonymous')->count();
    }

    public function getIsCurrentUserAttribute()
    {
        return $this->id == auth()->guard('api')->id();
    }

    public function getIsAuthanticatedUserFollowingThisUserAttribute()
    {
        return $this->followers()->where('follower_id', auth()->guard('api')->id())->exists();
    }

    public function getIsAuthanticatedUserBlockedThisUserAttribute()
    {
        return $this->blockedUsers()->where('blocked_user_id', auth()->guard('api')->id())
            ->orWhere('user_id', auth()->guard('api')->id())
            ->exists();
    }

    public function getCallLogsAttribute()
    {
        // نجلب الاثنين ثم ندمجهما ونرتب حسب وقت البداية تنازلياً
        return $this->sentCalls
            ->merge($this->receivedCalls)
            ->sortByDesc('start_time');
    }
}
