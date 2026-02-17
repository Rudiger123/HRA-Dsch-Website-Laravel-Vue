@extends('errors::layout')

@section('title', 'Accès refusé')

@section('icon')
    <svg class="w-10 h-10 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
    </svg>
@endsection

@section('code', '403')

@section('message', 'Accès refusé')

@section('description')
    Vous n'avez pas la permission d'accéder à cette ressource. Vérifiez vos droits d'accès ou contactez un administrateur.
@endsection

@section('content')
    <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 text-sm text-yellow-700 space-y-2">
        <p class="font-semibold">Raisons possibles :</p>
        <ul class="list-disc list-inside space-y-1 text-xs">
            <li>Vous n'avez pas les permissions nécessaires</li>
            <li>Votre compte a été désactivé</li>
            <li>Vous n'êtes pas connecté</li>
        </ul>
    </div>
@endsection
