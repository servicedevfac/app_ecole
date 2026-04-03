<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$student = App\Models\Student::find(327); // Reusing the student ID from earlier analysis
if (!$student) {
    echo "Student 327 missing.\n";
    die();
}
$lastInscription = $student->inscriptions()->where('status', 'inscrite')->first();
if (!$lastInscription) {
    echo "No inscription.\n";
    die();
}
$classe = $lastInscription->classe;
$annee = $lastInscription->anneeScolaire;

echo "Classe: " . $classe->id . " (" . $classe->matieres->count() . " matieres attached)\n";
echo "Annee: " . $annee->id . "\n";

$service = new \App\Services\BulletinService();
$data = $service->getBulletinsData($classe, null, $annee);

$studentData = collect($data['bulletins'])->firstWhere('student.id', $student->id);

if ($studentData) {
    $countedMatieres = 0;
    foreach ($studentData['matieres'] as $id => $mat) {
        if ($mat['moyenne'] !== null) {
             echo "Matiere: " . $mat['nom'] . " => Note: " . $mat['moyenne'] . "\n";
             $countedMatieres++;
        }
    }
    echo "\nTotal matieres calculées: " . $countedMatieres . "\n";
    echo "Moyenne generale: " . $studentData['moyenne_generale'] . "\n";
} else {
    echo "Student not generated inside bulletin.\n";
}
