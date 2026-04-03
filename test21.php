<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$classes = App\Models\Classe::has('matieres')->get();
foreach ($classes as $classe) {
    $evals = App\Models\Evaluation::where('classe_id', $classe->id)->has('notes')->get();
    if ($evals->count() > 0) {
        // Group by matiere to see how many different matieres were evaluated
        $evalMatieres = $evals->pluck('matiere_id')->unique()->count();
        echo "Classe " . $classe->id . " has " . $classe->matieres->count() . " matieres. Evaluated: " . $evalMatieres . "\n";
    }
}
