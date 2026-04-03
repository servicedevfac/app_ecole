<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$classe = App\Models\Classe::find(31);
$annee = App\Models\Annee_scolaire::active();
$service = new \App\Services\BulletinService();

// Let's generate for Periode 6, or Annual to see
$dataAnnual = $service->getBulletinsData($classe, null, $annee);
if (count($dataAnnual['bulletins']) > 0) {
    echo "Annual calculation for Classe 31:\n";
    $firstStudentData = $dataAnnual['bulletins'][0];
    $count = 0;
    foreach ($firstStudentData['matieres'] as $mat) {
        if ($mat['moyenne'] !== null) $count++;
    }
    echo "- Matieres computed: " . $count . "\n";
}
