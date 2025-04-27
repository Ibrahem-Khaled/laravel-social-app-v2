<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LiveStreaming extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'agency_id',
        'title',
        'description',
        'live_streaming_id',
        'thumbnail',
        'password',
        'status',
        'scheduled_at',
    ];
    protected $casts = [
        'scheduled_at' => 'datetime',
    ];
    protected $hidden = [
        'password',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->live_streaming_id = rand(100000000000, 999999999999);
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
}