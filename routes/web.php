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
use App\Http\Controllers\ParentPortalController;
use App\Http\Controllers\PresenceController;
use App\Http\Controllers\StudentDocumentController;
use App\Http\Controllers\BulletinController;
use App\Http\Controllers\FactureController;
use App\Http\Controllers\PaymentController;
// use App\Http\Controllers\ComptabiliteController;
use App\Http\Controllers\EcolePaymentController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| ROUTES PUBLIQUES
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return view('welcome');
});

Route::get('/student-details', function () {
    return view('student-details');  // Fichier dans resources/views
});

/*
|--------------------------------------------------------------------------
| ROUTES D'AUTHENTIFICATION & PROFIL
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

/*
|--------------------------------------------------------------------------
| ROUTES PROTÉGÉES (APPLICATION)
|--------------------------------------------------------------------------
*/
Route::middleware('auth', 'role:Super Admin|admin|enseignant|staff|parent|Comptable|etudiant')->group(function () {

    /*
    |--------------------------------------------------------------------------
    | DASHBOARD
    |--------------------------------------------------------------------------
    */
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    /*
    |--------------------------------------------------------------------------
    | ACADÉMIE & SCOLARITÉ
    |--------------------------------------------------------------------------
    */
    Route::resource('cycles', CycleController::class)->names('admin.cycle');
    Route::resource('niveaux', NiveauController::class)->names('admin.niveau');
    Route::get('/classes/{id}/export-students', [ClasseController::class, 'exportStudentList'])->name('admin.classe.export_students');
    Route::resource('classes', ClasseController::class)->names('admin.classe')->middleware('permission:classes.view');
    Route::resource('matieres', MatiereController::class)->names('admin.matiere');
    Route::resource('assignematiere', AssignematiereController::class)->names('admin.matiere.assignematiere');

    /*
    |--------------------------------------------------------------------------
    | UTILISATEURS: ÉLÈVES, ENSEIGNANTS, PARENTS
    |--------------------------------------------------------------------------
    */
    // Élèves
    Route::prefix('students')->middleware('permission:etudiants.view')->group(function () {
        Route::get('/', [StudentController::class, 'index'])->name('admin.etudiant.index');
        Route::get('/create', [StudentController::class, 'create'])->name('admin.etudiant.create');
        Route::post('/', [StudentController::class, 'store'])->name('admin.etudiant.store');
        Route::get('/credentials', [StudentController::class, 'credentials'])->name('admin.etudiant.credentials');
        Route::get('/affectation', [InscriptionController::class, 'create'])->name('admin.etudiant.affectation');
        Route::post('/affectation', [InscriptionController::class, 'store'])->name('admin.etudiant.affect');
        
        // Documents des élèves
        Route::get('/{student_id}/documents', [StudentDocumentController::class, 'index'])->name('admin.etudiant.documents.index');
        Route::post('/documents', [StudentDocumentController::class, 'store'])->name('admin.etudiant.documents.store');
        Route::get('/documents/{document}/download', [StudentDocumentController::class, 'download'])->name('admin.etudiant.documents.download');
        Route::delete('/documents/{document}', [StudentDocumentController::class, 'destroy'])->name('admin.etudiant.documents.destroy');

        // Paramètres dynamiques à la fin pour éviter les conflits d'URLs (ex: /documents vs /{id})
        Route::get('/{id}/fiche', [StudentController::class, 'exportFiche'])->name('admin.etudiant.fiche');
        Route::get('/{id}', [StudentController::class, 'show'])->name('admin.etudiant.show');
        Route::get('/{id}/edit', [StudentController::class, 'edit'])->name('admin.etudiant.edit');
        Route::put('/{id}', [StudentController::class, 'update'])->name('admin.etudiant.update');
        Route::delete('/{id}', [StudentController::class, 'destroy'])->name('admin.etudiant.destroy');
    });

    // Inscriptions
    Route::resource('inscriptions', InscriptionController::class)->names('admin.inscription');

    // Enseignants & Affectations
    Route::resource('enseignants', EnseignantController::class)->names('admin.enseignant');
    Route::resource('affectations', AffectationsPedagogiquesController::class)->names('admin.affectation');

    // Parents
    Route::resource('parents', ParentController::class)->names('admin.parent');

    // Utilisateurs globaux
    Route::resource('utilisateurs', UserController::class)->names('admin.user');

    /*
    |--------------------------------------------------------------------------
    | EMPLOI DU TEMPS & PRÉSENCES
    |--------------------------------------------------------------------------
    */
    Route::resource('emploi_du_temps', EmploiDuTempsController::class)->names('admin.emploi_du_temps');
    Route::get('api/get-teachers-by-assignment', [EmploiDuTempsController::class, 'getTeachersByClasseAndMatiere'])->name('admin.emploi_du_temps.get_teachers');
    Route::get('/emploi_du_temps/classe/{id}', [EmploiDuTempsController::class, 'byClasse'])->name('admin.emploi_du_temps.by_classe');
    Route::get('/emploi_du_temps/enseignant/{id}', [EmploiDuTempsController::class, 'byTeacher'])->name('admin.emploi_du_temps.by_teacher');
    Route::get('/emploi_du_temps/classe/{id}/pdf', [EmploiDuTempsController::class, 'downloadPDFByClasse'])->name('admin.emploi_du_temps.classe_pdf');
    Route::get('/emploi_du_temps/enseignant/{id}/pdf', [EmploiDuTempsController::class, 'downloadPDFByTeacher'])->name('admin.emploi_du_temps.teacher_pdf');

    Route::resource('presences', PresenceController::class)->names('admin.presences');
    Route::get('api/lessons-by-classe/{classe_id?}', [PresenceController::class, 'getLessonsByClasse'])->name('admin.presences.get_lessons');

    /*
    |--------------------------------------------------------------------------
    | ÉVALUATIONS, NOTES & BULLETINS
    |--------------------------------------------------------------------------
    */
    Route::resource('evaluations', EvaluationController::class)->names('admin.evaluations')->middleware('permission:notes.view');
    Route::get('/evaluations/{evaluation}/notes', [NoteController::class, 'create'])->name('admin.evaluations.notes.create');
    Route::post('/evaluations/{evaluation}/notes', [NoteController::class, 'store'])->name('admin.evaluations.notes.store');
    Route::post('/evaluations/{evaluation}/valider', [NoteController::class, 'valider'])->name('admin.evaluations.valider');

    Route::resource('note', NoteController::class)->names('admin.note');

    Route::get('/bulletins', [BulletinController::class, 'index'])->name('admin.bulletins.index');
    Route::get('/bulletins/{classe}', [BulletinController::class, 'generate'])->name('admin.bulletins.generate');
    Route::get('/bulletins/{classe}/student/{student}', [BulletinController::class, 'studentBulletin'])->name('admin.bulletins.student');
    Route::get('/bulletins/{classe}/student/{student}/pdf', [BulletinController::class, 'downloadPDF'])->name('admin.bulletins.download_pdf');
    Route::get('/bulletins/{classe}/download-all', [BulletinController::class, 'downloadAllPDFs'])->name('admin.bulletins.download_all');

    /*
    |--------------------------------------------------------------------------
    | FINANCES & COMPTABILITÉ
    |--------------------------------------------------------------------------
    */
    // Route::get('/comptabilite/dashboard', [ComptabiliteController::class, 'index'])->name('admin.comptabilite.dashboard');
    Route::resource('factures', FactureController::class)->names('admin.factures')->middleware('permission:paiements.view');
    Route::resource('frais_scolaires', FraisScolaireController::class)->names('frais_scolaires');
    
    Route::post('/payments', [PaymentController::class, 'store'])->name('admin.payments.store');
    Route::get('/payments/{payment}/receipt', [PaymentController::class, 'receipt'])->name('admin.payments.receipt');
    Route::delete('/payments/{payment}', [PaymentController::class, 'destroy'])->name('admin.payments.destroy');

    /*
    |--------------------------------------------------------------------------
    | PARAMÈTRES & ANNÉES SCOLAIRES
    |--------------------------------------------------------------------------
    */
    Route::get('/parametres', [DashboardController::class, 'parametres_scolaires'])->name('parametres_scolaires');

    Route::resource('annees', AnneeScolaireController::class)->names('admin.annee');
    Route::post('/annee-scolaire/{id}/activate', [AnneeScolaireController::class, 'activate'])->name('admin.annee.activate');
    Route::post('/annee-scolaire/{id}/cloturer', [AnneeScolaireController::class, 'cloturer'])->name('admin.annee.cloturer');
    Route::get('/annee-scolaire/{id}/export-zip', [AnneeScolaireController::class, 'exportZip'])->name('admin.annee.export_zip');

    Route::resource('periodes', PeriodeController::class)->names('admin.periodes');

    Route::get('/ecoles/settings', [EcoleController::class, 'settings'])->name('admin.ecole.settings');
    Route::put('/ecoles/settings/{ecole}', [EcoleController::class, 'update'])->name('admin.ecole.update_settings');

    /*
    |--------------------------------------------------------------------------
    | PORTAIL PARENT
    |--------------------------------------------------------------------------
    */
    Route::middleware(['role:parent|Super Admin'])->prefix('parent')->name('parent.')->group(function () {
        Route::get('/select-student/{id}', [ParentPortalController::class, 'selectStudent'])->name('select_student');
        Route::get('/modifier-mot-de-passe', [ParentPortalController::class, 'showChangePasswordForm'])->name('password.change');
        Route::post('/modifier-mot-de-passe', [ParentPortalController::class, 'updatePassword'])->name('password.update');

        Route::middleware('force.password.change')->group(function () {
            Route::get('/dashboard', [ParentPortalController::class, 'index'])->name('dashboard');
            Route::get('/notes', [ParentPortalController::class, 'notes'])->name('notes');
            Route::get('/emploi-du-temps', [ParentPortalController::class, 'emploiDuTemps'])->name('emploi');
            Route::get('/factures', [ParentPortalController::class, 'factures'])->name('factures');
            Route::get('/documents', [ParentPortalController::class, 'documents'])->name('documents');
            Route::get('/documents/{document}/download', [ParentPortalController::class, 'downloadDocument'])->name('documents.download');
            Route::get('/presences', [ParentPortalController::class, 'presences'])->name('presences');
            Route::get('/profil', [ParentPortalController::class, 'profile'])->name('profile');
        });
    });

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
        Route::resource('ecole-payments', EcolePaymentController::class)->names('admin.ecole_payments');
    });

});

require __DIR__ . '/auth.php';
