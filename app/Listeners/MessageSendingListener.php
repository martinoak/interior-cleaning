<?php

namespace App\Listeners;

use Illuminate\Mail\Events\MessageSending;

class MessageSendingListener
{
    public function handle(MessageSending $event): void
    {
        if (!env("APP_DEBUG")) {
            $event->message->addBcc('martin.dub@dek-cz.com');
        }
    }
}
