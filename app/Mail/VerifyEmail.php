<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class VerifyEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $code;
    public $email;

    public function __construct($email, $code)
    {
        $this->email = $email;
        $this->code = $code;
    }

    public function build()
    {
        $verifyUrl = url("/verify?email={$this->email}&code={$this->code}");
        return $this->subject('Verifikasi Email Akun Anda')
            ->view('verify')
            ->with([
                'email' => $this->email,
                'code' => $this->code,
            ]);
    }
}
