<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Inertia\Middleware;

class HandleInertiaRequests extends Middleware
{
	/**
	 * La version de l'asset racine.
	 * Utilisé pour forcer le rechargement des assets côté client.
	 *
	 * @return string|null
	 */
	public function version(Request $request): ?string
	{
		return parent::version($request);
	}

	/**
	 * Données partagées avec toutes les pages Inertia.
	 * Accessible via $page.props dans les composants Vue.
	 *
	 * @return array<string, mixed>
	 */
	public function share(Request $request): array
	{
		return [
			...parent::share($request),

			// Informations de l'utilisateur authentifié
			'auth' => [
				'user' => $request->user(),
			],

			// Messages flash de session
			'flash' => [
				'success' => fn () => $request->session()->get('success'),
				'error' => fn () => $request->session()->get('error'),
				'warning' => fn () => $request->session()->get('warning'),
				'info' => fn () => $request->session()->get('info'),
			],

			// Erreurs de validation
			'errors' => fn () => $request->session()->get('errors')
				? $request->session()->get('errors')->getBag('default')->getMessages()
				: (object) [],
		];
	}
}
