<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Annee_scolaire;
use App\Models\Classe;
use Illuminate\Support\Facades\DB;
use App\Services\BulletinService;
use Barryvdh\DomPDF\Facade\Pdf;
use ZipArchive;
use Illuminate\Support\Facades\Storage;

class AnneeScolaireController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $annees = Annee_scolaire::all();
        return view('admin.annee.index', compact('annees'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.annee.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
    
    $request->validate([
        'annee' => 'required|unique:annee_scolaires,annee',
        'date_debut' => 'required|date',
        'date_fin' => 'required|date|after:date_debut',
    ]); 
    $anneeExistante = Annee_scolaire::where('annee', $request->input('annee'))->first();
        if ($anneeExistante) {
            return redirect()->back()->withErrors(['annee' => 'Cette année scolaire existe déjà.']);
        }
        $annee=Annee_scolaire::create([
        'annee' => $request->annee,
        'date_debut' => $request->date_debut,
        'date_fin' => $request->date_fin,
        'status' => 'inactive',
    ]);
    $annee->status = 'inactive';
    $annee->save(); 


        return redirect()->route('admin.annee.index')
            ->with('success', 'Année scolaire créée avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $annee = Annee_scolaire::findOrFail($id);
        return view('admin.annee.show', compact('annee'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $annee = Annee_scolaire::findOrFail($id);
        return view('admin.annee.edit', compact('annee'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'annee' => 'required|string|max:255',
            'date_debut' => 'required|date',
            'date_fin' => 'required|date|after_or_equal:date_debut',
            'status' => 'required|string|max:255',
        ]);

        $annee = Annee_scolaire::findOrFail($id);
        $annee->update($request->except('status'));
        $annee->status = $request->input('status');
        $annee->save();

        return redirect()->route('admin.annee.index')
            ->with('success', 'Année scolaire mise à jour avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $annee = Annee_scolaire::findOrFail($id);
        $annee->delete();

        return redirect()->route('admin.annee.index')
            ->with('success', 'Année scolaire supprimée avec succès.');
    }
    public function activate($id)
{
    DB::transaction(function () use ($id) {
        Annee_scolaire::where('status', 'active')
            ->update(['status' => 'inactive']);

        Annee_scolaire::where('id', $id)
            ->update(['status' => 'active']);
    });

    return back()->with('success', 'Année scolaire activée');
}

public function cloturer($id)
{
    $annee = Annee_scolaire::findOrFail($id);
    
    if ($annee->status === 'archived') {
        return back()->with('error', 'Cette année est déjà archivée.');
    }

    $annee->update(['status' => 'archived']);

    return back()->with('success', 'Année scolaire clôturée et archivée avec succès.');
}

public function exportZip($id, BulletinService $bulletinService)
{
    $annee = Annee_scolaire::findOrFail($id);
    $classes = Classe::all();
    
    $zip = new ZipArchive;
    $fileName = 'Bulletins_' . str_replace('/', '-', $annee->annee) . '.zip';
    $tempFile = tempnam(sys_get_temp_dir(), 'zip');

    if ($zip->open($tempFile, ZipArchive::CREATE) === TRUE) {
        foreach ($classes as $classe) {
            $data = $bulletinService->getBulletinsData($classe, null, $annee);
            
            foreach ($data['bulletins'] as $bulletin) {
                $pdf = Pdf::loadView('admin.bulletins.pdf', [
                    'classe' => $classe,
                    'bulletin' => $bulletin,
                    'annee' => $annee,
                    'periode' => null,
                    'classStats' => $data['classStats']
                ]);
                
                $pdfName = $classe->nom . '/' . $bulletin['student']->nom . '_' . $bulletin['student']->prenom . '.pdf';
                $zip->addFromString($pdfName, $pdf->output());
            }
        }
        $zip->close();
    }

    return response()->download($tempFile, $fileName)->deleteFileAfterSend(true);
}

}
