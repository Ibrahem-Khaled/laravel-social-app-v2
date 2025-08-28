<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\{BelongsTo, MorphMany};
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Enums\{ContactStatus, ContactPriority, ContactCategory, ContactSource};

class ContactMessage extends Model
{
    use HasUlids, SoftDeletes;

    protected $fillable = [
        'user_id',
        'guest_name',
        'guest_email',
        'guest_phone',
        'subject',
        'message',
        'status',
        'priority',
        'category',
        'source',
        'assigned_to_id',
        'ip_address',
        'user_agent',
        'replied_at',
        'meta',
    ];

    protected $casts = [
        'status'   => ContactStatus::class,
        'priority' => ContactPriority::class,
        'category' => ContactCategory::class,
        'source'   => ContactSource::class,
        'replied_at' => 'datetime',
        'meta' => 'array',
    ];
    // صاحب الرسالة (مستخدم مسجل)
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // الموظف المعيّن للرد
    public function assignee(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_to_id');
    }

    // المرفقات (علاقة متعددة الأشكال)
    public function attachments(): MorphMany
    {
        return $this->morphMany(Attachment::class, 'attachable');
    }
}
