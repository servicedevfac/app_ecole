<?php

namespace App\Scopes;

use App\Tenant\TenantManager;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

/**
 * EcoleScope — Global Scope multi-tenant
 *
 * Filtre automatiquement toutes les requêtes Eloquent par `ecole_id`
 * pour les utilisateurs non-Super Admin.
 *
 * Bypass possible via :
 *   - Model::withoutEcoleScope()->get()         (via le trait)
 *   - Model::withoutGlobalScope(EcoleScope::class)->get()
 */
class EcoleScope implements Scope
{
    /**
     * Apply the scope to a given Eloquent query builder.
     */
    public function apply(Builder $builder, Model $model): void
    {
        // 1. Pas de filtre si personne n'est authentifié (public, console, etc.)
        if (! auth()->check()) {
            return;
        }

        $user = auth()->user();

        // 2. Le Super Admin voit tout — pas de filtre
        if ($user->hasRole('Super Admin')) {
            return;
        }

        // 3. Filtre par l'ecole_id du TenantManager (initialisé par TenantMiddleware)
        if (TenantManager::hasEcole()) {
            $builder->where(
                $model->getTable() . '.ecole_id',
                TenantManager::getEcoleId()
            );
            return;
        }

        // 4. Fallback de sécurité : si un user non-Super Admin est connecté
        //    mais que TenantManager n'est pas initialisé, on filtre par son ecole_id direct.
        if ($user->ecole_id) {
            $builder->where(
                $model->getTable() . '.ecole_id',
                $user->ecole_id
            );
            return;
        }

        // 5. Dernier recours : l'utilisateur n'a aucune école assignée,
        //    on retourne un résultat vide pour éviter les fuites de données.
        $builder->whereRaw('1 = 0');
    }

    /**
     * Extend the query builder with a custom method to remove this scope.
     *
     * Allows: Model::withoutGlobalScope(EcoleScope::class)
     */
    public function extend(Builder $builder): void
    {
        // No additional extensions needed — withoutGlobalScope() handles it.
    }
}
