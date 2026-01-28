<?php

namespace App\Mail\Auth;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ForgotMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($token = null, $email = null)
    {
        $this->token = $token;
        $this->email = $email;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $token     = $this->token;
        $email     = $this->email;
        $signature = settings('signature');
        $site_name = settings('name');
        $logo      = logo(settings('light_logo'));
        $copyright = settings('copyright');
        return $this->from(settings('mail_address'))->view('auth.passwords.send_reset_link', compact('token', 'signature', 'email', 'site_name', 'logo', 'copyright'))->subject('Reset Password Notification');
    }
}
