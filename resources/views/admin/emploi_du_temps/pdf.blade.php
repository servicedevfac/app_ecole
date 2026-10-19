<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Emploi du temps</title>
    <style>
        @page { margin: 1cm; }
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            font-size: 10px;
            color: #333;
        }
        .header {
            text-align: center;
            margin-bottom: 15px;
            border-bottom: 2px solid #ffbc00;
            padding-bottom: 10px;
        }
        .header h1 {
            margin: 0;
            color: #ffbc00;
            font-size: 20px;
        }
        .header h3 {
            margin: 5px 0 0 0;
            color: #555;
        }
        .info {
            margin-bottom: 15px;
            width: 100%;
        }
        .info table {
            border: none;
            width: auto;
        }
        .info td {
            border: none;
            padding: 2px 20px 2px 0;
        }
        table.grid {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
        }
        table.grid th, table.grid td {
            border: 1px solid #ccc;
            padding: 5px;
            text-align: center;
            vertical-align: middle;
        }
        table.grid th {
            background-color: #f8f9fa;
            font-weight: bold;
            text-transform: uppercase;
            font-size: 9px;
        }
        .time-col {
            background-color: #f8f9fa;
            font-weight: bold;
            width: 80px;
        }
        .course-box {
            padding: 4px;
            border-radius: 3px;
            background-color: #fff9e6;
            border-left: 3px solid #ffbc00;
            text-align: left;
        }
        .course-name {
            font-weight: bold;
            font-size: 10px;
            margin-bottom: 2px;
        }
        .course-detail {
            font-size: 8px;
            color: #666;
        }
        .pause-box {
            background-color: #eeeeee;
            font-style: italic;
            color: #999;
        }
        .footer {
            position: fixed;
            bottom: 0;
            width: 100%;
            text-align: center;
            font-size: 8px;
            color: #999;
            border-top: 1px solid #eee;
            padding-top: 5px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>EMPLOI DU TEMPS</h1>
        <h3>{{ $title }}</h3>
    </div>

    <div class="info">
        <table>
            <tr>
                <td><strong>Année Scolaire:</strong> {{ $annee->annee ?? 'N/A' }}</td>
                <td><strong>Date d'édition:</strong> {{ date('d/m/Y H:i') }}</td>
            </tr>
        </table>
    </div>

    <table class="grid">
        <thead>
            <tr>
                <th class="time-col">HORAIRE</th>
                @foreach($jours as $jour)
                    <th>{{ ucfirst($jour->jours) }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @foreach($horaires as $horaire)
                <tr>
                    <td class="time-col">
                        {{ \Carbon\Carbon::parse($horaire->heure_debut)->format('H:i') }}<br>
                        {{ \Carbon\Carbon::parse($horaire->heure_fin)->format('H:i') }}
                        @if($horaire->type == 'pause')
                            <br><small>(PAUSE)</small>
                        @endif
                    </td>
                    @foreach($jours as $jour)
                        <td @if($horaire->type == 'pause') class="pause-box" @endif>
                            @if(isset($grid[$horaire->id][$jour->id]))
                                @php $s = $grid[$horaire->id][$jour->id]; @endphp
                                <div class="course-box">
                                    <div class="course-name">{{ $s->matiere->nom }}</div>
                                    <div class="course-detail">
                                        @if($type == 'classe')
                                            Prof: {{ $s->enseignant->nom }}
                                        @else
                                            Classe: {{ $s->classe->nom }}
                                        @endif
                                        @if($s->salle)
                                            <br>Salle: {{ $s->salle }}
                                        @endif
                                    </div>
                                </div>
                            @elseif($horaire->type == 'pause')
                                ---
                            @endif
                        </td>
                    @endforeach
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        Document généré par le Système de Gestion Scolaire (SGS) - &copy; {{ date('Y') }}
    </div>
</body>
</html>