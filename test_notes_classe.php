<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

// find all notes for all students in classe 32
$classe_id = 32;
$evals = App\Models\Evaluation::where('classe_id', $classe_id)->get();
echo "Total Evals for classe 32: " . $evals->count() . "\n";
foreach ($evals as $e) {
    echo "Eval: " . $e->id . " - Matiere: " . $e->matiere_id . " - Notes count: " . $e->notes()->count() . "\n";
}
