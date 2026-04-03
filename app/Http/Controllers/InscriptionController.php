<?php

namespace App\Http\Controllers;

use App\Models\Annee_scolaire;
use App\Models\Classe;
use App\Models\Cycle;
use App\Models\Facture;
use App\Models\Facture_lignes;
use App\Models\Frais_Scolaire;
use App\Models\Inscription;
use App\Models\Niveau;
use App\Models\Student;
use Illuminate\Http\Request;
use App\Http\Requests\InscriptionRequest;

class InscriptionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Inscription::with(['student', 'anneeScolaire', 'cycle', 'niveau', 'classe']);

        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->whereHas('student', function ($q) use ($search) {
                $q->where('nom', 'like', "%{$search}%")
                    ->orWhere('prenom', 'like', "%{$search}%")
                    ->orWhere('matricule', 'like', "%{$search}%");
            });
        }

        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        $inscriptions = $query->orderBy('created_at', 'desc')->get();
        return view('admin.etudiant.inscription.index', compact('inscriptions'));
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $annees = Annee_scolaire::where('status', 'actif')->get();
        $etudiants = Student::doesntHave('inscriptions')->get();
        $cycles = Cycle::all();
        $niveaux = Niveau::all();
        $classes = Classe::all();

        $selected_student_id = $request->query('student_id');

        $fraisData = Frais_Scolaire::with(['anneeScolaire', 'niveau'])
            ->get()
            ->map(function ($f) {
                return [
                    'niveau_id' => $f->niveau_id,
                    'annee_scolaire_id' => $f->annee_scolaire_id,
                    'frais_inscription' => $f->frais_inscription,
                    'frais_Scolarité' => $f->frais_Scolarité,
                ];
            })
            ->values();

        return view('admin.etudiant.affectation', compact(
            'annees',
            'etudiants',
            'cycles',
            'niveaux',
            'classes',
            'fraisData',
            'selected_student_id'
        ));
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(InscriptionRequest $request)
    {
        $anneeActive = Annee_scolaire::active();

        return \DB::transaction(function () use ($request) {
            // Vérifier cohérence Cycle → Niveau → Classe
            $niveau = Niveau::findOrFail($request->niveau_id);
            $classe = Classe::findOrFail($request->classe_id);

            if ($niveau->cycle_id != $request->cycle_id) {
                return back()->withErrors(['cycle_id' => 'Le niveau choisi n’appartient pas au cycle sélectionné.'])->withInput();
            }

            if ($classe->niveau_id != $niveau->id) {
                return back()->withErrors(['classe_id' => 'La classe choisie n’appartient pas au niveau sélectionné.'])->withInput();
            }

            $inscription = Inscription::updateOrCreate(
                [
                    'student_id' => $request->student_id,
                    'annee_scolaire_id' => $request->annee_scolaire_id
                ],
                [
                    'cycle_id' => $request->cycle_id,
                    'niveau_id' => $request->niveau_id,
                    'classe_id' => $request->classe_id
                ]
            );

            $frais = Frais_Scolaire::where('niveau_id', $niveau->id)
                ->where('annee_scolaire_id', $request->annee_scolaire_id)
                ->first();

            if (!$frais) {
                // Si aucun frais n'est défini pour ce niveau, on peut soit bloquer soit mettre à 0
                // Ici, on continue avec 0 mais on pourrait lever une exception
                $fraisInscription = 0;
                $fraisScolarite = 0;
            } else {
                $fraisInscription = $frais->frais_inscription ?? 0;
                $fraisScolarite = $frais->frais_Scolarité ?? 0;
            }

            $total = $fraisInscription + $fraisScolarite;

            $facture = Facture::updateOrCreate(
                ['inscription_id' => $inscription->id],
                [
                    'montant_total' => $total,
                    'reste' => $total, // Initialement le reste est le total (à recalculer si paiements existent déjà lors d'un update)
                    'statut' => 'non soldé',
                ]
            );

            // Synchroniser les lignes de facture
            $facture->lines()->delete();

            if ($fraisInscription > 0) {
                $facture->lines()->create([
                    'frais_scolaire_id' => $frais->id,
                    'montant' => $fraisInscription,
                ]);
            }
            if ($fraisScolarite > 0) {
                $facture->lines()->create([
                    'frais_scolaire_id' => $frais->id,
                    'montant' => $fraisScolarite,
                ]);
            }

            // Recalculer le solde si des paiements existent déjà (dans le cas d'un update d'inscription)
            $facture->updateStatus();

            return redirect()->route('admin.inscription.index')->with('success', 'Inscription et facture générées avec succès');
        });
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $inscription = Inscription::findOrFail($id);
        return view('admin.etudiant.inscription.show', compact('inscription'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $inscription = Inscription::findOrFail($id);
        $annees = Annee_scolaire::where('status', 'actif')->get();
        $etudiants = Student::all();
        $cycles = Cycle::all();
        $niveaux = Niveau::all();
        $classes = Classe::all();

        $fraisData = Frais_Scolaire::with(['anneeScolaire', 'niveau'])
            ->get()
            ->map(function ($f) {
                return [
                    'niveau_id' => $f->niveau_id,
                    'annee_scolaire_id' => $f->annee_scolaire_id,
                    'frais_inscription' => $f->frais_inscription,
                    'frais_Scolarité' => $f->frais_Scolarité,
                ];
            })
            ->values();

        return view('admin.etudiant.affectation', compact(
            'annees',
            'etudiants',
            'cycles',
            'niveaux',
            'classes',
            'fraisData',
            'inscription'
        ));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(InscriptionRequest $request, string $id)
    {
        $anneeActive = Annee_scolaire::active();

        return \DB::transaction(function () use ($request, $id) {
            $inscription = Inscription::findOrFail($id);
            $inscription->update([
                'student_id' => $request->student_id,
                'classe_id' => $request->classe_id,
                'niveau_id' => $request->niveau_id,
                'cycle_id' => $request->cycle_id,
                'annee_scolaire_id' => $request->annee_scolaire_id,
            ]);

            // Recalculer les frais
            $frais = Frais_Scolaire::where('niveau_id', $request->niveau_id)
                ->where('annee_scolaire_id', $request->annee_scolaire_id)
                ->first();

            $fraisInscription = $frais->frais_inscription ?? 0;
            $fraisScolarite = $frais->frais_Scolarité ?? 0;
            $total = $fraisInscription + $fraisScolarite;

            $facture = Facture::updateOrCreate(
                ['inscription_id' => $inscription->id],
                [
                    'montant_total' => $total,
                ]
            );

            // Synchroniser les lignes
            $facture->lines()->delete();
            if ($frais) {
                if ($fraisInscription > 0) {
                    $facture->lines()->create([
                        'frais_scolaire_id' => $frais->id,
                        'montant' => $fraisInscription,
                    ]);
                }
                if ($fraisScolarite > 0) {
                    $facture->lines()->create([
                        'frais_scolaire_id' => $frais->id,
                        'montant' => $fraisScolarite,
                    ]);
                }
            }

            // Mettre à jour le solde et le statut
            $facture->updateStatus();

            return redirect()->route('admin.inscription.index')->with('success', 'Inscription et facture mises à jour avec succès');
        });
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $inscription = Inscription::findOrFail($id);
        $inscription->delete();
        return redirect()->route('admin.inscription.index')->with('success', 'Inscription supprime avec succes');
    }
}
