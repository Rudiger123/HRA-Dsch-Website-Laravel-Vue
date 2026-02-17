<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PasswordResetMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public string $token,
        public string $email,
        public string $userName = 'Utilisateur'
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: '🔐 Réinitialisation de votre mot de passe - HRA Dschang',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.auth.reset-password',
            with: [
                'resetUrl' => url('/admin/reset-password/' . $this->token . '?email=' . urlencode($this->email)),
                'userName' => $this->userName,
                'expiryTime' => config('auth.passwords.users.expire', 60),
            ],
        );
    }
}
