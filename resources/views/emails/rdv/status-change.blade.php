@extends('emails.layout')

@section('title', 'Mise à jour de votre rendez-vous')

@section('content')
    <div class="greeting">Bonjour {{ $rdvRequest->nom_patient }},</div>

    @if($rdvRequest->statut === 'confirme')
        <p class="text">
            Excellente nouvelle ! Votre demande de rendez-vous à l'HRA Dschang
            a été confirmée par notre équipe médicale.
        </p>

        <div class="alert alert-success">
            ✅ Votre rendez-vous est confirmé. Présentez-vous à l'hôpital le jour convenu.
        </div>

        <div class="info-card">
            <h3>Détails de votre rendez-vous</h3>
            <div class="info-row">
                <span class="info-label">Service</span>
                <span class="info-value">{{ $rdvRequest->service->nom }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Référence</span>
                <span class="info-value">#{{ $rdvRequest->id }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Statut</span>
                <span class="info-value"><span class="badge badge-confirmed">✅ Confirmé</span></span>
            </div>
        </div>

        <div class="info-card">
            <h3>📋 Instructions importantes</h3>
            <ul class="list">
                <li>📄 Munissez-vous de votre carte nationale d'identité ou passeport</li>
                <li>🕐 Arrivez 15 minutes avant l'heure de votre rendez-vous</li>
                <li>📋 Apportez tout dossier médical existant si disponible</li>
                <li>📍 HRA Dschang - Région de l'Ouest, Cameroun</li>
            </ul>
        </div>

    @elseif($rdvRequest->statut === 'annule')
        <p class="text">
            Nous vous informons que votre demande de rendez-vous à l'HRA Dschang
            a malheureusement dû être annulée.
        </p>

        <div class="alert alert-warning">
            ❌ Votre rendez-vous <strong>#{{ $rdvRequest->id }}</strong> a été annulé.
        </div>

        <p class="text">
            Nous sommes désolés pour ce désagrément. Vous pouvez soumettre
            une nouvelle demande de rendez-vous à tout moment sur notre site.
        </p>

        <div class="info-card">
            <h3>Votre demande annulée</h3>
            <div class="info-row">
                <span class="info-label">Service</span>
                <span class="info-value">{{ $rdvRequest->service->nom }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Référence</span>
                <span class="info-value">#{{ $rdvRequest->id }}</span>
            </div>
        </div>

        <div class="actions">
            <a href="{{ config('services.hospital.website') }}/rendez-vous" class="btn">📅 Prendre un nouveau RDV</a>
        </div>
    @endif

    <div class="info-card">
        <h3>Nous contacter</h3>
        <div class="info-row">
            <span class="info-label">📞 Téléphone</span>
            <span class="info-value">+237 233 44 55 66</span>
        </div>
        <div class="info-row">
            <span class="info-label">💬 WhatsApp</span>
            <span class="info-value">+237 677 88 99 00</span>
        </div>
    </div>
@endsection
