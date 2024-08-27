<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class InviteUser extends Mailable
{
    use Queueable, SerializesModels;

    public $assessmentintives;
    public $assessmentRecord;
    public $userRecord;
    public $userInput;

    /**
     * Create a new message instance.
     */
    public function __construct($assessmentintives, $assessmentRecord, $userRecord, $userInput)
    {
        $this->assessmentintives = $assessmentintives;
        $this->assessmentRecord = $assessmentRecord;
        $this->userRecord = $userRecord;
        $this->userInput = $userInput;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Invite User',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.invite',
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
