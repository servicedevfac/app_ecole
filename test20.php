<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$classe = App\Models\Classe::find(7);
$annee = App\Models\Annee_scolaire::active();
$service = new \App\Services\BulletinService();

$data = $service->getBulletinsData($classe, null, $annee);
if (count($data['bulletins']) > 0) {
    foreach ($data['bulletins'] as $studentData) {
        $count = 0;
        foreach ($studentData['matieres'] as $mat) {
            if ($mat['moyenne'] !== null) $count++;
        }
        echo "Student " . $studentData['student']->id . " has " . $count . " calculated matieres out of " . count($studentData['matieres']) . "\n";
    }
} else {
    echo "No students found.\n";
}
