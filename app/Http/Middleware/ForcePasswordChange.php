<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class ForcePasswordChange
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check() && Auth::user()->must_change_password) {
            // Ne pas rediriger si on est déjà sur la page de changement de mot de passe ou si on se déconnecte
            if (!$request->routeIs('parent.password.change', 'parent.password.update', 'logout')) {
                return redirect()->route('parent.password.change')
                    ->with('warning', 'Vous devez changer votre mot de passe pour continuer.');
            }
        }

        return $next($request);
    }
}
