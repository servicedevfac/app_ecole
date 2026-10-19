<?php

namespace App\Tenant;

use App\Models\Ecole;

/**
 * TenantManager — Gestionnaire de contexte multi-tenant
 *
 * Stocke l'école active pour la requête en cours.
 * Initialisé par TenantMiddleware à chaque requête authentifiée.
 *
 * @example
 *   TenantManager::getEcoleId()   // → int|null
 *   TenantManager::getEcole()     // → Ecole|null
 *   TenantManager::hasEcole()     // → bool
 *   TenantManager::isSuperAdmin() // → bool
 */
class TenantManager
{
    /**
     * L'ID de l'école actuellement active.
     */
    protected static ?int $ecoleId = null;

    /**
     * L'objet Ecole résolu (lazy-loaded).
     */
    protected static ?Ecole $ecole = null;

    /**
     * Indique si l'utilisateur actuel est Super Admin.
     */
    protected static bool $isSuperAdmin = false;

    // ────────────────────────────────────────────────────────────────────────
    // SETTERS
    // ────────────────────────────────────────────────────────────────────────

    /**
     * Définit l'école active à partir de son ID.
     */
    public static function setEcoleId(?int $id): void
    {
        static::$ecoleId = $id;
        static::$ecole = null; // Reset le cache objet
    }

    /**
     * Définit l'objet Ecole directement.
     */
    public static function setEcole(?Ecole $ecole): void
    {
        static::$ecole   = $ecole;
        static::$ecoleId = $ecole?->id;
    }

    /**
     * Marque le contexte comme Super Admin (pas de filtre tenant).
     */
    public static function setSuperAdmin(bool $value = true): void
    {
        static::$isSuperAdmin = $value;
    }

    // ────────────────────────────────────────────────────────────────────────
    // GETTERS
    // ────────────────────────────────────────────────────────────────────────

    /**
     * Retourne l'ID de l'école active.
     */
    public static function getEcoleId(): ?int
    {
        return static::$ecoleId;
    }

    /**
     * Retourne l'objet Ecole (avec lazy-loading).
     */
    public static function getEcole(): ?Ecole
    {
        if (static::$ecole === null && static::$ecoleId !== null) {
            static::$ecole = Ecole::withoutGlobalScopes()->find(static::$ecoleId);
        }

        return static::$ecole;
    }

    /**
     * Vérifie si une école est définie dans le contexte actuel.
     */
    public static function hasEcole(): bool
    {
        return static::$ecoleId !== null;
    }

    /**
     * Vérifie si le contexte actuel est celui d'un Super Admin.
     */
    public static function isSuperAdmin(): bool
    {
        return static::$isSuperAdmin;
    }

    // ────────────────────────────────────────────────────────────────────────
    // RESET
    // ────────────────────────────────────────────────────────────────────────

    /**
     * Remet à zéro le contexte tenant.
     * Utile dans les tests ou entre requêtes queue.
     */
    public static function flush(): void
    {
        static::$ecoleId      = null;
        static::$ecole        = null;
        static::$isSuperAdmin = false;
    }
}
