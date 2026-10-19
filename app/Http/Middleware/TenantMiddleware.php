<?php

namespace App\Http\Middleware;

use App\Tenant\TenantManager;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * TenantMiddleware
 *
 * Initialise le contexte multi-tenant (TenantManager) à chaque requête
 * selon l'utilisateur authentifié.
 *
 * - Super Admin  → TenantManager::isSuperAdmin() = true, pas de filtre ecole_id
 * - Autres users → TenantManager::getEcoleId() = user->ecole_id
 * - Non-auth     → TenantManager reste vide (flush)
 */
class TenantMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Reset pour éviter toute contamination entre requêtes (queue workers, tests)
        TenantManager::flush();

        if (auth()->check()) {
            $user = auth()->user();

            if ($user->hasRole('Super Admin')) {
                // Super Admin : accès global, pas de filtre tenant
                TenantManager::setSuperAdmin(true);
            } elseif ($user->ecole_id) {
                // Utilisateur normal : filtre par son école
                TenantManager::setEcoleId($user->ecole_id);
            }
            // Si l'utilisateur n'a pas d'école et n'est pas Super Admin,
            // TenantManager reste vide → EcoleScope bloquera par sécurité (1=0)
        }

        return $next($request);
    }
}
