@extends('default')

@section('title')
    Index raccourci
@endsection

@section('content')
    <div class="d-flex w-100 h-100 mx-auto flex-column">
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

        @if (0 < count($links))
            <div class="mb-4">
                <h1 class="mb-3">Raccourcis disponibles</h1>
                <div
                    class="scrollbar-thumb:!bg-slate-300 scrollbar-thumb:!rounded scrollbar-track:!bg-slate-100 scrollbar-track:!rounded scrollbar:!h-1.5 scrollbar:!w-1.5 scrollbar:bg-transparent overflow-x-auto">
                    {{-- <div style="overflow-x: auto;"> --}}
                    <table class="table table-hover table-bordered">
                        <thead>
                            <tr style="border-width: 0;">
                                <th scope="col" style="border-width: 1px 1px;">URL d'origine</th>
                                <th scope="col" style="border-width: 1px 1px;">URL raccourci</th>
                                <th colspan="2" scope="col" style="border-width: 0;"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($links as $link)
                                <tr class="align-middle">
                                    <td>{{ $link->url }}</td>
                                    <td><a
                                            href="{{ route('link.show', ['link' => $link]) }}">{{ route('link.show', compact('link')) }}</a>
                                    </td>
                                    <td>
                                        <a href={{ route('link.edit', compact('link')) }}>
                                            <button type="button" class="btn p-0">
                                                <i class="bi bi-pencil"></i>
                                            </button>
                                        </a>
                                    </td>
                                    <td>
                                        <button type="button" class="btn p-0" data-bs-toggle="modal"
                                            data-bs-target="#deleteModal{{ $link->id }}">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </td>
                                </tr>

                                <!-- Modal -->
                                <div class="modal fade" id="deleteModal{{ $link->id }}" tabindex="-1"
                                    aria-labelledby="deleteModalLabel{{ $link->id }}" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="deleteModalLabel{{ $link->id }}">Supprimer
                                                    le
                                                    raccourci {{ $link->id }}</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                URL raccourci : {{ $link->url }}
                                            </div>
                                            <div class="modal-footer">
                                                <div class="d-flex justify-content-between w-100">
                                                    <button type="button" class="btn btn-primary"
                                                        data-bs-dismiss="modal">Annuler</button>
                                                    <form action="{{ route('link.destroy', compact('link')) }}"
                                                        method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-success">
                                                            Valider</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endif

        <div class="mb-3">
            <h2 class="mb-3">Raccourcir une URL</h2>
            <form action="{{ route('link.store') }}" method="POST" class="row g-2">
                @csrf
                <div class="col-md-1 d-none d-sm-none d-md-block">
                    <label for="url" class="col-form-label">URL</label>
                </div>
                <div class="col-md-9">
                    <input type="text" class="form-control @error('url') is-invalid @enderror" id="validationUrl"
                        name="url" placeholder="http://..." value="{{ old('url') }}" />
                    @error('url')
                        <div class="invalid-feedback">
                            {{ __($message) }}
                        </div>
                    @enderror
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-success w-100">Raccourcir</button>
                </div>
            </form>
        </div>
    </div>
@endsection
