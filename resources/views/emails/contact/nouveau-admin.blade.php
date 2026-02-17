@extends('emails.layout')

@section('title', 'Nouveau message de contact')

@section('content')
    <div class="greeting">📬 Nouveau message de contact</div>

    <p class="text">
        Un nouveau message a été reçu via le formulaire de contact du site HRA Dschang.
    </p>

    <div class="info-card">
        <h3>Expéditeur</h3>
        <div class="info-row">
            <span class="info-label">Nom</span>
            <span class="info-value">{{ $contact->nom }}</span>
        </div>
        <div class="info-row">
            <span class="info-label">Email</span>
            <span class="info-value">
                <a href="mailto:{{ $contact->email }}">{{ $contact->email }}</a>
            </span>
        </div>
        <div class="info-row">
            <span class="info-label">Téléphone</span>
            <span class="info-value">{{ $contact->telephone ?: 'Non renseigné' }}</span>
        </div>
        <div class="info-row">
            <span class="info-label">Reçu le</span>
            <span class="info-value">
                {{ \Carbon\Carbon::parse($contact->created_at)->format('d/m/Y à H:i') }}
            </span>
        </div>
    </div>

    <div class="info-card">
        <h3>Message</h3>
        <p style="color: #1f2937; font-size: 14px; line-height: 1.6; white-space: pre-wrap;">{{ $contact->message }}</p>
    </div>

    <div class="actions">
        <a href="{{ config('services.hospital.website') }}/admin/contacts/{{ $contact->id }}" class="btn">📖 Voir le message</a>
        <a href="mailto:{{ $contact->email }}" class="btn btn-secondary">✉️ Répondre par email</a>
    </div>
@endsection
