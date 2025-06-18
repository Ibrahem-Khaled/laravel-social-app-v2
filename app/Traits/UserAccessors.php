<?php

namespace App\Traits;

use App\Models\CallLog;
use App\Models\Level;

trait UserAccessors
{
    //this accessors methods
    public function getAvatarUrlAttribute()
    {
        // إذا كانت قيمة avatar موجودة تُبنى باستخدام asset() مع مجلد storage
        return $this->avatar ? asset(env('APP_URL') . $this->avatar) : ($this->gender == 'male' ? asset(env('APP_URL') . '/assets/img/avatar-male2.png')
            : asset(env('APP_URL') . '/assets/img/avatar-female2.png'));
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
        $authUser = auth()->guard('api')->user();

        if (!$authUser) {
            return false;
        }

        return $authUser->blockedUsers()->where('blocked_user_id', $this->id)->exists();
    }
    public function allCallLogs()
    {
        return CallLog::with(['sender', 'recipient'])
            ->where('sender_id', $this->id)
            ->orWhere('recipient_id', $this->id);
    }

    public function getVerificationRequestAttribute()
    {
        // 1. نطلب آخر سجل من العلاقة IsRequestVerified (قد تكون علاقة hasMany إلى موديل VerificationRequest)
        $latestRequest = $this->IsRequestVerified()->latest()->first();
        // 2. إذا لم يكن هناك أي سجل (null)، نعيد false (أو أي قيمة افتراضية تراها مناسبة)
        if (! $latestRequest) {
            return false;
        }
        // 3. إذا كان موجودًا، نتحقق من حالة الطلب فإذا كانت 'pending' نعيد true وإلا false
        return $latestRequest->status === 'pending';
    }
    public function getCurrentLevelAttribute()
    {
        return Level::where('points_required', '<=', $this->points)
            ->orderByDesc('points_required')
            ->first();
    }
}
