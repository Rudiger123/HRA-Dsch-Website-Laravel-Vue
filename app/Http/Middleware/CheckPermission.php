<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Auth\Access\AuthorizationException;
use Symfony\Component\HttpFoundation\Response;

class CheckPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$permissions): Response
    {
        if (!$request->user()) {
            throw new AuthorizationException('Unauthorized');
        }

        // Si aucune permission n'est spécifiée, laisser passer
        if (empty($permissions)) {
            return $next($request);
        }

        // Vérifier si l'utilisateur a au moins une des permissions
        foreach ($permissions as $permission) {
            if ($request->user()->can($permission)) {
                return $next($request);
            }
        }

        throw new AuthorizationException('You do not have the required permission.');
    }
}
