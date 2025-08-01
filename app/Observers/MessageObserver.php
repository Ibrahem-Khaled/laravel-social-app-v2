<?php

namespace App\Observers;

use App\Models\Message;
use App\Events\Chat;
use Illuminate\Support\Facades\Log; //  ✨ أضف هذا السطر

class MessageObserver
{
    /**
     * Handle the Message "created" event.
     */
    public function created(Message $message): void
    {
        Log::info("MessageObserver 'created' method triggered for message ID: {$message->id}");
        broadcast(new Chat('created', $message))->toOthers();
    }

    public function updated(Message $message): void
    {
        Log::info("MessageObserver 'updated' method triggered for message ID: {$message->id}");
        broadcast(new Chat('updated', $message))->toOthers();
    }

    public function deleted(Message $message): void
    {
        Log::info("MessageObserver 'deleted' method triggered for message ID: {$message->id}");
        broadcast(new Chat('deleted', $message))->toOthers();
    }

    /**
     * Handle the Message "restored" event.
     */
    public function restored(Message $message): void
    {
        //
    }

    /**
     * Handle the Message "force deleted" event.
     */
    public function forceDeleted(Message $message): void
    {
        //
    }
}
