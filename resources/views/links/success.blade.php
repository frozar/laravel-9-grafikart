@extends('default')

@section('title')
    Lien créé
@endsection

@section('content')
    <h1>Bravo !</h1>

    <p>
        Vous avez raccourci l'URL : {{ $link->url }}
    </p>
    <p>
        <a class="btn btn-primary" href="{{ route('link.show', $link) }}">
            {{ route('link.show', $link) }}
        </a>
    </p>

    <p class="py-2 lead">
        <a href="{{ route('link.index') }}">
            <button class="btn btn-success fw-bold">Raccourcir une autre URL</button>
        </a>
    </p>
@endsection
