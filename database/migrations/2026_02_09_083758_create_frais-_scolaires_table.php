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
        Schema::create('frais_scolaires', function (Blueprint $table) {
            $table->id();
            $table->decimal('frais_inscription', 10, 2)->nullable();
            $table->decimal('frais_Scolarité', 10, 2)->nullable();   
            $table->foreignId('niveau_id')->constrained('niveaux');
            $table->foreignId('annee_scolaire_id')->constrained('annee_scolaires');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('frais_scolaires');
    }
};
