<?php

namespace App\Http\Controllers;

use App\Models\Classe;
use App\Models\Emploi_du_temps;
use App\Models\Horaire;
use App\Models\Presence;
use App\Models\Student;
use App\Models\Annee_scolaire;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class PresenceController extends Controller
{
    public function index(Request $request)
    {
        $query = Presence::with(['student', 'classe', 'matiere', 'emploiDuTemps.horaire']);

        if ($request->date) {
            $query->whereDate('date', $request->date);
        } else {
            $query->whereDate('date', Carbon::today());
        }

        if ($request->classe_id) {
            $query->where('classe_id', $request->classe_id);
        }

        $presences = $query->latest()->paginate(20);
        $classes = Classe::all();

        return view('admin.presence.index', compact('presences', 'classes'));
    }

    public function create(Request $request)
    {
        $classes = Classe::all();
        $date = $request->date ?? Carbon::today()->format('Y-m-d');
        $classe_id = $request->classe_id;
        $emploi_du_temps_id = $request->emploi_du_temps_id;

        $students = [];
        $lessons = [];

        if ($classe_id) {
            // Get lessons for this class on this day
            $dayOfWeek = Carbon::parse($date)->dayOfWeek;
            // Map Carbon dayOfWeek (0-Sun to 6-Sat) to project Jour IDs if necessary
            // Jour table might have specific IDs. Let's check Jour model or table.
            // For now, let's assume we filter by the day of the week linked to the schedule.
            
            $lessons = Emploi_du_temps::with(['matiere', 'horaire', 'jour'])
                ->where('classe_id', $classe_id)
                ->whereHas('jour', function($q) use ($dayOfWeek) {
                    // Adjust dayOfWeek mapping if needed. Typically 1-7 in DB.
                    // Carbon: 0 (Sun) - 6 (Sat)
                    $dbDay = $dayOfWeek == 0 ? 7 : $dayOfWeek;
                    $q->where('id', $dbDay); 
                })
                ->get();

            if ($emploi_du_temps_id) {
                $students = Student::whereHas('inscriptions', function($q) use ($classe_id) {
                    $q->where('classe_id', $classe_id);
                })->get();
            }
        }

        return view('admin.presence.create', compact('classes', 'lessons', 'students', 'date', 'classe_id', 'emploi_du_temps_id'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'date' => 'required|date',
            'classe_id' => 'required|exists:classes,id',
            'emploi_du_temps_id' => 'required|exists:emploi_du_temps,id',
            'presences' => 'required|array',
        ]);

        $emploi = Emploi_du_temps::findOrFail($request->emploi_du_temps_id);

        foreach ($request->presences as $student_id => $statut) {
            Presence::updateOrCreate(
                [
                    'student_id' => $student_id,
                    'emploi_du_temps_id' => $request->emploi_du_temps_id,
                    'date' => $request->date,
                ],
                [
                    'classe_id' => $request->classe_id,
                    'matiere_id' => $emploi->matiere_id,
                    'statut' => $statut,
                    'ecole_id' => Auth::user()->ecole_id,
                ]
            );
        }

        return redirect()->route('admin.presences.index')->with('success', 'Présences enregistrées avec succès.');
    }

    public function edit(Presence $presence)
    {
        return view('admin.presence.edit', compact('presence'));
    }

    public function update(Request $request, Presence $presence)
    {
        $request->validate([
            'statut' => 'required|in:present,absent,retard,justifié',
        ]);

        $presence->update([
            'statut' => $request->statut,
        ]);

        return redirect()->route('admin.presences.index')->with('success', 'Présence mise à jour.');
    }

    public function getLessonsByClasse(Request $request, $classe_id = null)
    {
        if (!$classe_id) {
            return response()->json([]);
        }
        $date = $request->date ?? Carbon::today()->format('Y-m-d');
        $dayOfWeek = Carbon::parse($date)->dayOfWeek;
        $dbDay = $dayOfWeek == 0 ? 7 : $dayOfWeek;

        $lessons = Emploi_du_temps::with(['matiere', 'horaire'])
            ->where('classe_id', $classe_id)
            ->where('jours_id', $dbDay)
            ->get()
            ->map(function($lesson) {
                return [
                    'id' => $lesson->id,
                    'text' => $lesson->matiere->nom . ' (' . $lesson->horaire->heure_debut . ' - ' . $lesson->horaire->heure_fin . ')',
                ];
            });

        return response()->json($lessons);
    }
}
