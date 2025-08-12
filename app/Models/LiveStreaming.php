<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str; // <-- لا تنسَ استدعاء هذه الكلاس

class LiveStreaming extends Model
{
    use HasFactory;

    protected $appends = ['thumbnail_url','is_host'];
    protected $guarded = ['id'];
    protected $casts = [
        'scheduled_at' => 'datetime',
        'status' => 'boolean',
    ];
    protected $hidden = [
        'password',
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($liveStreamModel) {
            if (empty($liveStreamModel->channel_name)) {
                $liveStreamModel->channel_name = "stream_" . $liveStreamModel->user_id . "_" . Str::random(10);
            }
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function agency()
    {
        return $this->belongsTo(Agency::class);
    }




    ///this accessors functions
    public function getThumbnailUrlAttribute()
    {
        return $this->thumbnail ? asset('storage/' . $this->thumbnail) : asset('assets/img/logo.png');
    }

    public function getIsHostAttribute()
    {
        return $this->user_id === auth()->guard('api')->id();
    }
}
