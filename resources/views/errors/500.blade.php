@extends('errors::layout')

@section('title', 'Erreur serveur')

@section('icon')
    <svg class="w-10 h-10 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4v2m0 4v2M8 5h8a2 2 0 012 2v12a2 2 0 01-2 2H8a2 2 0 01-2-2V7a2 2 0 012-2z"></path>
    </svg>
@endsection

@section('code', '500')

@section('message', 'Erreur serveur')

@section('description')
    Une erreur interne s'est produite sur le serveur. Nos équipes ont été alertées et travaillent pour résoudre le problème.
@endsection

@section('content')
    <div class="bg-red-50 border border-red-200 rounded-lg p-4 text-sm text-red-700 space-y-2">
        <p class="font-semibold">Ce que vous pouvez faire :</p>
        <ul class="list-disc list-inside space-y-1 text-xs">
            <li>Rafraîchir la page et réessayer</li>
            <li>Vider le cache de votre navigateur</li>
            <li>Revenir plus tard</li>
            <li>Contacter le support si le problème persiste</li>
        </ul>
    </div>
@endsection
