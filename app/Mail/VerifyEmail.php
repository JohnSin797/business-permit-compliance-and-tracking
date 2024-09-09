<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class VerifyEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $full_name;
    public $otp;

    /**
     * Create a new message instance.
     */
    public function __construct($full_name,$otp)
    {
        $this->full_name = $full_name;
        $this->otp = $otp;
    }

    public function build()
    {
        return $this->subject('Email Verification')
            ->view('emails.verify-email')
            ->with([
                'full_name' => $this->full_name,
                'otp' => $this->otp,
            ]);
    }
}
