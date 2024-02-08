<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class FeedbackEmail extends Mailable
{
    use Queueable;
    use SerializesModels;
    public string $customerId;

    public string $variant;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(int $customerId, string $variant)
    {
        $this->customerId = $customerId;
        $this->variant = $variant;
    }

    public function build()
    {
        $this->subject('Děkuji za návštěvu!')->view('emails.feedback')->with([
            'id' => $this->customerId,
            'variant' => $this->variant,
        ]);

        return redirect(route('dashboard'));
    }
}
