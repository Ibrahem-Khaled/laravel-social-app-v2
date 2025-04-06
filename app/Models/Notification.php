<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'message',
        'is_read',
        'related_id',
        'related_type',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function related()
    {
        return $this->morphTo();
    }
}
