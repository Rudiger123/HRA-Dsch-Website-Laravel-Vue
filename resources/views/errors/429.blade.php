@extends('errors::layout')

@section('title', 'Trop de requêtes')

@section('icon')
    <svg class="w-10 h-10 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
    </svg>
@endsection

@section('code', '429')

@section('message', 'Trop de requêtes')

@section('description')
    Vous avez effectué trop de requêtes dans un court laps de temps. Veuillez attendre quelques minutes.
@endsection

@section('content')
    <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 text-sm text-blue-700 space-y-2">
        <p class="font-semibold">Limitation de débit activée</p>
        <p class="text-xs">Cette protection empêche les abus et maintient les performances du système pour tous les utilisateurs.</p>
        <p class="text-xs font-semibold mt-3">Attendez quelques minutes avant de réessayer.</p>
    </div>
@endsection
