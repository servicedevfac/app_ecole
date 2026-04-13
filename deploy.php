<?php
/**
 * Script de déploiement simplifié pour le projet SGS.
 * Ce script automatise les étapes de migration, de seeding système et de nettoyage des caches.
 */

function run($command) {
    echo "Exécution de : $command\n";
    passthru($command);
}

echo "--- Démarrage du déploiement ---\n";

// 1. Mise à jour des dépendances si nécessaire (via SSH normalement)
// run('composer install --no-dev --optimize-autoloader');

// 2. Migration de la base de données
run('php artisan migrate --force');

// 3. Seeding des données système (uniquement si nécessaire)
// Note: SystemSeeder est idempotent, donc sans risque.
run('php artisan db:seed --class=SystemSeeder --force');

// 4. Nettoyage et mise en cache
run('php artisan config:cache');
run('php artisan route:cache');
run('php artisan view:cache');

echo "--- Déploiement terminé avec succès ---\n";
