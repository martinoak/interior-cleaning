<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Redirect;

class FeedbackEmail extends Mailable
{
    use Queueable, SerializesModels;

    public string $hash;
    public int $variant;

    /**
     * Create a new message instance.
     *
     * @param int|null $variant
     * @return void
     */
    public function __construct(?int $variant)
    {
        $this->hash = md5(time());
        $this->variant = $variant;
    }

    public function build()
    {
        $this->subject('Děkuji za návštěvu!')->view('emails.feedback')->with([
            'variant' => $this->variant,
        ]);

        return redirect(route('dashboard'));
    }
}
