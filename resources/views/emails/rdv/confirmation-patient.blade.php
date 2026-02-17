@extends('emails.layout')

@section('title', 'Confirmation de rendez-vous')

@section('content')
    <div class="greeting">Bonjour {{ $rdvRequest->nom_patient }},</div>

    <p class="text">
        Nous avons bien reçu votre demande de rendez-vous à l'HRA Dschang.
        Notre équipe va l'examiner et vous contactera dans les plus brefs délais
        pour confirmer votre consultation.
    </p>

    <div class="alert alert-success">
        ✅ Votre demande a été enregistrée avec succès. Référence : <strong>#{{ $rdvRequest->id }}</strong>
    </div>

    <div class="info-card">
        <h3>Récapitulatif de votre demande</h3>
        <div class="info-row">
            <span class="info-label">Service</span>
            <span class="info-value">{{ $rdvRequest->service->nom }}</span>
        </div>
        <div class="info-row">
            <span class="info-label">Motif</span>
            <span class="info-value">{{ \Illuminate\Support\Str::limit($rdvRequest->motif, 50) }}</span>
        </div>
        <div class="info-row">
            <span class="info-label">Téléphone</span>
            <span class="info-value">{{ $rdvRequest->telephone }}</span>
        </div>
        <div class="info-row">
            <span class="info-label">Statut</span>
            <span class="info-value"><span class="badge badge-pending">En attente de confirmation</span></span>
        </div>
    </div>

    <div class="info-card">
        <h3>📋 Que se passe-t-il ensuite ?</h3>
        <ul class="list">
            <li>Notre équipe examine votre demande</li>
            <li>Nous vous contactons par téléphone ou WhatsApp</li>
            <li>Votre rendez-vous est confirmé avec un créneau horaire</li>
        </ul>
    </div>

    <hr class="divider">

    <p class="text">
        <strong>Pour toute question, n'hésitez pas à nous contacter :</strong>
    </p>

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
        <div class="info-row">
            <span class="info-label">📧 Email</span>
            <span class="info-value">contact@hradschang.cm</span>
        </div>
        <div class="info-row">
            <span class="info-label">📍 Adresse</span>
            <span class="info-value">Dschang, Région de l'Ouest, Cameroun</span>
        </div>
    </div>

    <div class="actions">
        <a href="{{ config('services.hospital.website') }}" class="btn">🌐 Visiter notre site</a>
    </div>

    <div class="alert alert-info">
        💡 Conservez cet email pour référence future.
        Votre numéro de dossier est : <strong>#{{ $rdvRequest->id }}</strong>
    </div>
@endsection
