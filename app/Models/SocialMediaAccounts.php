<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SocialMediaAccounts extends Model
{
    protected $fillable = [
        'user_id',
        'facebook',
        'twitter',
        'linkedin',
        'instagram',
        'snapchat',
        'tiktok',
        'youtube',
        'website',
        'other'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
