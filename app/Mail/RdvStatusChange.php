<?php

namespace App\Mail;

use App\Models\RdvRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class RdvStatusChange extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public RdvRequest $rdvRequest
    ) {}

    public function envelope(): Envelope
    {
        $subject = match ($this->rdvRequest->statut) {
            'confirme' => '✅ Votre RDV est confirmé - HRA Dschang',
            'annule' => '❌ Votre RDV a été annulé - HRA Dschang',
            default => '📋 Mise à jour de votre RDV - HRA Dschang',
        };

        return new Envelope(subject: $subject);
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.rdv.status-change',
        );
    }
}
