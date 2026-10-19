<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Bulletin - {{ $bulletin['student']->nom }} {{ $bulletin['student']->prenom }}</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; color: #333; }
        .header { text-align: center; margin-bottom: 20px; border-bottom: 2px solid #333; padding-bottom: 10px; }
        .student-info { margin-bottom: 20px; width: 100%; }
        .student-info td { vertical-align: top; }
        .table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        .table th, .table td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        .table th { background-color: #f2f2f2; }
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .font-weight-bold { font-weight: bold; }
        .footer { margin-top: 50px; width: 100%; }
        .footer td { text-align: center; width: 33%; }
        .moyenne-generale { font-size: 1.2rem; margin-top: 10px; }
        .text-danger { color: #d9534f; }
        .text-success { color: #5cb85c; }
    </style>
</head>
</head>
<body>
    @php
        $logoBase64 = '';
        if (isset($ecole) && $ecole->logo && Storage::disk('public')->exists($ecole->logo)) {
            $logoPath = storage_path('app/public/' . $ecole->logo);
            $logoData = file_get_contents($logoPath);
            $logoBase64 = 'data:image/' . pathinfo($logoPath, PATHINFO_EXTENSION) . ';base64,' . base64_encode($logoData);
        }
    @endphp

    <div class="header">
        <table style="width: 100%; border: none;">
            <tr>
                <td style="width: 30%; text-align: left; border: none;">
                    @if($logoBase64)
                        <img src="{{ $logoBase64 }}" style="max-width: 100px; max-height: 100px;">
                    @else
                        <h2 style="color: #3366cc; margin: 0;">SGS</h2>
                    @endif
                </td>
                <td style="width: 70%; text-align: right; border: none; vertical-align: top;">
                    <h2 style="margin: 0; text-transform: uppercase;">{{ $ecole->nom ?? 'SGS - ÉCOLE' }}</h2>
                    <div style="font-size: 11px; color: #555;">
                        @if(isset($ecole) && $ecole->adresse) <div>{{ $ecole->adresse }}</div> @endif
                        @if(isset($ecole) && $ecole->telephone) <div>Tél: {{ $ecole->telephone }}</div> @endif
                        @if(isset($ecole) && $ecole->email) <div>Email: {{ $ecole->email }}</div> @endif
                    </div>
                </td>
            </tr>
        </table>
    </div>

    <div style="text-align: center; margin-top: 10px;">
        <h2 style="text-decoration: underline; margin-bottom: 5px;">BULLETIN DE NOTES</h2>
        <div style="font-size: 14px;">Année Scolaire : {{ $annee->annee }}</div>
        @if($periode)
            <div style="font-size: 14px;">Période : {{ $periode->nom }}</div>
        @endif
    </div>

    <table class="student-info">
        <tr>
            <td width="50%">
                <p><strong>Nom :</strong> {{ $bulletin['student']->nom }}</p>
                <p><strong>Prénom :</strong> {{ $bulletin['student']->prenom }}</p>
                <p><strong>Matricule :</strong> {{ $bulletin['student']->matricule }}</p>
                <p><strong>Date de Naissance :</strong> {{ $bulletin['student']->date_naissance }}</p>
            </td>
            <td width="50%" class="text-right">
                <p><strong>Classe :</strong> {{ $classe->nom }}</p>
                <p><strong>Rang :</strong> {{ $bulletin['rang'] }}{{ $bulletin['rang'] == 1 ? 'er' : 'ème' }}{{ $bulletin['is_ex'] ? ' ex' : '' }} / {{ $classStats['total_students'] }}</p>
                <p><strong>Moyenne Classe :</strong> {{ number_format($classStats['moyenne_generale'], 2) }}</p>
            </td>
        </tr>
    </table>

    <table class="table">
        <thead>
            <tr>
                <th>Matière</th>
                <th class="text-center">Coef</th>
                <th class="text-center">Moyenne / 20</th>
                <th class="text-center">Points</th>
                <th>Appréciation</th>
            </tr>
        </thead>
        <tbody>
            @foreach($bulletin['matieres'] as $matiereId => $data)
                <tr>
                    <td>{{ $data['nom'] }}</td>
                    <td class="text-center">{{ $data['coef'] }}</td>
                    <td class="text-center font-weight-bold">
                        @if($data['moyenne'] !== null)
                            <span class="{{ $data['moyenne'] < 10 ? 'text-danger' : '' }}">
                                {{ number_format($data['moyenne'], 2) }}
                            </span>
                        @else
                            -
                        @endif
                    </td>
                    <td class="text-center">{{ number_format($data['points'], 2) }}</td>
                    <td>
                        @if($data['moyenne'] !== null)
                            @if($data['moyenne'] >= 16) Très Bien
                            @elseif($data['moyenne'] >= 14) Bien
                            @elseif($data['moyenne'] >= 12) Assez Bien
                            @elseif($data['moyenne'] >= 10) Passable
                            @else Insuffisant
                            @endif
                        @else
                            -
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr class="font-weight-bold">
                <td class="text-right">TOTAL</td>
                <td class="text-center">{{ $bulletin['total_coef'] }}</td>
                <td class="text-center">
                    {{ number_format($bulletin['moyenne_generale'], 2) }}
                </td>
                <td class="text-center">{{ number_format($bulletin['total_points'], 2) }}</td>
                <td></td>
            </tr>
        </tfoot>
    </table>

    <div class="moyenne-generale text-right font-weight-bold">
        Moyenne Générale : 
        <span class="{{ $bulletin['moyenne_generale'] < 10 ? 'text-danger' : 'text-success' }}">
            {{ number_format($bulletin['moyenne_generale'], 2) }} / 20
        </span>
    </div>

    <table class="footer">
        <tr>
            <td>
                <p><strong>L'enseignant titulaire</strong></p>
            </td>
            <td>
                <p><strong>Le Chef d'Etablissement</strong></p>
            </td>
            <td>
                <p><strong>Les Parents</strong></p>
            </td>
        </tr>
    </table>
</body>
</html>
