<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PasswordResetOTP extends Mailable
{
    use Queueable, SerializesModels;

    private $data, $resend_otp;

    /**
     * Create a new message instance.
     */
    public function __construct($data = null, $resend_otp = false)
    {
        $this->data         = $data;
        $this->resend_otp   = $resend_otp;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        $subject = $this->resend_otp ? ___('alert.resend_forget_password_code') :  ___('alert.forget_password_code');

        return new Envelope(
            subject: $subject . ' | ' . settings('name'),
        );

        return new Envelope(
            subject: 'Password Reset OTP',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'mail.forget_password_otp',
            with: [
                'otp' => $this->data,
            ],
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
