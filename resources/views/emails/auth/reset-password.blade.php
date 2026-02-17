@extends('emails.layout')

@section('title', 'Réinitialisation du mot de passe')

@section('content')
    <div class="container">
        <div class="header">
            <div class="header-logo">
                <span style="font-size: 32px;">🔐</span>
            </div>
            <h1>Réinitialisation du mot de passe</h1>
            <p>Plateforme administrative HRA Dschang</p>
        </div>

        <div class="body">
            <div class="greeting">Bonjour {{ $userName }},</div>

            <div class="text">
                Vous avez demandé la réinitialisation de votre mot de passe. Cliquez sur le bouton ci-dessous pour définir un nouveau mot de passe.
            </div>

            <div style="text-align: center; margin: 32px 0;">
                <a href="{{ $resetUrl }}" style="display: inline-block; background: linear-gradient(135deg, #00A651, #007a3d); color: #ffffff; text-decoration: none; padding: 14px 32px; border-radius: 8px; font-weight: 600; font-size: 15px; transition: all 0.3s ease;">
                    Réinitialiser mon mot de passe
                </a>
            </div>

            <div class="info-card">
                <h3>⏰ Important</h3>
                <div style="font-size: 14px; color: #4b5563; line-height: 1.6;">
                    <p style="margin-bottom: 8px;">
                        <strong>Ce lien expire dans {{ $expiryTime }} minutes.</strong> Si vous n'utilisez pas ce lien avant l'expiration, vous devrez demander une nouvelle réinitialisation.
                    </p>
                </div>
            </div>

            <div style="background: #fef3c7; border-left: 4px solid #fbbf24; padding: 16px; border-radius: 4px; margin: 24px 0;">
                <p style="margin: 0; font-size: 13px; color: #78350f;">
                    <strong>Sécurité :</strong> Ne partagez ce lien avec personne. Nous ne vous demanderons jamais votre mot de passe par email.
                </p>
            </div>

            <div class="text" style="margin-top: 32px; padding-top: 24px; border-top: 1px solid #e5e7eb;">
                Vous n'avez pas demandé cette réinitialisation ? Ignorez cet email en toute sécurité. Votre compte reste protégé.
            </div>

            <div style="text-align: center; margin-top: 32px; font-size: 12px; color: #9ca3af;">
                <p>Si le bouton ci-dessus ne fonctionne pas, copiez et collez cette URL dans votre navigateur :</p>
                <p style="word-break: break-all; color: #6b7280; margin-top: 8px;">
                    {{ $resetUrl }}
                </p>
            </div>
        </div>

        <div style="background: #f3f4f6; padding: 24px 40px; text-align: center; font-size: 12px; color: #6b7280; border-top: 1px solid #e5e7eb;">
            <p style="margin: 0;">HRA Dschang - Centre Médical</p>
            <p style="margin: 4px 0 0;">Dschang, Cameroun</p>
            <p style="margin: 8px 0 0; font-size: 11px;">
                © {{ date('Y') }} HRA Dschang. Tous droits réservés.
            </p>
        </div>
    </div>
@endsection
