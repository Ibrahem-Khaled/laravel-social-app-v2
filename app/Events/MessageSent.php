<?php

namespace App\Events;

use App\Models\Message; // افترض أن اسم الموديل هو Message
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class MessageSent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public Message $message;

    /**
     * Create a new event instance.
     */
    public function __construct(Message $message)
    {
        $this->message = $message;
    }

    /**
     * Get the channels the event should broadcast on.
     */
    public function broadcastOn(): array
    {
        // سنبث الحدث على قناة خاصة بالمستخدم "المستقبل" للرسالة
        return [
            new PrivateChannel('messages.' . $this->message->recipient_id),
        ];
    }

    /**
     * The event's broadcast name.
     */
    public function broadcastAs(): string
    {
        return 'new-message';
    }

    /**
     * Get the data to broadcast.
     *
     * ✨ هنا نقوم بتطبيق منطق إخفاء هوية المرسل ✨
     */
    public function broadcastWith(): array
    {
        // أولاً، نقوم بتحميل بيانات المرسل
        $this->message->load('sender:id,name,avatar_url');

        // إذا كانت الرسالة مجهولة، نقوم بإزالة علاقة المرسل
        if ($this->message->is_anonymous) {
            $this->message->setRelation('sender', null);
        }

        // نقوم بإرجاع بيانات الرسالة كمصفوفة جاهزة للاستخدام في الواجهة الأمامية
        return $this->message->toArray();
    }
}
