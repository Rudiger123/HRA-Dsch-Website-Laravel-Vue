<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Inertia\Middleware;
use App\Models\Contact;
use Tightenco\Ziggy\Ziggy;

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

			'auth' => [
				'user' => $request->user() ? [
					'id' => $request->user()->id,
					'name' => $request->user()->name,
					'email' => $request->user()->email,
					'phone' => $request->user()->phone,
					'photo' => $request->user()->photo,
					'photo_url' => $request->user()->photo_url,
					'is_active' => $request->user()->is_active,
					'role' => $request->user()->getRoleNames()->first(),
					'permissions' => $request->user()->getAllPermissions()->pluck('name'),
				] : null,
			],
			'flash' => [
				'success' => fn () => $request->session()->get('success'),
				'error' => fn () => $request->session()->get('error'),
				'info' => fn () => $request->session()->get('info'),
			],
			'unread_messages_count' => fn () => $request->user() && $request->user()->can('view_contacts')
				? Contact::where('lu', false)->count()
				: 0,
			'unread_notifications_count' => 0, // TODO: Implémenter système notifications
			'ziggy' => fn () => [
				'routes' => (new Ziggy)->toArray(),
				'url' => url('/'),
			],
		];
	}
}
