<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$service = new \App\Services\BulletinService();
$classes = App\Models\Classe::has('matieres')->get();
$periodes = App\Models\Periode::all();
$annees = App\Models\Annee_scolaire::all();

foreach ($classes as $classe) {
    foreach ($annees as $annee) {
        $dataAnnual = $service->getBulletinsData($classe, null, $annee);
        if (!empty($dataAnnual['bulletins'])) {
            $student = $dataAnnual['bulletins'][0];
            $count = 0;
            foreach ($student['matieres'] as $mat) {
                if ($mat['moyenne'] !== null) $count++;
            }
            if ($count > 1) {
                echo "BINGO! Classe " . $classe->id . " Annee " . $annee->id . " Student " . $student['student']->id . " -> computed matieres: " . $count . "\n";
            }
        }
    }
}
