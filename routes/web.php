<?php

use App\Http\Controllers\AffectationsPedagogiquesController;
use App\Http\Controllers\AnneeScolaireController;
use App\Http\Controllers\AssignematiereController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EcoleController;
use App\Http\Controllers\EvaluationController;
use App\Http\Controllers\NoteController;
use App\Http\Controllers\PeriodeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\ClasseController;
use App\Http\Controllers\CycleController;
use App\Http\Controllers\EmploiDuTempsController;
use App\Http\Controllers\EnseignantController;
use App\Http\Controllers\FraisScolaireController;
use App\Http\Controllers\InscriptionController;
use App\Http\Controllers\MatiereController;
use App\Http\Controllers\NiveauController;
use App\Http\Controllers\ParentController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\TypesFraisController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Le dashboard est géré par DashboardController dans le groupe auth ci-dessous

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
Route::get('/student-details', function () {
    return view('student-details');  // Assure-toi que le fichier est dans resources/views
});



/*
|--------------------------------------------------------------------------
| ROUTES PROTÉGÉES
|--------------------------------------------------------------------------
*/
Route::middleware('auth', 'role:Super Admin|admin|enseignant|staff|parent|Comptable')->group(function () {

    /*
    |--------------------------------------------------------------------------
    | DASHBOARD
    |--------------------------------------------------------------------------
    */
    Route::get('/dashboard', [\App\Http\Controllers\DashboardController::class, 'index'])
        ->name('dashboard');

    /*
    |--------------------------------------------------------------------------
    | UTILISATEURS & RBAC (ADMIN)
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | ÉLÈVES (STUDENTS)
    |--------------------------------------------------------------------------
    */
    Route::prefix('students')->middleware('permission:etudiants.view')->group(function () {
        Route::get('/', [StudentController::class, 'index'])->name('admin.etudiant.index');
        Route::get('/create', [StudentController::class, 'create'])->name('admin.etudiant.create');
        Route::post('/', [StudentController::class, 'store'])->name('admin.etudiant.store');
        Route::get('/affectation', [InscriptionController::class, 'create'])->name('admin.etudiant.affectation');
        Route::post('/affectation', [InscriptionController::class, 'store'])->name('admin.etudiant.affect');

        Route::get('/{id}', [StudentController::class, 'show'])->name('admin.etudiant.show');
        Route::get('/{id}/edit', [StudentController::class, 'edit'])->name('admin.etudiant.edit');
        Route::put('/{id}', [StudentController::class, 'update'])->name('admin.etudiant.update');
        Route::delete('/{id}', [StudentController::class, 'destroy'])->name('admin.etudiant.destroy');

        Route::get('/{student_id}/documents', [\App\Http\Controllers\StudentDocumentController::class, 'index'])->name('admin.etudiant.documents.index');
        Route::post('/documents', [\App\Http\Controllers\StudentDocumentController::class, 'store'])->name('admin.etudiant.documents.store');
        Route::get('/documents/{document}/download', [\App\Http\Controllers\StudentDocumentController::class, 'download'])->name('admin.etudiant.documents.download');
        Route::delete('/documents/{document}', [\App\Http\Controllers\StudentDocumentController::class, 'destroy'])->name('admin.etudiant.documents.destroy');
    });

    /*
    |--------------------------------------------------------------------------
    | CLASSES
    |--------------------------------------------------------------------------
    */
    Route::resource('classes', ClasseController::class)->names('admin.classe')->middleware('permission:classes.view');

    /*
    |--------------------------------------------------------------------------
    | CYCLES
    |--------------------------------------------------------------------------
    */
    Route::resource('emploi_du_temps', EmploiDuTempsController::class)->names('admin.emploi_du_temps');
    //Route::resource('attendences',AttendenceController::class)->names('admin.attendence');
    Route::resource('matieres', MatiereController::class)->names('admin.matiere');
    Route::resource('cycles', CycleController::class)->names('admin.cycle');
    /*
    |--------------------------------------------------------------------------
    | NIVEAUX
    |--------------------------------------------------------------------------
    */
    Route::resource('niveaux', NiveauController::class)->names('admin.niveau');

    /*
    |--------------------------------------------------------------------------
    | PAIRETS
    |--------------------------------------------------------------------------
    */
    Route::resource('parents', ParentController::class)->names('admin.parent');

    /*
    |--------------------------------------------------------------------------
    | ANNEES SCOLAIRES
    |--------------------------------------------------------------------------
    */
    Route::resource('annees', AnneeScolaireController::class)->names('admin.annee');
    Route::post('/annee-scolaire/{id}/activate', [AnneeScolaireController::class, 'activate'])->name('admin.annee.activate');
    Route::post('/annee-scolaire/{id}/cloturer', [AnneeScolaireController::class, 'cloturer'])->name('admin.annee.cloturer');
    Route::get('/annee-scolaire/{id}/export-zip', [AnneeScolaireController::class, 'exportZip'])->name('admin.annee.export_zip');
    Route::resource('periodes', PeriodeController::class)->names('admin.periodes');

    /*
    |--------------------------------------------------------------------------
    | INSCRIPTIONS
    |--------------------------------------------------------------------------
    */
    Route::resource('inscriptions', InscriptionController::class)->names('admin.inscription');

    /*
    |--------------------------------------------------------------------------
    | ENSEIGNANTS
    |--------------------------------------------------------------------------
    */
    Route::resource('enseignants', EnseignantController::class)->names('admin.enseignant');

    /*
    |--------------------------------------------------------------------------
    | MATIÈRES
    |--------------------------------------------------------------------------
    */
    Route::resource('matieres', MatiereController::class)->names('admin.matiere');
    /*
    |--------------------------------------------------------------------------
    | ASSIGNATION DE MATIÈRES
    |--------------------------------------------------------------------------
    */
    Route::resource('assignematiere', AssignematiereController::class)->names('admin.matiere.assignematiere');

    /*
    |--------------------------------------------------------------------------
    | AFFECTATIONS PÉDAGOGIQUES
    |--------------------------------------------------------------------------
    */
    Route::resource('affectations', AffectationsPedagogiquesController::class)->names('admin.affectation');

    /*
    |--------------------------------------------------------------------------
    | EVALUATION
    |--------------------------------------------------------------------------
    */
    Route::resource('evaluations', EvaluationController::class)->names('admin.evaluations')->middleware('permission:notes.view');
    Route::get('/ecoles/settings', [EcoleController::class, 'settings'])->name('admin.ecole.settings');
    Route::put('/ecoles/settings/{ecole}', [EcoleController::class, 'update'])->name('admin.ecole.update_settings');

    /*
    |--------------------------------------------------------------------------
    | NOTES
    |--------------------------------------------------------------------------
    */
    // Routes spécifiques pour la saisie des notes d'une évaluation
    Route::get('/evaluations/{evaluation}/notes', [NoteController::class, 'create'])->name('admin.evaluations.notes.create');
    Route::post('/evaluations/{evaluation}/notes', [NoteController::class, 'store'])->name('admin.evaluations.notes.store');
    Route::post('/evaluations/{evaluation}/valider', [NoteController::class, 'valider'])->name('admin.evaluations.valider');

    Route::resource('note', NoteController::class)->names('admin.note');

    /*
    |--------------------------------------------------------------------------
    | BULLETINS
    |--------------------------------------------------------------------------
    */
    Route::get('/bulletins', [\App\Http\Controllers\BulletinController::class, 'index'])->name('admin.bulletins.index');
    Route::get('/bulletins/{classe}', [\App\Http\Controllers\BulletinController::class, 'generate'])->name('admin.bulletins.generate');
    Route::get('/bulletins/{classe}/student/{student}', [\App\Http\Controllers\BulletinController::class, 'studentBulletin'])->name('admin.bulletins.student');
    Route::get('/bulletins/{classe}/student/{student}/pdf', [\App\Http\Controllers\BulletinController::class, 'downloadPDF'])->name('admin.bulletins.download_pdf');
    Route::resource('factures', \App\Http\Controllers\FactureController::class)->names('admin.factures')->middleware('permission:paiements.view');

    // PDF Timetable Routes
    Route::get('/emploi_du_temps/classe/{id}/pdf', [\App\Http\Controllers\EmploiDuTempsController::class, 'downloadPDFByClasse'])->name('admin.emploi_du_temps.classe_pdf');
    Route::get('/emploi_du_temps/enseignant/{id}/pdf', [\App\Http\Controllers\EmploiDuTempsController::class, 'downloadPDFByTeacher'])->name('admin.emploi_du_temps.teacher_pdf');

    Route::post('/payments', [\App\Http\Controllers\PaymentController::class, 'store'])->name('admin.payments.store');
    Route::get('/payments/{payment}/receipt', [\App\Http\Controllers\PaymentController::class, 'receipt'])->name('admin.payments.receipt');
    Route::delete('/payments/{payment}', [\App\Http\Controllers\PaymentController::class, 'destroy'])->name('admin.payments.destroy');

    // frais_scolaires enregistré une seule fois en bas avec double alias

    /*
    |--------------------------------------------------------------------------
    | ADMINISTRATION GLOBALE (SUPER ADMIN UNIQUEMENT)
    |--------------------------------------------------------------------------
    */
    Route::middleware('role:Super Admin')->group(function () {
        Route::resource('roles', RoleController::class)->names('admin.role');
        Route::get('roles/{role}/permissions', [RoleController::class, 'permissions'])->name('admin.role.permissions');
        Route::post('roles/{role}/permissions', [RoleController::class, 'updatePermissions'])->name('admin.role.update_permissions');
        Route::resource('ecoles', EcoleController::class)->names('admin.ecole');
        Route::resource('ecole-payments', \App\Http\Controllers\EcolePaymentController::class)->names('admin.ecole_payments');
    });
    /*
    |--------------------------------------------------------------------------
    | UTILISATEURS
    |--------------------------------------------------------------------------
    */
    Route::resource('utilisateurs', UserController::class)->names('admin.user');

    /*
    |--------------------------------------------------------------------------
    | PARAMÈTRES SCOLAIRES
    |--------------------------------------------------------------------------
    */
    Route::get('/parametres', [DashboardController::class, 'parametres_scolaires'])->name('parametres_scolaires');

    /*
    |--------------------------------------------------------------------------
    | FRAIS SCOLAIRES (nommé 'frais_scolaires.*' pour compatibilité vues)
    |--------------------------------------------------------------------------
    */
    Route::resource('frais_scolaires', FraisScolaireController::class)->names('frais_scolaires');

    // (Ancienne ligne ecoles supprimée car déplacée ci-dessus)
});


require __DIR__ . '/auth.php';
