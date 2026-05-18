<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste de Classe - {{ $classe->nom }}</title>
    <style>
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            font-size: 12px;
            color: #333;
            margin: 0;
            padding: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #444;
            padding-bottom: 10px;
        }
        .school-name {
            font-size: 18px;
            font-weight: bold;
            text-transform: uppercase;
            margin-bottom: 5px;
        }
        .document-title {
            font-size: 16px;
            font-weight: bold;
            color: #555;
            margin-bottom: 10px;
        }
        .class-info {
            font-size: 14px;
            margin-bottom: 5px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            table-layout: auto;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 5px;
            text-align: left;
            word-wrap: break-word;
        }
        th {
            background-color: #f2f2f2;
            font-weight: bold;
            text-transform: uppercase;
            font-size: 10px;
        }
        tr:nth-child(even) {
            background-color: #fafafa;
        }
        .footer {
            margin-top: 30px;
            text-align: right;
            font-style: italic;
            font-size: 10px;
        }
        .stats {
            margin-top: 20px;
            font-weight: bold;
        }
        .badge {
            padding: 2px 5px;
            border-radius: 3px;
            font-size: 10px;
        }
    </style>
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
                <td style="width: 25%; border: none; vertical-align: middle;">
                    @if($logoBase64)
                        <img src="{{ $logoBase64 }}" style="max-width: 80px; max-height: 80px;">
                    @endif
                </td>
                <td style="width: 50%; text-align: center; border: none;">
                    @if($ecole && $ecole->nom)
                        <div class="school-name">{{ $ecole->nom }}</div>
                    @else
                        <div class="school-name">GESTION SCOLAIRE</div>
                    @endif
                    <div class="document-title" style="margin-top: 5px;">LISTE NOMINATIVE DES ÉLÈVES</div>
                </td>
                <td style="width: 25%; text-align: right; border: none; font-size: 10px; color: #666; vertical-align: middle;">
                    @if(isset($ecole) && $ecole->telephone) <div>Tél: {{ $ecole->telephone }}</div> @endif
                    @if(isset($ecole) && $ecole->email) <div>{{ $ecole->email }}</div> @endif
                    @if(isset($ecole) && $ecole->adresse) <div>{{ \Illuminate\Support\Str::limit($ecole->adresse, 40) }}</div> @endif
                </td>
            </tr>
        </table>
        
        <div style="margin-top: 15px; border-top: 1px solid #eee; padding-top: 10px;">
            <span class="class-info">CLASSE : <strong>{{ $classe->nom }}</strong></span>
            <span style="margin: 0 20px;">|</span>
            <span class="class-info">NIVEAU : {{ $classe->niveau->nom ?? 'N/A' }}</span>
            <span style="margin: 0 20px;">|</span>
            <span class="class-info">ANNÉE : {{ now()->year }} - {{ now()->year + 1 }}</span>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th>N°</th>
                <th>MATRICULE</th>
                <th>NOM ET PRÉNOMS</th>
                <th>SEXE</th>
                <th>DATE DE NAISS.</th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                
            </tr>
        </thead>
        <tbody>
            @forelse($etudiants as $index => $etudiant)
                <tr>
                    <td style="text-align: center;">{{ $index + 1 }}</td>
                    <td>{{ $etudiant->matricule ?? 'N/A' }}</td>
                    <td><strong>{{ strtoupper($etudiant->nom) }}</strong> {{ \Illuminate\Support\Str::limit($etudiant->prenom, 20, '...') }}</td>
                    <td style="text-align: center;">{{ $etudiant->sexe }}</td>
                    <td>{{ $etudiant->date_naissance ? \Carbon\Carbon::parse($etudiant->date_naissance)->format('d/m/Y') : '-' }}</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
            @empty
                <tr>
                    <td colspan="9" style="text-align: center; padding: 20px;">Aucun élève inscrit dans cette classe.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="stats">
        Total élèves : {{ $etudiants->count() }} 
        (Garçons : {{ $etudiants->where('sexe', 'M')->count() }}, 
        Filles : {{ $etudiants->where('sexe', 'F')->count() }})
    </div>

    <div class="footer">
        Document généré le {{ now()->format('d/m/Y à H:i') }}
    </div>
</body>
</html>
