<?php

namespace App\Events;

use App\Models\Notification;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NotificationCreated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    // اجعل المتغير عاماً ليتم الوصول إليه
    public Notification $notification;

    /**
     * Create a new event instance.
     */
    public function __construct(Notification $notification)
    {
        $this->notification = $notification;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        // سنرسل الإشعار على قناة خاصة بالمستخدم الذي يخصه الإشعار
        // مثلاً: 'notifications.1' للمستخدم رقم 1
        return [
            new PrivateChannel('notifications.' . $this->notification->user_id),
        ];
    }

    /**
     * اسم الحدث الذي سيتم بثه
     */
    public function broadcastAs(): string
    {
        return 'new-notification';
    }

    /**
     * البيانات التي سيتم بثها - هنا نجعل البيانات منظمة
     */
    public function broadcastWith(): array
    {
        // نقوم بتجهيز البيانات بنفس الشكل المنظم الذي نريده في التطبيق
        return [
            'id' => $this->notification->id,
            'user_id' => $this->notification->related?->user?->id, // ID المستخدم الذي قام بالفعل
            'user' => $this->notification->related?->user?->name ?? 'مستخدم',
            'image' => $this->notification->related?->user?->avatar_url,
            'action' => $this->notification->message,
            'is_read' => $this->notification->is_read,
            'time' => $this->notification->created_at->diffForHumans(),
            // أضف هذه البيانات لتسهيل عملية التوجيه في التطبيق
            'related_id' => $this->notification->related_id,
            'related_type' => $this->notification->related_type,
        ];
    }
}
