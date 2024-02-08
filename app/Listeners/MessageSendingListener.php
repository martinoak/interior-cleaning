<?php

namespace App\Listeners;

use Illuminate\Mail\Events\MessageSending;

class MessageSendingListener
{
    public function handle(MessageSending $event): void
    {
        if(! env("DEBUG_EMAILS")) { return; }

        $event->message->addBcc('martin.dub@dek-cz.com');
    }
}
