<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Conversation extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    protected $appends = ['chat_partner', 'last_message', 'members_count', 'is_new'];
    protected $casts = [
        'is_group' => 'boolean',
        'created_at' => 'datetime',  // تأكد من أن created_at يُحوَّل تلقائيًا إلى Carbon
    ];
    // this relationship functions
    public function users()
    {
        return $this->belongsToMany(
            User::class,           // النموذج المرتبط
            'conversation_users',   // اسم الجدول الوسيط
            'conversation_id',      // المفتاح الأجنبي في الجدول الوسيط لإشارة إلى Conversation
            'user_id'               // المفتاح الأجنبي لإشارة إلى User
        )
            ->withPivot(['role', 'is_muted', 'is_blocked', 'is_archived', 'is_favorite'])
            ->withTimestamps();
    }
    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    public function latestMessage(): HasOne
    {
        return $this->hasOne(Message::class)->latestOfMany();
    }

    public function unreadMessagesForCurrentUser()
    {
        if (!auth()->guard('api')->check()) {
            return collect(); // إذا لم يكن المستخدم مسجلاً دخوله، نعيد مجموعة فارغة
        }
        if ($this->is_group) {
            return 0; // إذا كانت المحادثة جماعية، لا نعيد رسائل غير مقروءة
        }
        return $this->hasMany(Message::class)
            ->where('receiver_id', auth()->guard('api')->id())
            ->where('is_read', false);
    }

    // this accessors functions
    public function getChatPartnerAttribute()
    {
        // إذا كانت محادثة جماعية، لا نعطي شريك دردشة
        if ($this->is_group) {
            return null;
        }

        // وإلّا نعيد المستخدم الآخر غير المستخدم الحالي
        $authId = auth()->guard('api')->id();
        return $this->users
            ->first(fn($user) => $user->id !== $authId);
    }

    public function getIsNewAttribute()
    {
        if (!$this->created_at) {
            return false;
        }
        // إذا كانت المحادثة قديمة، نعيد false
        // إذا كانت المحادثة جديدة (أقل من 7 أيام)، نعيد true
        // حساب الفرق بين تاريخ الإنشاء والتاريخ الحالي
        $createdAt = $this->created_at;
        $now = now();
        $diffInDays = $createdAt->diffInDays($now);
        return $diffInDays < 7 ? true : false;
    }

    public function getMembersCountAttribute()
    {
        if ($this->is_group) {
            return $this->users()->count();
        }
        return 2; // محادثة ثنائية
    }

    public function getLastMessageAttribute()
    {
        return $this->messages()->latest()->first();
    }
}
