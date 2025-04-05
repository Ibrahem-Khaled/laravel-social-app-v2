<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Conversation extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    protected $appends = ['chat_partner', 'last_message'];

    public function userOne()
    {
        return $this->belongsTo(User::class, 'user_one');
    }

    public function userTwo()
    {
        return $this->belongsTo(User::class, 'user_two');
    }

    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    // this accessors functions
    public function getChatPartnerAttribute()
    {
        return ($this->user_one == auth()->user()->id)
            ? $this->userTwo
            : $this->userOne;
    }
    public function getLastMessageAttribute()
    {
        return $this->messages()->latest()->first();
    }
}
