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
        $allClasses = Classe::with(['niveau', 'inscriptions'])->paginate(10);
        $niveaux = Niveau::all();
        return view('admin.classe.index', compact('allClasses','niveaux'));
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
            'niveau_id' => 'required|exists:niveaux,id',
            'nom' => 'required|unique:classes,nom',
        ]);

        Classe::create($request->all());
        return redirect()->route('admin.classe.index')->with('success', 'Classe ajoutée avec succès');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $classe = Classe::with(['niveau'])->findOrFail($id);
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
        
        // Structure simplifiée pour l'affichage...
        // (Garder la logique existante du show car elle est déjà riche)
        
        // Liste des jours de la semaine (ordre standard)
        $joursSemaine = ['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi'];
        $joursMapping = [];
        foreach ($joursSemaine as $jour) {
            $joursMapping[strtolower($jour)] = $jour;
            $joursMapping[ucfirst(strtolower($jour))] = $jour;
        }
        
        $emploiParHoraire = [];
        $horairesUniques = [];
        $emploiIncomplets = 0;
        $totalEmploiDuTemps = $emploiDuTemps->count();

        foreach ($emploiDuTemps as $emploi) {
            if (!$emploi->jour || !$emploi->horaire || !$emploi->matiere) {
                $emploiIncomplets++;
                continue;
            }
            
            $jourNom = $emploi->jour->jours ?? '';
            $jourNormalise = $joursMapping[strtolower($jourNom)] ?? $jourNom;
            if (!in_array($jourNormalise, $joursSemaine)) continue;
            
            $horaireId = $emploi->horaire_id;
            if (!isset($horairesUniques[$horaireId])) {
                $horairesUniques[$horaireId] = [
                    'id' => $horaireId,
                    'debut' => $emploi->horaire->heure_debut,
                    'fin' => $emploi->horaire->heure_fin,
                    'type' => $emploi->horaire->type ?? 'cours',
                ];
            }
            
            if (!isset($emploiParHoraire[$horaireId])) $emploiParHoraire[$horaireId] = [];
            
            $emploiParHoraire[$horaireId][$jourNormalise] = [
                'matiere' => $emploi->matiere->nom ?? '-',
                'enseignant' => trim(($emploi->enseignant->nom ?? '') . ' ' . ($emploi->enseignant->prenom ?? '')),
            ];
        }
        
        uasort($horairesUniques, fn($a, $b) => strcmp($a['debut'], $b['debut']));
        
        $emploiOrganise = [];
        foreach ($horairesUniques as $horaireId => $horaireInfo) {
            $emploiOrganise[] = array_merge($horaireInfo, ['jours' => $emploiParHoraire[$horaireId] ?? []]);
        }
     
        return view('admin.classe.show', compact(
            'classe', 'etudiants', 'nombre_etudiants', 'nombre_de_femmes', 'nombre_de_hommes',
            'emploiOrganise', 'joursSemaine', 'totalEmploiDuTemps', 'emploiIncomplets'
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
            'niveau_id' => 'required|exists:niveaux,id',
            'nom' => 'required|unique:classes,nom,' . $id,
        ]);

        $classe = Classe::findOrFail($id);
        $classe->update($request->all());
        return redirect()->route('admin.classe.index')->with('success', 'Classe modifiée avec succès');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $classe = Classe::withCount('inscriptions')->findOrFail($id);
        
        if ($classe->inscriptions_count > 0) {
            return redirect()->route('admin.classe.index')
                ->with('error', 'Impossible de supprimer cette classe car elle contient des élèves inscrits.');
        }

        $classe->delete();
        return redirect()->route('admin.classe.index')->with('success', 'Classe supprimée avec succès');   
    }
}
