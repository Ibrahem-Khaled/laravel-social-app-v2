<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BlockedUsers extends Model
{
    protected $fillable = [
        'user_id',
        'blocked_user_id',
    ];

    // العلاقة مع المستخدم الذي قام بالحظر
    public function blocker()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // العلاقة مع المستخدم الذي تم حظره
    public function blocked()
    {
        return $this->belongsTo(User::class, 'blocked_user_id');
    }
}
