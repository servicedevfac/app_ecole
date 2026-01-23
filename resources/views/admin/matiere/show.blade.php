
@extends('layouts.app')
@section('content')
<div class="container">
    <h2 class="text-2xl font-bold mb-4">Matéries</h2>
</div>
@foreach($matieres as $matiere)
    <h4>{{ $matiere->nom }}</h4>
    <div class="mb-4">
        @foreach($matiere->classes as $classe)
        <p>
            {{ $classe->nom }} 
            (coef {{ $classe->pivot->coefficient }})
        </p>
    @endforeach
    </div>
@endforeach

@endsection
