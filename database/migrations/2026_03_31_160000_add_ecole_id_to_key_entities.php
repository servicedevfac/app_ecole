<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $tables = [
            'users',
            'students',
            'cycles',
            'niveaux',
            'classes',
            'annee_scolaires',
            'parents',
            'relations',
            'inscriptions',
            'enseignants',
            'matieres',
            'matiere_classe',
            'affectations_pedagogiques',
            'emploi_du_temps',
            'horaires',
            'evaluations',
            'notes',
            'frais_scolaires',
            'factures',
            'facture_lignes',
            'periodes',
            'payments',
            'student_documents',
            'presences',
        ];

        foreach ($tables as $tableName) {
            if (Schema::hasTable($tableName)) {
                Schema::table($tableName, function (Blueprint $table) use ($tableName) {
                    if (!Schema::hasColumn($tableName, 'ecole_id')) {
                        $table->foreignId('ecole_id')->nullable()->constrained('ecoles')->onDelete('cascade');
                    }
                });
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $tables = [
            'users',
            'students',
            'cycles',
            'niveaux',
            'classes',
            'annee_scolaires',
            'parents',
            'relations',
            'inscriptions',
            'enseignants',
            'matieres',
            'matiere_classe',
            'affectations_pedagogiques',
            'emploi_du_temps',
            'horaires',
            'evaluations',
            'notes',
            'frais_scolaires',
            'factures',
            'facture_lignes',
            'periodes',
            'payments',
            'student_documents',
            'presences',
        ];

        foreach ($tables as $tableName) {
            if (Schema::hasTable($tableName)) {
                Schema::table($tableName, function (Blueprint $table) use ($tableName) {
                    if (Schema::hasColumn($tableName, 'ecole_id')) {
                        $table->dropForeign([ 'ecole_id' ]);
                        $table->dropColumn('ecole_id');
                    }
                });
            }
        }
    }
};
