<?php

namespace App\Http\Controllers;

use App\Models\Classe;
use App\Models\Emploi_du_temps;
use App\Models\Inscription;
use App\Models\Niveau;
use App\Models\Student;
use Illuminate\Http\Request;


class ClasseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $classes = Classe::with(['niveau'])->get();
        $niveaux = Niveau::all();
        return view('admin.classe.index', compact('classes','niveaux'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $niveaux = Niveau::all();
        return view('admin.classe.create', compact('niveaux'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'niveau_id' => 'required',
            'nom' => 'required',
        ]);

        Classe::create($request->all());
        return redirect()->route('admin.classe.index')->with('success', 'Classe ajoute avec succes');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $classe = Classe::findOrFail($id);
        $etudiants = Inscription::where('classe_id', $id)
            ->where('status', 'inscrite')
            ->get()
            ->pluck('student');

        $nombre_etudiants = $etudiants->count();
        $nombre_de_femmes = $etudiants->where('sexe', 'F')->count();
        $nombre_de_hommes = $etudiants->where('sexe', 'M')->count();
        
        // Récupérer l'emploi du temps de la classe avec toutes les relations
        $emploiDuTemps = Emploi_du_temps::with(['matiere', 'enseignant', 'horaire', 'jour'])
            ->where('classe_id', $id)
            ->get();
        
        // Compter le nombre total d'emplois du temps (même incomplets)
        $totalEmploiDuTemps = $emploiDuTemps->count();
        $emploiIncomplets = 0;
        
        // Liste des jours de la semaine (ordre standard)
        $joursSemaine = ['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi'];
        
        // Créer un mapping des jours pour normaliser les noms
        $joursMapping = [];
        foreach ($joursSemaine as $jour) {
            $joursMapping[strtolower($jour)] = $jour;
            $joursMapping[ucfirst(strtolower($jour))] = $jour;
        }
        
        // Structure optimisée pour le tableau : [horaire_id => [jour => data]]
        $emploiParHoraire = [];
        $horairesUniques = [];
        
        foreach ($emploiDuTemps as $emploi) {
            // Vérifier chaque relation individuellement pour un meilleur diagnostic
            $problemes = [];
            
            if (!$emploi->jour) {
                $problemes[] = 'jour (jours_id: ' . $emploi->jours_id . ')';
            }
            if (!$emploi->horaire) {
                $problemes[] = 'horaire (horaire_id: ' . $emploi->horaire_id . ')';
            }
            if (!$emploi->matiere) {
                $problemes[] = 'matiere (matiere_id: ' . $emploi->matiere_id . ')';
            }
            
            if (!empty($problemes)) {
                $emploiIncomplets++;
                \Log::warning('Emploi du temps incomplet - Relations manquantes', [
                    'emploi_id' => $emploi->id,
                    'classe_id' => $id,
                    'problemes' => $problemes,
                    'jours_id' => $emploi->jours_id,
                    'horaire_id' => $emploi->horaire_id,
                    'matiere_id' => $emploi->matiere_id,
                ]);
                continue;
            }
            
            // Normaliser le nom du jour
            $jourNom = $emploi->jour->jours ?? '';
            if (empty($jourNom)) {
                $emploiIncomplets++;
                Log::warning('Emploi du temps - Jour sans nom', [
                    'emploi_id' => $emploi->id,
                    'jour_id' => $emploi->jours_id,
                ]);
                continue;
            }
            
            $jourNormalise = $joursMapping[strtolower($jourNom)] ?? $jourNom;
            
            // Ignorer les jours qui ne sont pas dans la semaine standard
            if (!in_array($jourNormalise, $joursSemaine)) {
                continue;
            }
            
            $horaireId = $emploi->horaire_id;
            $horaireDebut = $emploi->horaire->heure_debut ?? '';
            $horaireFin = $emploi->horaire->heure_fin ?? '';
            
            if (empty($horaireDebut) || empty($horaireFin)) {
                $emploiIncomplets++;
                \Log::warning('Emploi du temps - Horaire invalide', [
                    'emploi_id' => $emploi->id,
                    'horaire_id' => $horaireId,
                    'heure_debut' => $horaireDebut,
                    'heure_fin' => $horaireFin,
                ]);
                continue;
            }
            
            // Stocker les informations de l'horaire
            if (!isset($horairesUniques[$horaireId])) {
                $horairesUniques[$horaireId] = [
                    'id' => $horaireId,
                    'debut' => $horaireDebut,
                    'fin' => $horaireFin,
                    'type' => $emploi->horaire->type ?? 'cours',
                ];
            }
            
            // Organiser par horaire puis par jour
            if (!isset($emploiParHoraire[$horaireId])) {
                $emploiParHoraire[$horaireId] = [];
            }
            
            $emploiParHoraire[$horaireId][$jourNormalise] = [
                'matiere' => $emploi->matiere->nom ?? '-',
                'enseignant' => trim(($emploi->enseignant->nom ?? '') . ' ' . ($emploi->enseignant->prenom ?? '')),
                'matiere_id' => $emploi->matiere_id,
                'enseignant_id' => $emploi->enseignant_id,
            ];
        }
        
        // Trier les horaires par heure de début
        uasort($horairesUniques, function($a, $b) {
            return strcmp($a['debut'], $b['debut']);
        });
        
        // Créer la structure finale pour la vue : tableau de lignes avec horaires et jours
        $emploiOrganise = [];
        foreach ($horairesUniques as $horaireId => $horaireInfo) {
            $emploiOrganise[] = [
                'horaire_id' => $horaireId,
                'debut' => $horaireInfo['debut'],
                'fin' => $horaireInfo['fin'],
                'type' => $horaireInfo['type'],
                'jours' => $emploiParHoraire[$horaireId] ?? [],
            ];
        }
     
        return view('admin.classe.show', compact(
            'classe',
            'etudiants',
            'nombre_etudiants',
            'nombre_de_femmes',
            'nombre_de_hommes',
            'emploiOrganise',
            'joursSemaine',
            'totalEmploiDuTemps',
            'emploiIncomplets'
        )); 
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $classe = Classe::findOrFail($id);
        $niveaux = Niveau::all();
        return view('admin.classe.edit', compact('classe', 'niveaux'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'niveau_id' => 'required',
            'nom' => 'required',
        ]);

        $classe = Classe::findOrFail($id);
        $classe->update($request->all());
        return redirect()->route('admin.classe.index')->with('success', 'Classe modifie avec succes');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $classe = Classe::findOrFail($id);
        $classe->delete();
        return redirect()->route('admin.classe.index')->with('success', 'Classe supprime avec succes');   
    }
}
