<?php

namespace App\Traits;

use App\Models\Ecole;
use App\Scopes\EcoleScope;
use App\Tenant\TenantManager;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Trait BelongsToEcole
 *
 * Applique automatiquement le filtre multi-tenant (EcoleScope) à tous
 * les modèles qui ont une colonne `ecole_id`.
 *
 * Fonctionnalités :
 *  - Filtrage automatique par ecole_id sur toutes les requêtes
 *  - Assignation automatique de l'ecole_id à la création
 *  - Méthode withoutEcoleScope() pour bypasser le scope ponctuellement
 *  - Relation ecole() prête à l'emploi
 *
 * @example Bypass ponctuel :
 *   Student::withoutEcoleScope()->get();       // tous les étudiants
 *   Classe::withoutEcoleScope()->find(5);      // ignore le filtre tenant
 *
 * @example Usage normal (filtré automatiquement) :
 *   Student::all();                             // seulement l'école courante
 *   Classe::where('nom', 'CP1')->first();
 */
trait BelongsToEcole
{
    /**
     * Boot du trait : enregistre le Global Scope et l'auto-assignation.
     */
    protected static function bootBelongsToEcole(): void
    {
        // ── 1. Global Scope : filtre par ecole_id automatiquement ──────────
        static::addGlobalScope(new EcoleScope());

        // ── 2. Auto-assignation à la création ──────────────────────────────
        static::creating(function ($model) {
            // N'écrase pas si déjà défini explicitement
            if (! empty($model->ecole_id)) {
                return;
            }

            // Depuis le TenantManager (source principale)
            if (TenantManager::hasEcole()) {
                $model->ecole_id = TenantManager::getEcoleId();
                return;
            }

            // Fallback : depuis l'utilisateur authentifié directement
            if (auth()->check() && auth()->user()->ecole_id) {
                $model->ecole_id = auth()->user()->ecole_id;
            }
        });
    }

    // ────────────────────────────────────────────────────────────────────────
    // QUERY SCOPES
    // ────────────────────────────────────────────────────────────────────────

    /**
     * Scope local pour désactiver ponctuellement le filtre tenant.
     *
     * @example Student::withoutEcoleScope()->paginate()
     * @example Classe::withoutEcoleScope()->where('ecole_id', 3)->get()
     */
    public function scopeWithoutEcoleScope($query)
    {
        return $query->withoutGlobalScope(EcoleScope::class);
    }

    /**
     * Scope local pour filtrer explicitement par une école donnée.
     *
     * @example Student::forEcole(2)->get()
     */
    public function scopeForEcole($query, int $ecoleId)
    {
        return $query->withoutGlobalScope(EcoleScope::class)
                     ->where($this->getTable() . '.ecole_id', $ecoleId);
    }

    // ────────────────────────────────────────────────────────────────────────
    // RELATIONS
    // ────────────────────────────────────────────────────────────────────────

    /**
     * Relation vers l'école propriétaire de cette ressource.
     */
    public function ecole(): BelongsTo
    {
        return $this->belongsTo(Ecole::class, 'ecole_id');
    }

    // ────────────────────────────────────────────────────────────────────────
    // HELPERS
    // ────────────────────────────────────────────────────────────────────────

    /**
     * Vérifie si cette ressource appartient à l'école active.
     */
    public function belongsToCurrentEcole(): bool
    {
        return $this->ecole_id === TenantManager::getEcoleId();
    }
}
