<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$evals = App\Models\Evaluation::where('classe_id', 1)->get();
foreach($evals as $e) { 
    echo $e->id . ' - Periode: ' . $e->periode_id . "\n"; 
}
