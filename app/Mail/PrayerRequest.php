<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PrayerRequest extends Mailable
{
    use Queueable, SerializesModels;

    public $prayerData;

    public function __construct($prayerData)
    {
        $this->prayerData = $prayerData;
    }

    public function build()
    {
        return $this->subject('New Prayer Request - ISM Prayer Network')
                    ->view('emails.prayer-request')
                    ->with('data', $this->prayerData);
    }
}