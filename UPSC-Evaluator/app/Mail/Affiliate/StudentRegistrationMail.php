<?php

namespace App\Mail\Affiliate;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Address;

class StudentRegistrationMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;
    private $user;
    private $affiliater_name;

    /**
     * Create a new message instance.
     */
    public function __construct($user, $affiliater_name)
    {
        $this->user = $user;
        $this->affiliater_name = $affiliater_name;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: "New Successful Referral: {$this->user->name} has joined Aspire Scan!",
            cc: [
                new Address("ganesh@thepotenzials.com"),
            ],
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'student.email.affiliate.student-register',
            with: [
                'user' => $this->user,
                'affiliater_name' => $this->affiliater_name
            ]
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
