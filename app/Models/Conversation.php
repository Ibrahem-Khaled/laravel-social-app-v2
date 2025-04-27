<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Conversation extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    protected $appends = ['chat_partner', 'last_message'];

    // this relationship functions
    public function users()
    {
        return $this->belongsToMany(User::class, 'conversation_users')
            ->withPivot('role', 'is_blocked')
            ->withTimestamps();
    }
    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    // this accessors functions
    public function getChatPartnerAttribute()
    {
        // نستخدم المجموعة المحمّلة users (Collection) إن وجدت،
        // وإلا سيحمّلها ويطبق الفلتر
        return $this->users
            ->first(fn($user) => $user->id !== auth()->guard('api')->user()->id);
    }
    public function getLastMessageAttribute()
    {
        return $this->messages()->latest()->first();
    }
}
