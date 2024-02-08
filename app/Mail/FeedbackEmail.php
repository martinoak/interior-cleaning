<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class FeedbackEmail extends Mailable
{
    use Queueable, SerializesModels;

    public string $customerId;

    public string $variant;

    /**
     * Create a new message instance.
     */
    public function __construct(int $customerId, string $variant)
    {
        $this->customerId = $customerId;
        $this->variant = $variant;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            from: config('mail.from.address'),
            subject: 'Děkuji za návštěvu!'
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.feedback',
            with: [
                'id' => $this->customerId,
                'variant' => $this->variant,
            ]
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
