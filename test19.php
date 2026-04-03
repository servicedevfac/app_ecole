<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

// find evaluations for Matiere 4
$evals = App\Models\Evaluation::where('matiere_id', 4)->has('notes')->get();
foreach($evals as $e) {
    echo "Eval: " . $e->id . " - Classe: " . $e->classe_id . " - Notes: " . $e->notes()->count() . "\n";
}
