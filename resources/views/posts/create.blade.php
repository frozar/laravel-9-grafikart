@extends('default')

@section('title')
    Index articles
@endsection

@section('header')
    @include('posts.header')
@endsection

@section('content')
    <div class="d-flex w-100 h-100 mx-auto flex-column align-items-start mb-4">
        @if ($message = Session::get('info'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                <span>{{ $message }}</span>
            </div>
        @endif

        @if ($message = Session::get('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                <span>{{ $message }}</span>
            </div>
        @endif

        <h1 class="mb-3 float-md-start">Ajouter un nouvel article</h1>
        {{ Form::open(['url' => route('news.store'), 'class' => 'w-100', 'style' => 'text-align: left']) }}
        <div class="mb-3">
            {{ Form::label('title', 'Titre', ['class' => 'form-label']) }}
            {{ Form::text('title', null, ['class' => 'form-text form-control']) }}
        </div>
        <div class="mb-3">
            {{ Form::label('slug', 'URL', ['class' => 'form-label']) }}
            {{ Form::text('slug', null, ['class' => 'form-text form-control']) }}
        </div>
        <div class="mb-3">
            {{ Form::label('content', 'Contenu', ['class' => 'form-label']) }}
            {{ Form::textarea('content', null, ['class' => 'form-text form-control']) }}
        </div>
        <button class="btn btn-primary">Envoyer</button>
        {{ Form::close() }}
    </div>
@endsection
