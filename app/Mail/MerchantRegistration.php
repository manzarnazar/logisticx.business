<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class MerchantRegistration extends Mailable
{
    use Queueable, SerializesModels;

    private $data, $resend_otp;

    /**
     * Create a new message instance.
     */
    public function __construct($data = null, $resend_otp = false)
    {
        $this->data = $data;
        $this->resend_otp = $resend_otp;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        $subject = $this->resend_otp ? ___('merchant.resend_merchant_registration_code') :  ___('merchant.merchant_registration');

        return new Envelope(
            subject: $subject . ' | ' . settings('name'),
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'mail.signup',
            with: [
                'data' => $this->data,
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
