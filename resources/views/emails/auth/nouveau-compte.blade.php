@extends('emails.layout')

@section('title', 'Bienvenue sur HRA Dschang')

@section('content')
    <div class="greeting">Bienvenue {{ $user->name }} ! 👋</div>

    <p class="text">
        Un compte d'administration vous a été créé sur la plateforme HRA Dschang.
        Voici vos identifiants de connexion.
    </p>

    <div class="alert alert-warning">
        🔐 Conservez ces informations en lieu sûr et ne les partagez avec personne.
    </div>

    <div class="info-card">
        <h3>Vos identifiants de connexion</h3>
        <div class="info-row">
            <span class="info-label">URL de connexion</span>
            <span class="info-value">
                <a href="{{ config('services.hospital.website') }}/admin/login">{{ \Illuminate\Support\Str::replace(['https://', 'http://'], '', config('services.hospital.website')) }}/admin/login</a>
            </span>
        </div>
        <div class="info-row">
            <span class="info-label">Email</span>
            <span class="info-value">{{ $user->email }}</span>
        </div>
        <div class="info-row">
            <span class="info-label">Mot de passe</span>
            <span class="info-value">
                <code style="background: #f0f0f0; padding: 4px 8px; border-radius: 4px; font-family: monospace;">{{ $password }}</code>
            </span>
        </div>
        <div class="info-row">
            <span class="info-label">Rôle assigné</span>
            <span class="info-value">{{ $user->roles->first()?->name ?? 'Non défini' }}</span>
        </div>
    </div>

    <div class="actions">
        <a href="{{ config('services.hospital.website') }}/admin/login" class="btn">🔐 Se connecter maintenant</a>
    </div>

    <div class="alert alert-warning">
        ⚠️ Important : Pour votre sécurité, changez votre mot de passe
        dès votre première connexion via Mon Profil → Changer le mot de passe.
    </div>
@endsection
