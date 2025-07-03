<?php

namespace App\Events;

use App\Models\Message; // افترض أن السؤال يتم تخزينه في موديل Message
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NewQuestionReceived implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public Message $question;

    public function __construct(Message $question)
    {
        $this->question = $question;
    }

    public function broadcastOn(): array
    {
        // البث على قناة خاصة بالمستخدم "المستقبل" للسؤال
        return [
            new PrivateChannel('questions.' . $this->question->recipient_id),
        ];
    }

    public function broadcastAs(): string
    {
        return 'new-question';
    }

    public function broadcastWith(): array
    {
        // تحميل بيانات المرسل مع السؤال
        $this->question->load('sender:id,name,avatar_url');

        // إذا كان السؤال مجهولاً، قم بإزالة بيانات المرسل
        if ($this->question->is_anonymous) {
            $this->question->setRelation('sender', null);
        }

        return $this->question->toArray();
    }
}
