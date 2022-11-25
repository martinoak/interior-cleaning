<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class FeedbackEmail extends Mailable
{
    use Queueable, SerializesModels;

    public string $hash;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->hash = md5(time());
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Děkuji za návštěvu!')->view('emails.feedback');
    }
}
