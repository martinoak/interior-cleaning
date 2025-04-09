<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Collection;

class ExpiringDatesMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * The array of vehicles with expiring dates.
     *
     * @var Collection
     */
    private Collection $expiring;

    /**
     * Create a new message instance.
     */
    public function __construct(Collection $expiring)
    {
        $this->expiring = $expiring;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Vozový park - kontrola datumů',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.car-park.expiring-dates-mail',
            with: ['expiring' => $this->expiring],
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
