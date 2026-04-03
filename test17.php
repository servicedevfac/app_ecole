<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$classe = App\Models\Classe::find(1);
$annee = App\Models\Annee_scolaire::active();
$service = new \App\Services\BulletinService();

$data = $service->getBulletinsData($classe, null, $annee);
if (count($data['bulletins']) > 0) {
    $firstStudentData = $data['bulletins'][0];
    $count = 0;
    foreach ($firstStudentData['matieres'] as $mat) {
        if ($mat['moyenne'] !== null) {
            $count++;
            echo "Matiere: " . $mat['nom'] . " => " . $mat['moyenne'] . "\n";
        }
    }
    echo "Calculated " . $count . " matieres for Student " . $firstStudentData['student']->id . "\n";
} else {
    echo "No students found.\n";
}
