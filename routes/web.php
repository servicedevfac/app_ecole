<?php

use App\Http\Controllers\AffectationsPedagogiquesController;
use App\Http\Controllers\AnneeScolaireController;
use App\Http\Controllers\AssignematiereController;
use App\Http\Controllers\EvaluationController;
use App\Http\Controllers\NoteController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\ClasseController;
use App\Http\Controllers\CycleController;
use App\Http\Controllers\EmploiDuTempsController;
use App\Http\Controllers\EnseignantController;
use App\Http\Controllers\InscriptionController;
use App\Http\Controllers\MatiereController;
use App\Http\Controllers\NiveauController;
use App\Http\Controllers\ParentController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

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
Route::middleware('auth', 'role:administrateur')->group(function () {
   
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
    Route::middleware('role:administrateur')->group(function () {
        Route::get('/users', [\App\Http\Controllers\UserController::class, 'index'])->name('users.index');
        Route::get('/users/create', [\App\Http\Controllers\UserController::class, 'create'])->name('users.create');
        Route::post('/users', [\App\Http\Controllers\UserController::class, 'store'])->name('users.store');
        Route::get('/users/{id}/edit', [\App\Http\Controllers\UserController::class, 'edit'])->name('users.edit');
        Route::put('/users/{id}', [\App\Http\Controllers\UserController::class, 'update'])->name('users.update');
        Route::patch('/users/{id}/roles', [\App\Http\Controllers\UserController::class, 'updateRoles'])->name('users.roles');
    });

    Route::get('/users/{id}', [\App\Http\Controllers\UserController::class, 'show'])
        ->name('users.show');

    /*
    |--------------------------------------------------------------------------
    | ÉLÈVES (STUDENTS)
    |--------------------------------------------------------------------------
    */
    Route::prefix('students')->group(function () {
        Route::get('/', [StudentController::class, 'index'])->name('admin.etudiant.index');
        Route::get('/create', [StudentController::class, 'create'])->name('admin.etudiant.create');
        Route::post('/', [StudentController::class, 'store'])->name('admin.etudiant.store');
        Route::get('/affectation', [InscriptionController::class, 'create'])->name('admin.etudiant.affectation');
        Route::post('/affectation', [InscriptionController::class, 'store'])->name('admin.etudiant.affect');
        
        Route::get('/{id}', [StudentController::class, 'show'])->name('admin.etudiant.show');
        Route::get('/{id}/edit', [StudentController::class, 'edit'])->name('admin.etudiant.edit');
        Route::put('/{id}', [StudentController::class, 'update'])->name('admin.etudiant.update');
        Route::delete('/{id}', [StudentController::class, 'destroy'])->name('admin.etudiant.destroy');
    
        Route::post('/{id}/documents', [\App\Http\Controllers\StudentDocumentController::class, 'store'])
            ->name('admin.etudiant.documents.store');
    });

    /*
    |--------------------------------------------------------------------------
    | CLASSES
    |--------------------------------------------------------------------------
    */
    Route::resource('classes',ClasseController::class)->names('admin.classe');

    /*
    |--------------------------------------------------------------------------
    | CYCLES
    |--------------------------------------------------------------------------
    */
    Route::resource('emploi_du_temps',EmploiDuTempsController::class)->names('admin.emploi_du_temps');
    //Route::resource('attendences',AttendenceController::class)->names('admin.attendence');
    Route::resource('matieres',MatiereController::class)->names('admin.matiere');
    Route::resource('cycles',CycleController::class)->names('admin.cycle');
    /*
    |--------------------------------------------------------------------------
    | NIVEAUX
    |--------------------------------------------------------------------------
    */
    Route::resource('niveaux',NiveauController::class)->names('admin.niveau');

    /*
    |--------------------------------------------------------------------------
    | PAIRETS
    |--------------------------------------------------------------------------
    */
    Route::resource('parents',ParentController::class)->names('admin.parent');

    /*
    |--------------------------------------------------------------------------
    | ANNEES SCOLAIRES
    |--------------------------------------------------------------------------
    */
    Route::resource('annees',AnneeScolaireController::class)->names('admin.annee');
    Route::post('/annee-scolaire/{id}/activate', [AnneeScolaireController::class, 'activate'])->name('admin.annee.activate');

    /*
    |--------------------------------------------------------------------------
    | INSCRIPTIONS
    |--------------------------------------------------------------------------
    */
    Route::resource('inscriptions',InscriptionController::class)->names('admin.inscription');

    /*
    |--------------------------------------------------------------------------
    | ENSEIGNANTS
    |--------------------------------------------------------------------------
    */
    Route::resource('enseignants',EnseignantController::class)->names('admin.enseignant');

    /*
    |--------------------------------------------------------------------------
    | MATIÈRES
    |--------------------------------------------------------------------------
    */
    Route::resource('matieres',MatiereController::class)->names('admin.matiere');
    /*
    |--------------------------------------------------------------------------
    | ASSIGNATION DE MATIÈRES
    |--------------------------------------------------------------------------
    */
    Route::resource('assignematiere',AssignematiereController::class)->names('admin.matiere.assignematiere');

    /*
    |--------------------------------------------------------------------------
    | AFFECTATIONS PÉDAGOGIQUES
    |--------------------------------------------------------------------------
    */
    Route::resource('affectations',AffectationsPedagogiquesController::class)->names('admin.affectation');

    /*
    |--------------------------------------------------------------------------
    | EVALUATION
    |--------------------------------------------------------------------------
    */
    Route::resource('evaluations', EvaluationController::class)->names('admin.evaluations');

    /*
    |--------------------------------------------------------------------------
    | NOTES
    |--------------------------------------------------------------------------
    */
    // Routes spécifiques pour la saisie des notes d'une évaluation
    Route::get('/evaluations/{evaluation}/notes', [NoteController::class, 'create'])->name('admin.evaluations.notes.create');
    Route::post('/evaluations/{evaluation}/notes', [NoteController::class, 'store'])->name('admin.evaluations.notes.store');
    
    Route::resource('note', NoteController::class)->names('admin.note');
    /*
    |--------------------------------------------------------------------------
    | ROLES
    |--------------------------------------------------------------------------
    */
    Route::resource('roles',RoleController::class)->names('admin.role');
    /*
    |--------------------------------------------------------------------------
    | UTILISATEURS
    |--------------------------------------------------------------------------
    */
    Route::resource('utilisateurs',UserController::class)->names('admin.user');
    Route::get('/utilisateurs/{id}/edit', [UserController::class, 'edit'])->name('admin.user.edit');
    Route::put('/utilisateurs/{id}', [UserController::class, 'update'])->name('admin.user.update');
    Route::delete('/utilisateurs/{id}', [UserController::class, 'destroy'])->name('admin.user.destroy');
    Route::get('/utilisateurs/{id}', [UserController::class, 'show'])->name('admin.user.show');
    Route::get('/utilisateurs', [UserController::class, 'index'])->name('admin.user.index');
    Route::get('/utilisateurs/create', [UserController::class, 'create'])->name('admin.user.create');

 
  

});


require __DIR__.'/auth.php';
