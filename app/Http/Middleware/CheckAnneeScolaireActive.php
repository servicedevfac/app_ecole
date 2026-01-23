<?php

namespace App\Http\Middleware;

use App\Models\Annee_scolaire;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckAnneeScolaireActive
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $activeYear = Annee_scolaire::active();

        if (!$activeYear) {
            return redirect()->route('admin.annee.index')->with('error', 'Veuillez activer une année scolaire.');
        }

        return $next($request);
    }
}
