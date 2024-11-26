<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Address;

class ParticipanRegistered extends Mailable
{
    use Queueable, SerializesModels;

    public $participant;
    public $qr_code;
    public $path;

    public function __construct($participant, $qr_code = null, $path = null)
    {
        $this->participant = $participant;
        $this->qr_code = $qr_code;
        $this->path = $path;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            from: new Address("noreply@meetap.com", "MeetAp mail"),
            subject: "Register Participant",
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'email.participant_registered',
        );
    }

    public function attachments(): array
    {
        if ($this->path !== null) {
            return [
                Attachment::fromPath($this->path),
            ];
        }
        return [];
    }
}


