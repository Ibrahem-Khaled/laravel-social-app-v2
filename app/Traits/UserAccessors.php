<?php

namespace App\Traits;

trait UserAccessors
{
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

    public function getQuestionsCountAttribute()
    {
        return $this->receivedMessages()->where('is_anonymous', 1)->count();
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
}
