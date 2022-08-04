@extends('default')

@section('title')
    Index raccourci
@endsection

@section('content')
    <div class="d-flex w-100 h-100 mx-auto flex-column">
        <div>
            <h1 class="mb-3">Raccourcis à mettre à jour</h1>

            <form action="{{ route('link.update', compact('link')) }}" method="POST" class="row g-2">
                @csrf
                @method('PATCH')
                <div class="col-sm-5">
                    <input type="text" name="url" id="url" value="{{ $link->url }}" class="form-control" />
                </div>
                <div class="col-sm-5">
                    <input type="text" name="shortcut" id="shortcut" value="{{ route('link.show', compact('link')) }}"
                        disabled class="form-control" />
                </div>
                <div class="col-sm-2">
                    <button type="submit" class="btn btn-success w-100">Raccourcir</button>
                </div>
            </form>
        </div>
    </div>
@endsection
