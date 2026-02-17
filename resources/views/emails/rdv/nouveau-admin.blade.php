@extends('emails.layout')

@section('title', 'Nouveau RDV')

@section('content')
    <div class="greeting">🔔 Nouvelle demande de rendez-vous</div>

    <p class="text">
        Une nouvelle demande de rendez-vous a été soumise sur le site HRA Dschang.
        Veuillez la traiter dans les meilleurs délais.
    </p>

    <div class="info-card">
        <h3>Informations du patient</h3>
        <div class="info-row">
            <span class="info-label">Nom complet</span>
            <span class="info-value">{{ $rdvRequest->nom_patient }}</span>
        </div>
        <div class="info-row">
            <span class="info-label">Âge</span>
            <span class="info-value">{{ $rdvRequest->age }} ans</span>
        </div>
        <div class="info-row">
            <span class="info-label">Téléphone</span>
            <span class="info-value">{{ $rdvRequest->telephone }}</span>
        </div>
        <div class="info-row">
            <span class="info-label">Service demandé</span>
            <span class="info-value">{{ $rdvRequest->service->nom }}</span>
        </div>
        <div class="info-row">
            <span class="info-label">Confirmation WhatsApp</span>
            <span class="info-value">{{ $rdvRequest->confirmation_whatsapp ? '✅ Oui' : '❌ Non' }}</span>
        </div>
        <div class="info-row">
            <span class="info-label">Statut</span>
            <span class="info-value"><span class="badge badge-pending">En attente</span></span>
        </div>
    </div>

    <div class="info-card">
        <h3>Motif de consultation</h3>
        <p style="color: #1f2937; font-size: 14px; line-height: 1.6;">{{ $rdvRequest->motif }}</p>
    </div>

    <div class="alert alert-info">
        <strong>Reçu le</strong><br>
        {{ \Carbon\Carbon::parse($rdvRequest->created_at)->format('d/m/Y à H:i') }}
    </div>

    <div class="actions">
        <a href="{{ config('services.hospital.website') }}/admin/rdv-requests/{{ $rdvRequest->id }}" class="btn">👁️ Voir la demande</a>
        <a href="{{ config('services.hospital.website') }}/admin/rdv-requests" class="btn btn-secondary">📋 Toutes les demandes</a>
    </div>

    <div class="alert alert-warning">
        ⏰ Cette demande attend votre traitement. Pensez à contacter le patient
        rapidement pour confirmer ou annuler le rendez-vous.
    </div>
@endsection
