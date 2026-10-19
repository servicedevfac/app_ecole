<?php

namespace App\Http\Controllers;

use App\Models\AffectationsPedagogiques;
use App\Models\Annee_scolaire;
use App\Models\Ecole;
use App\Models\Classe;
use App\Models\Cycle;
use App\Models\EcolePayment;
use App\Models\Enseignant;
use App\Models\Evaluation;
use App\Models\Inscription;
use App\Models\Matiere;
use App\Models\Niveau;
use App\Models\Note;
use App\Models\Parents;
use App\Models\Student;

use App\Models\Facture;
use App\Models\Payment;
use App\Models\Presence;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class DashboardController extends Controller
{
    /**
     * Display a dashboard.
     */
    public function index()
    {

        // 1. MONITORING DASHBOARD (SUPER ADMIN ONLY)
        if (auth()->user()->hasRole('Super Admin')) {
            $totalSchools = Ecole::count();
            $activeSchoolsCount = Ecole::where('is_active', true)->count();
            $totalStudentsCount = Student::count();
            $totalRevenue = Payment::sum('montant'); // Scolar (B2C)
            $platformRevenue = EcolePayment::sum('montant'); // Platform (B2B)
            $newSchoolsCount = Ecole::where('created_at', '>', now()->subDays(30))->count();

            // Top 5 schools by size
            $topSchools = Ecole::withCount('etudiants')
                ->orderBy('etudiants_count', 'desc')
                ->take(5)
                ->get();

            // Last 10 payments platform-wide (Scolar)
            $recentPayments = EcolePayment::with('ecole')
                ->latest()
                ->take(10)
                ->get();

            return view('admin.dashboard_monitoring', compact(
                'totalSchools',
                'activeSchoolsCount',
                'totalStudentsCount',
                'totalRevenue',
                'platformRevenue',
                'newSchoolsCount',
                'topSchools',
                'recentPayments'
            ));
        }

        // COMPTABLE DASHBOARD
        if (auth()->user()->hasRole('Comptable')) {
            $anneeActive = Annee_scolaire::active();

            // 1. Statistiques Globales
            $totalFacture = Facture::sum('montant_total');
            $totalEncaisse = Payment::sum('montant');
            $resteAPercevoir = Facture::sum('reste');

            // Taux de recouvrement
            $tauxRecouvrement = $totalFacture > 0 ? ($totalEncaisse / $totalFacture) * 100 : 0;

            // 2. Paiements Récents
            $recentPayments = Payment::with(['facture.inscription.student', 'facture.inscription.classe'])
                ->latest()
                ->take(10)
                ->get();

            // 3. Factures Impayées / En retard
            $overdueInvoices = Facture::where('statut', '!=', 'soldé')
                ->where('date_echeance', '<', Carbon::today())
                ->with(['inscription.student', 'inscription.classe'])
                ->orderBy('date_echeance', 'asc')
                ->take(10)
                ->get();

            // 4. Revenus par mois (Année en cours)
            $monthlyRevenue = Payment::selectRaw('EXTRACT(MONTH FROM date_paiement) as month, SUM(montant) as total')
                ->whereYear('date_paiement', Carbon::now()->year)
                ->groupBy('month')
                ->orderBy('month')
                ->get();

            // 5. Répartition par classe
            $revenueByClass = Classe::withCount(['students'])
                ->get()
                ->map(function ($classe) {
                    $totalClass = Facture::whereHas('inscription', function ($q) use ($classe) {
                        $q->where('classe_id', $classe->id);
                    })->sum('montant_total');

                    $encaisseClass = Payment::whereHas('facture.inscription', function ($q) use ($classe) {
                        $q->where('classe_id', $classe->id);
                    })->sum('montant');

                    return [
                        'nom' => $classe->nom,
                        'total' => $totalClass,
                        'encaisse' => $encaisseClass,
                        'reste' => $totalClass - $encaisseClass,
                        'taux' => $totalClass > 0 ? ($encaisseClass / $totalClass) * 100 : 0
                    ];
                });

            return view('admin.comptabilite.dashboard', compact(
                'totalFacture',
                'totalEncaisse',
                'resteAPercevoir',
                'tauxRecouvrement',
                'recentPayments',
                'overdueInvoices',
                'monthlyRevenue',
                'revenueByClass',
                'anneeActive'
            ));

        }

        // 2. TEACHER DASHBOARD
        if (auth()->user()->hasRole('enseignant')) {
            $enseignant = Enseignant::where('user_id', auth()->id())->first();

            if (!$enseignant) {
                // Si l'enseignant n'a pas encore de profil lié, on affiche le tableau de bord standard
                // ou on le prévient. Pour éviter le crash on redirige vers le profil ou on continue avec le scolar dashboard.
                return redirect()->route('profile.edit')->with('warning', 'Veuillez compléter vos informations d’enseignant.');
            }

            // Stats de l'enseignant
            $myAffectations = AffectationsPedagogiques::where('enseignant_id', $enseignant->id)->with(['classe', 'matiere'])->get();
            $myClasses = $myAffectations->pluck('classe')->unique();
            $myClassesCount = $myClasses->count();

            $myEvaluations = Evaluation::where('enseignant_id', $enseignant->id)->latest()->take(5)->get();
            $myEvaluationsCount = Evaluation::where('enseignant_id', $enseignant->id)->count();

            // Étudiants uniques dans ses classes - utilisation de la table inscription
            $myStudentsCount = Inscription::whereIn('classe_id', $myClasses->pluck('id'))->count();

            $anneeActive = Annee_scolaire::active();

            return view('admin.dashboard.enseignant', compact(
                'enseignant',
                'myAffectations',
                'myClassesCount',
                'myStudentsCount',
                'myEvaluationsCount',
                'myEvaluations',
                'anneeActive'
            ));
        }
        if(auth()->user()->hasRole('parent')) {
            return redirect()->route('parent.dashboard');
        }

        // 2. SCOLAR DASHBOARD (SCHOOL ADMINS & OTHERS)
        // Core counts — utiliser count() au lieu de all() pour éviter OOM
        $studentsCount = Student::count();
        $maleStudents = Student::where('sexe', 'M')->count();
        $femaleStudents = Student::where('sexe', 'F')->count();
        $enseignants = Enseignant::count();
        $dashboardParents = Parents::count();

        // Aliases attendus dans la vue
        $students = $studentsCount;
        $teachers = $enseignants;
        $dashboardClasses = Classe::count();

        // Additional counts
        $inscriptionsCount = Inscription::count();
        $evaluationsCount = Evaluation::count();
        $matieresCount = Matiere::count();
        $niveauxCount = Niveau::count();
        $notesCount = Note::count();


        // Financial indicators
        $totalEncasse = Payment::sum('montant');
        $resteAPercevoir = Facture::sum('reste');

        // Overdue alerts
        $overdueInvoices = Facture::where('statut', 'non soldé')
            ->whereNotNull('date_echeance')
            ->where('date_echeance', '<', Carbon::today())
            ->with(['inscription.student', 'inscription.classe'])
            ->get();

        // Attendance stats (last 15 business days roughly)
        $attendanceTrends = Presence::selectRaw('date, statut, count(*) as count')
            ->where('date', '>=', Carbon::now()->subDays(15))
            ->groupBy('date', 'statut')
            ->orderBy('date')
            ->get()
            ->groupBy('date');

        // Active year
        $anneeActive = Annee_scolaire::active();

        // Evaluation stats
        $evaluationsValidees = Evaluation::where('statut', 'validee')->count();
        $evaluationsEnAttente = Evaluation::where('statut', '!=', 'validee')->count();

        // Recent students (last 8, with classe relation)
        $recentStudents = Student::with('classe')
            ->orderBy('created_at', 'desc')
            ->take(8)
            ->get();

        // Recent evaluations (last 6, with relations)
        $recentEvaluations = Evaluation::with(['classe', 'matiere'])
            ->orderBy('created_at', 'desc')
            ->take(6)
            ->get();

        // Inscriptions by Cycle for chart
        $inscriptionsByCycle = Cycle::withCount('niveaux')
            ->get()
            ->map(function ($cycle) {
                return [
                    'label' => $cycle->nom,
                    'count' => Inscription::where('cycle_id', $cycle->id)->count(),
                ];
            })
            ->filter(function ($item) {
                return $item['count'] > 0;
            })
            ->values();

        // Students per class for bar chart
        $studentsPerClass = Classe::withCount('students')
            ->get()
            ->map(function ($classe) {
                return [
                    'label' => $classe->nom,
                    'count' => $classe->students_count,
                ];
            });

        // Classes overview with student counts by gender
        $classesOverview = Classe::with('niveau')
            ->withCount(['students', 'matieres'])
            ->get()
            ->map(function ($classe) {
                $classe->male_count = $classe->students()->where('sexe', 'M')->count();
                $classe->female_count = $classe->students()->where('sexe', 'F')->count();
                return $classe;
            });

        return view('dashboard', compact(
            'students',
            'teachers',
            'enseignants',
            'maleStudents',
            'femaleStudents',
            'dashboardParents',
            'dashboardClasses',
            'inscriptionsCount',
            'evaluationsCount',
            'matieresCount',
            'niveauxCount',
            'notesCount',
            'totalEncasse',
            'resteAPercevoir',
            'overdueInvoices',
            'attendanceTrends',
            'anneeActive',
            'evaluationsValidees',
            'evaluationsEnAttente',
            'recentStudents',
            'recentEvaluations',
            'inscriptionsByCycle',
            'studentsPerClass',
            'classesOverview'
        ));
    }

    public function parametres_scolaires()
    {
        // Counts for summary cards
        $anneesCount = Annee_scolaire::count();
        $cyclesCount = Cycle::count();
        $niveauxCount = Niveau::count();
        $classesCount = Classe::count();
        $matieresCount = Matiere::count();

        $enseignantsCount = Enseignant::count();
        $usersCount = User::count();

        // Active year
        $anneeActive = Annee_scolaire::active();

        // Data collections for tables
        $annees = Annee_scolaire::orderBy('date_debut', 'desc')->get();
        $cycles = Cycle::withCount('niveaux')->get();
        $niveaux = Niveau::with('cycle')->get();
        $classes = Classe::with('niveau')->get();
        $matieres = Matiere::all();

        return view('paramete_Scolaire', compact(
            'anneesCount',
            'cyclesCount',
            'niveauxCount',
            'classesCount',
            'matieresCount',
            'enseignantsCount',
            'usersCount',
            'anneeActive',
            'annees',
            'cycles',
            'niveaux',
            'classes',
            'matieres',
        ));
    }
}
