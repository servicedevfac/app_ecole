@extends('layouts.app')

@section('content')
<div class="dashboard-content-one">
    <div class="breadcrumbs-area">
        <h3>Mon Relevé de Notes</h3>
        <ul>
            <li>
                <a href="{{ route('student.dashboard') }}">Accueil</a>
            </li>
            <li>Mes Notes</li>
        </ul>
    </div>

    <!-- Student Notes Area Start Here -->
    <div class="card height-auto">
        <div class="card-body">
            <div class="heading-layout1">
                <div class="item-title">
                    <h3>Relevé de notes détaillé</h3>
                </div>
            </div>

            <form class="mg-b-20" action="{{ route('student.notes') }}" method="GET">
                <div class="row gutters-8">
                    <div class="col-lg-5 col-12 form-group">
                        <select name="inscription_id" class="select2" onchange="this.form.submit()">
                            @foreach($inscriptions as $ins)
                                <option value="{{ $ins->id }}" {{ $selectedInscriptionId == $ins->id ? 'selected' : '' }}>
                                    Année {{ $ins->anneeScolaire->nom }} - {{ $ins->classe->nom ?? 'N/A' }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </form>

            @foreach($notes as $periode => $periodeNotes)
            <div class="mg-t-30">
                <h4 class="text-primary border-bottom pb-2">{{ $periode }}</h4>
                <div class="table-responsive">
                    <table class="table display data-table text-nowrap">
                        <thead>
                            <tr>
                                <th>Matière</th>
                                <th>Évaluation</th>
                                <th>Coeff.</th>
                                <th>Note</th>
                                <th>Note Pondérée</th>
                                <th>Commentaire</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $totalPondere = 0; $totalCoeff = 0; @endphp
                            @foreach($periodeNotes as $note)
                                <tr>
                                    <td>{{ $note->evaluation->matiere->nom }}</td>
                                    <td>{{ $note->evaluation->nom }}</td>
                                    <td>{{ $note->evaluation->matiere_classe->coefficient ?? 1 }}</td>
                                    <td>
                                        <span class="badge {{ $note->note >= 10 ? 'badge-success' : 'badge-danger' }}" style="font-size: 1rem;">
                                            {{ $note->note }}/20
                                        </span>
                                    </td>
                                    @php 
                                        $coeff = $note->evaluation->matiere_classe->coefficient ?? 1;
                                        $ponderee = $note->note * $coeff;
                                        $totalPondere += $ponderee;
                                        $totalCoeff += $coeff;
                                    @endphp
                                    <td>{{ $ponderee }}</td>
                                    <td>{{ $note->commentaire ?? '-' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr class="bg-light">
                                <td colspan="4" class="text-right font-bold">Moyenne de la période :</td>
                                <td colspan="2">
                                    <span class="badge badge-info" style="font-size: 1.1rem;">
                                        {{ $totalCoeff > 0 ? number_format($totalPondere / $totalCoeff, 2) : '0.00' }}/20
                                    </span>
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
            @endforeach

            @if($notes->isEmpty())
                <div class="alert alert-info text-center">
                    Aucune note disponible pour cette période scolaire.
                </div>
            @endif
        </div>
    </div>
    <!-- Student Notes Area End Here -->
</div>
@endsection
