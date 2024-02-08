<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class FormEmail extends Mailable
{
    use Queueable, SerializesModels;

    public array $details;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($details)
    {
        $this->details = $details;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            from: config('mail.from.address'),
            replyTo: $this->details['email'],
            subject: 'Nová poptávka'
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.newDemand',
            with: [
                'name' => $this->details['name'],
                'email' => $this->details['email'],
                'telephone' => $this->details['telephone'],
                'message' => $this->details['message'],
            ]
        );
    }
}
