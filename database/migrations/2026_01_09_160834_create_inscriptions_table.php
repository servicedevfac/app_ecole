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
        Schema::create('inscriptions', function (Blueprint $table) {
            $table->id();

    $table->foreignId('student_id')
        ->constrained('students')
        ->cascadeOnDelete();

    $table->foreignId('annee_scolaire_id')
        ->constrained('annee_scolaires');

    $table->foreignId('cycle_id')
        ->constrained('cycles');

    $table->foreignId('niveau_id')
        ->constrained('niveaux');

    $table->foreignId('classe_id')
        ->constrained('classes');

    $table->enum('status', ['inscrite', 'suspendue', 'abandon'])
        ->default('inscrite');

    $table->timestamps();

    // Un élève ne peut être inscrit qu'une fois par année scolaire
    $table->unique(['student_id', 'annee_scolaire_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inscriptions');
    }
};
