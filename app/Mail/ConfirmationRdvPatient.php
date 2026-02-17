<?php

namespace App\Mail;

use App\Models\RdvRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ConfirmationRdvPatient extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public RdvRequest $rdvRequest
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: '✅ Demande de RDV reçue - HRA Dschang',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.rdv.confirmation-patient',
        );
    }
}
