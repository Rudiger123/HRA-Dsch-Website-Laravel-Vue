@extends('errors::layout')

@section('title', 'Erreur de requête')

@section('icon')
    <svg class="w-10 h-10 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4v2m0 0v2m0-6v-2m0 0v-2m0 0h2m0 0h2"></path>
    </svg>
@endsection

@section('code', '400')

@section('message', 'Requête invalide')

@section('description')
    La requête envoyée est invalide ou mal formatée. Veuillez vérifier vos paramètres.
@endsection

@section('content')
    <div class="bg-orange-50 border border-orange-200 rounded-lg p-4 text-sm text-orange-700">
        <p class="font-semibold mb-2">Qu'est-ce que cela signifie ?</p>
        <p class="text-xs">Le serveur a rejeté votre requête en raison d'une syntaxe invalide ou de paramètres incorrects.</p>
    </div>
@endsection
