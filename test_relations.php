<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

echo "=== TEST DES RELATIONS ===\n\n";

// Test de la relation Student->classe
echo "1. Test Student->classe:\n";
$student = App\Models\Student::with('classe')->first();
if ($student) {
    echo "   Étudiant: {$student->nom} {$student->prenom}\n";
    echo "   Classe: " . ($student->classe ? $student->classe->nom : 'Non assigné') . "\n";
} else {
    echo "   Aucun étudiant trouvé\n";
}
echo "\n";

// Test de la relation Classe->students
echo "2. Test Classe->students:\n";
$classe = App\Models\Classe::with('students')->first();
if ($classe) {
    echo "   Classe: {$classe->nom}\n";
    echo "   Nombre d'étudiants: " . $classe->students->count() . "\n";
} else {
    echo "   Aucune classe trouvée\n";
}
echo "\n";

// Test de la relation Student->inscriptions
echo "3. Test Student->inscriptions:\n";
$student = App\Models\Student::with('inscriptions')->first();
if ($student) {
    echo "   Étudiant: {$student->nom} {$student->prenom}\n";
    echo "   Nombre d'inscriptions: " . $student->inscriptions->count() . "\n";
} else {
    echo "   Aucun étudiant trouvé\n";
}
echo "\n";

echo "=== FIN DU TEST ===\n";