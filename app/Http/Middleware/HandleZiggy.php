<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Tighten\Ziggy\Ziggy as TightenZiggy;

class HandleZiggy
{
    /**
     * Handle an incoming request.
     *
     * @param  Request  $request
     * @param  Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        Inertia::share([
            'ziggy' => function () {
                return [
                    'routes' => (new TightenZiggy())->toArray(),
                    'url' => url('/'),
                ];
            },
        ]);

        return $next($request);
    }
}
