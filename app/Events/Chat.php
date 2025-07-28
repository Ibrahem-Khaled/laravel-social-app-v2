<?php

namespace App\Events;

use App\Models\Message;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class Chat implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @var string
     */
    public $action; // 'created', 'updated', or 'deleted'

    /**
     * @var \App\Models\Message
     */
    private $message; // جعلناه خاصًا للتحكم في البيانات المرسلة

    /**
     * Create a new event instance.
     *
     * @param string $action The type of action performed.
     * @param \App\Models\Message $message The message model.
     */
    public function __construct(string $action, Message $message)
    {
        $this->action = $action;
        $this->message = $message;
    }

    /**
     * Get the channels the event should broadcast on.
     */
    public function broadcastOn(): array
    {
        // القناة لم تتغير، هي نفسها قناة المحادثة
        return [
            new PrivateChannel('conversation.' . $this->message->conversation_id),
        ];
    }

    /**
     * The event's broadcast name.
     */
    public function broadcastAs(): string
    {
        // اسم عام للحدث
        return 'chat.event';
    }

    /**
     * Get the data to broadcast.
     *
     * @return array
     */
    public function broadcastWith(): array
    {
        // هنا نحدد البيانات المرسلة بناءً على نوع العملية
        $payload = [];

        switch ($this->action) {
            case 'created':
            case 'updated':
                // في حالتي الإنشاء والتحديث، أرسل الرسالة كاملة مع المرسل
                $payload = $this->message->load('sender')->toArray();
                break;

            case 'deleted':
                // في حالة الحذف، يكفي إرسال ID الرسالة
                $payload = ['id' => $this->message->id];
                break;
        }

        return [
            'action' => $this->action,
            'payload' => $payload,
        ];
    }
}
