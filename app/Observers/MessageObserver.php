<?php

namespace App\Observers;

use App\Models\Message;
use App\Events\Chat;

class MessageObserver
{
    /**
     * Handle the Message "created" event.
     */
     public function created(Message $message): void
    {
        broadcast(new Chat('created', $message));
    }

    public function updated(Message $message): void
    {
        broadcast(new Chat('updated', $message));
    }

    public function deleted(Message $message): void
    {
        broadcast(new Chat('deleted', $message));
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
