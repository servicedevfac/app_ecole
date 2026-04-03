<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$service = new \App\Services\BulletinService();
$classes = App\Models\Classe::all();
$annee = App\Models\Annee_scolaire::active();

foreach ($classes as $classe) {
    if ($classe->matieres->count() > 0) {
        $evalCount = App\Models\Evaluation::where('classe_id', $classe->id)->count();
        if ($evalCount > 1) { // classes with more than 1 evaluation
            // try to compute
            $data = $service->getBulletinsData($classe, null, $annee);
            if (!empty($data['bulletins'])) {
                $firstStudent = $data['bulletins'][0];
                $computed = 0;
                foreach ($firstStudent['matieres'] as $mat) {
                    if ($mat['moyenne'] !== null) $computed++;
                }
                echo "Classe " . $classe->id . " - Student " . $firstStudent['student']->id . " has " . $computed . " computed matieres. (Out of " . $classe->matieres->count() . " attached)\n";
            }
        }
    }
}
