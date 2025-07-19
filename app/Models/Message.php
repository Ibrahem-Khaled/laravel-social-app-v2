<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Message extends Model
{
    use HasFactory;

    protected $fillable = [
        'conversation_id',
        'sender_id',
        'receiver_id',
        'message',
        'media',
        'is_read',
        'is_anonymous',
        'type_message',
        'parent_id',
    ];

    // العلاقة مع المحادثة
    public function conversation()
    {
        return $this->belongsTo(Conversation::class);
    }

    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    public function receiver()
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }

    public function post()
    {
        return $this->hasOne(Post::class, 'message_id', 'id');
    }

    // العلاقة مع الرسالة الأصل (التي يتم الرد عليها)
    public function parent()
    {
        return $this->belongsTo(Message::class, 'parent_id');
    }

    // العلاقة مع الردود (الرسائل الفرعية)
    public function replies()
    {
        return $this->hasMany(Message::class, 'parent_id');
    }

    // العلاقة مع المستخدمين الذين قاموا بحذف الرسالة
    public function deletedByUsers(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'message_user_deleted', 'message_id', 'user_id');
    }
}
