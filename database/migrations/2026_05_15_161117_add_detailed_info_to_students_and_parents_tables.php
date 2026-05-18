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
        Schema::table('students', function (Blueprint $table) {
            // Informations personnelles supplémentaires
            $table->string('lieu_naissance')->nullable()->after('date_naissance');
            $table->string('nationalite')->nullable()->after('lieu_naissance');
            $table->string('cni_extrait_numero')->nullable()->after('nationalite');
            
            // Informations scolaires supplémentaires
            $table->string('filiere_serie')->nullable()->after('status');
            $table->string('etablissement_precedent')->nullable()->after('filiere_serie');
            $table->string('statut_inscription')->nullable()->after('etablissement_precedent'); // nouvel élève, redoublant, transféré
            $table->string('groupe_promotion')->nullable()->after('statut_inscription');
            
            // Informations médicales
            $table->string('groupe_sanguin')->nullable();
            $table->text('allergies')->nullable();
            $table->text('maladies')->nullable();
            $table->text('handicap')->nullable();
            $table->string('contact_urgence')->nullable();
            $table->string('medecin_traitant')->nullable();
            
            // Observations
            $table->text('observations')->nullable();
        });

        Schema::table('parents', function (Blueprint $table) {
            $table->string('profession')->nullable()->after('prenom');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('students', function (Blueprint $table) {
            $table->dropColumn([
                'lieu_naissance', 'nationalite', 'cni_extrait_numero',
                'filiere_serie', 'etablissement_precedent', 'statut_inscription', 'groupe_promotion',
                'groupe_sanguin', 'allergies', 'maladies', 'handicap', 'contact_urgence', 'medecin_traitant',
                'observations'
            ]);
        });

        Schema::table('parents', function (Blueprint $table) {
            $table->dropColumn('profession');
        });
    }
};
