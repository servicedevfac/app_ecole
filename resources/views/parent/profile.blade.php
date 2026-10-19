@extends('layouts.app')

@section('content')
    <div class="breadcrumbs-area">
        <h3>Mon Profil Parent</h3>
        <ul>
            <li>
                <a href="{{ route('parent.dashboard') }}">Accueil</a>
            </li>
            <li>Profil</li>
        </ul>
    </div>

    <div class="row">
        <div class="col-xl-4 col-12">
            <div class="card">
                <div class="card-body">
                    <div class="item-img text-center mb-4">
                        <div class="bg-light-blue p-5 rounded-circle d-inline-block">
                            <i class="fas fa-user-tie text-blue fa-5x"></i>
                        </div>
                    </div>
                    <div class="item-content text-center">
                        <h3 class="item-title mb-0">{{ $parent->nom }} {{ $parent->prenom }}</h3>
                        <span class="text-muted">Parent d'élève</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-8 col-12">
            <div class="card">
                <div class="card-body">
                    <div class="heading-layout1 mg-b-20">
                        <div class="item-title">
                            <h3>Informations Personnelles</h3>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table text-nowrap">
                            <tbody>
                                <tr>
                                    <td class="font-weight-bold" style="width: 200px;">Nom Complet:</td>
                                    <td>{{ $parent->nom }} {{ $parent->prenom }}</td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold">Email:</td>
                                    <td>{{ $parent->email }}</td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold">Téléphone:</td>
                                    <td>{{ $parent->telephone }}</td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold">Autre Téléphone:</td>
                                    <td>{{ $parent->autre_telephone ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold">Adresse:</td>
                                    <td>{{ $parent->adresse }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
