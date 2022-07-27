@extends('default')

@section('title', $title)

@section('content')
    <h1>{{ $title }}</h1>

    <p>lorem ipsum</p>

    <ul>
        @forelse ($numbers as $number)
            <li>{{ $number }}</li>
        @empty
            <li>Aucun chiffre</li>
        @endforelse
    </ul>
@endsection

@section('sidebar')
    @parent

    <h3>{{ $title }}</h3>

    <p>lorem ipsum</p>
@endsection
