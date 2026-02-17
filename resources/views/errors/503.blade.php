@extends('errors::layout')

@section('title', 'Service indisponible')

@section('icon')
    <svg class="w-10 h-10 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.172l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"></path>
    </svg>
@endsection

@section('code', '503')

@section('message', 'Service indisponible')

@section('description')
    Le service est actuellement indisponible pour maintenance. Nous devrions être de retour bientôt.
@endsection

@section('content')
    <div class="bg-red-50 border border-red-200 rounded-lg p-4 text-sm text-red-700 space-y-2">
        <p class="font-semibold">Maintenance en cours</p>
        <p class="text-xs">Nous travaillons dur pour améliorer votre expérience. Merci de votre patience.</p>
        <p class="text-xs font-semibold mt-3">Durée estimée : Moins d'une heure</p>
    </div>
@endsection
