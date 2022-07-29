@extends('default')

@section('title')
    Lien créé
@endsection

@section('content')
    <h1>Bravo !</h1>

    <p>
        {{-- <a class="btn btn-primary" href="{{ action([App\Http\Controllers\LinksController::class, 'show'], ['id' => $link->id]) }}">  > --}}
        {{-- <a class="btn btn-primary" href="{{ route('show', ['id' => $link->id]) }}">
            {{ route('show', ['id' => $link->id]) }}
        </a> --}}
        <a class="btn btn-primary" href="{{ route('link.show', $link) }}">
            {{ route('link.show', $link) }}
        </a>
        {{-- <a class="btn btn-primary" href="{{ route('link.show', ['link' => $link->id]) }}">
            {{ route('link.show', ['link' => $link->id]) }}
        </a> --}}
    </p>

    <p class="py-2 lead">
        {{-- <a href="{{ route('show', ['id' => $link->id]) }}" --}}
        {{-- <a href="/links/create" class="btn btn-lg btn-secondary fw-bold border-white bg-white">Créer un lien</a> --}}
        <a href="{{ route('link.create') }}" class="btn btn-lg btn-secondary fw-bold border-white bg-white">Créer un lien</a>
    </p>
@endsection
