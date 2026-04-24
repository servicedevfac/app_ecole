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
        Schema::table('presences', function (Blueprint $table) {
            $table->foreignId('emploi_du_temps_id')->nullable()->constrained('emploi_du_temps')->onDelete('cascade');
            $table->foreignId('matiere_id')->nullable()->constrained('matieres')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('presences', function (Blueprint $table) {
            $table->dropForeign(['emploi_du_temps_id']);
            $table->dropForeign(['matiere_id']);
            $table->dropColumn(['emploi_du_temps_id', 'matiere_id']);
        });
    }
};
