@extends('errors::layout')

@section('title', 'Session expirée')

@section('icon')
    <svg class="w-10 h-10 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
    </svg>
@endsection

@section('code', '419')

@section('message', 'Page expirée')

@section('description')
    Votre session a expiré pour des raisons de sécurité. Veuillez vous reconnecter.
@endsection

@section('content')
    <div class="bg-purple-50 border border-purple-200 rounded-lg p-4 text-sm text-purple-700 space-y-3">
        <p class="font-semibold">Raison :</p>
        <p class="text-xs">Pour votre sécurité, les sessions inactives expirent après une certaine période.</p>
        <p class="text-xs font-semibold mt-3">Solution :</p>
        <p class="text-xs">Veuillez vous reconnecter à votre compte.</p>
    </div>
@endsection
