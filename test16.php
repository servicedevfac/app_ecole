<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

// let's fetch evaluations directly to see which ones have notes
$evals = App\Models\Evaluation::has('notes')->get();
echo "Total evaluations with notes: " . $evals->count() . "\n";
$matiereGroup = $evals->groupBy('matiere_id');
echo "Total matieres evaluated: " . $matiereGroup->count() . "\n";
foreach ($matiereGroup as $mat_id => $evs) {
    echo "Matiere $mat_id has " . $evs->count() . " evaluations with notes\n";
}
