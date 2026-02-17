@extends('errors::layout')

@section('title', 'Page non trouvée')

@section('icon')
    <svg class="w-10 h-10 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
    </svg>
@endsection

@section('code', '404')

@section('message', 'Page non trouvée')

@section('description')
    La page que vous recherchez n'existe pas ou a été déplacée.
@endsection

@section('content')
    <div class="bg-orange-50 border border-orange-200 rounded-lg p-4 text-sm text-orange-700">
        <p class="font-semibold mb-2">URL demandée :</p>
        <p class="font-mono text-xs break-all">{{ request()->url() }}</p>
    </div>
@endsection
