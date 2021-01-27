<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Config;

class ForgotPassword extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $email = '';
    public $token = '';
    public $user = '';

    public function __construct($email, $token, $user)
    {
        $this->email = $email;
        $this->token = $token;
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $data = array(
            'user' => $this->user,
            'token' => $this->token,
        );

        return $this->from(Config::get('mail.mailers.smtp.username'))
                    ->view('guest.email-template.forgot-password', compact('data'))
                    ->subject('[NCIP] Reset password');
    }
}
