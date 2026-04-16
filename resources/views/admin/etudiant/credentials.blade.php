@extends('layouts.app')

@section('content')
<div class="dashboard-content-one">
    <!-- Breadcubs Area Start Here -->
    <div class="breadcrumbs-area">
        <h3>Identifiants de l'élève</h3>
        <ul>
            <li>
                <a href="{{ route('dashboard') }}">Accueil</a>
            </li>
            <li>Identifiants</li>
        </ul>
    </div>
    <!-- Breadcubs Area End Here -->

    <!-- Credentials Area Start Here -->
    <div class="card height-auto">
        <div class="card-body">
            <div class="heading-layout1">
                <div class="item-title">
                    <h3>Compte Utilisateur Créé</h3>
                </div>
            </div>
            
            <div class="alert alert-success">
                L'élève <strong>{{ $etudiant->nom }} {{ $etudiant->prenom }}</strong> a été enregistré avec succès.
            </div>

            <div class="ui-alart-box">
                <div class="dismiss-alart">
                    <div class="alert alert-primary alert-dismissible fade show" role="alert">
                        <strong>Important !</strong> Veuillez noter ou imprimer ces identifiants pour les remettre à l'élève.
                    </div>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table display data-table text-nowrap">
                    <tbody>
                        <tr>
                            <td class="font-bold">Nom complet :</td>
                            <td>{{ $etudiant->nom }} {{ $etudiant->prenom }}</td>
                        </tr>
                        <tr>
                            <td class="font-bold">Matricule (Identifiant) :</td>
                            <td><span class="badge badge-primary" style="font-size: 1.2rem;">{{ $etudiant->matricule }}</span></td>
                        </tr>
                        <tr>
                            <td class="font-bold">Mot de passe temporaire :</td>
                            <td><code style="font-size: 1.2rem;">{{ $password }}</code></td>
                        </tr>
                        <tr>
                            <td class="font-bold">URL de connexion :</td>
                            <td>{{ url('/login') }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="mg-t-30">
                <a href="{{ route('admin.etudiant.index') }}" class="btn-fill-lg btn-gradient-yellow btn-hover-bluedark">Retour à la liste</a>
                <button type="button" onclick="window.print();" class="btn-fill-lg bg-blue-dark btn-hover-yellow">Imprimer</button>
            </div>
        </div>
    </div>
    <!-- Credentials Area End Here -->
</div>
@endsection
