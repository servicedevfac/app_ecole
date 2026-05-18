@extends('layouts.app')

@section('content')
<div class="dashboard-content-one">
    <div class="breadcrumbs-area">
        <h3>Sélection de l'enfant</h3>
        <ul>
            <li>
                <a href="#">Accueil</a>
            </li>
            <li>Sélection</li>
        </ul>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="heading-layout1">
                        <div class="item-title">
                            <h3>Veuillez sélectionner l'enfant à consulter</h3>
                        </div>
                    </div>
                    <div class="row gutters-20">
                        @foreach($students as $student)
                        <div class="col-xl-3 col-lg-4 col-md-6 col-12">
                            <div class="card dashboard-card-two pd-b-20 text-center">
                                <div class="card-body">
                                    <div class="item-img mb-3" style="width: 100px; height: 100px; margin: 0 auto;">
                                        <img src="{{ $student->photo ? asset('storage/'.$student->photo) : url('img/figure/student.png') }}" alt="student" class="rounded-circle" style="width: 100%; height: 100%; object-fit: cover;">
                                    </div>
                                    <div class="item-content">
                                        <h4 class="item-title">{{ $student->nom }} {{ $student->prenom }}</h4>
                                        <p class="text-muted">{{ $student->inscriptions->first()->classe->nom ?? 'N/A' }}</p>
                                        <a href="{{ route('parent.select_student', $student->id) }}" class="btn-fill-lg bg-blue-dark btn-hover-yellow">
                                            Consulter le dossier
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
