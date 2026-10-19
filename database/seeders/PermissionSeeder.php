<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Liste de toutes les permissions du système (Format: ressource.action)
        $permissions = [
            'utilisateurs.view', 'utilisateurs.create', 'utilisateurs.update', 'utilisateurs.delete',
            'etudiants.view', 'etudiants.create', 'etudiants.update', 'etudiants.delete',
            'classes.view', 'classes.manage',
            'notes.view', 'notes.create', 'notes.update', 'bulletins.generate',
            'absences.view', 'absences.create',
            'paiements.view', 'paiements.create',
        ];

        // 2. Création des permissions
        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission, 'guard_name' => 'web']);
        }

        // 3. Récupération des rôles
        $roleEnseignant = Role::where('name', 'enseignant')->first();
        $roleStaff = Role::where('name', 'staff')->first();
        $roleParent = Role::where('name', 'parent')->first();
        $roleEtudiant = Role::where('name', 'etudiant')->first();

        // 4. Attribution des permissions aux rôles
        if ($roleEnseignant) {
            $roleEnseignant->syncPermissions([
                'etudiants.view', 'classes.view', 'notes.view', 'notes.create', 'notes.update', 'absences.view', 'absences.create'
            ]);
        }

        if ($roleStaff) {
            $roleStaff->syncPermissions([
                'etudiants.view', 'etudiants.create', 'etudiants.update', 
                'classes.view', 'classes.manage',
                'notes.view', 'bulletins.generate',
                'absences.view', 'paiements.view', 'paiements.create'
            ]);
        }

        if ($roleParent) {
            $roleParent->syncPermissions(['notes.view', 'absences.view', 'paiements.view']);
        }

        if ($roleEtudiant) {
            $roleEtudiant->syncPermissions(['notes.view', 'absences.view']);
        }
    }
}
