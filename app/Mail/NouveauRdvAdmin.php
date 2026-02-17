<?php

namespace App\Mail;

use App\Models\RdvRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class NouveauRdvAdmin extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public RdvRequest $rdvRequest
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: '🔔 Nouveau RDV - ' . $this->rdvRequest->nom_patient . ' (' . $this->rdvRequest->service->nom . ')',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.rdv.nouveau-admin',
        );
    }
}
