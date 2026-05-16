<?php

namespace App\Mail\Institute;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Address;

class CompleteUploadedFileBatch extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;
    private $institute_upload_batch;

    /**
     * Create a new message instance.
     */
    public function __construct($institute_upload_batch)
    {
        $this->institute_upload_batch = $institute_upload_batch;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Uploaded File Batch Completed',
            cc: [
                new Address("ganesh@thepotenzials.com"),
                new Address("ganeshrode399@gmail.com")
            ],
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'institute.email.complete-uploaded-batch',
            with: [
                'institute_upload_batch' => $this->institute_upload_batch
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
