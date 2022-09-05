@extends('default')

@section('title')
    Index articles
@endsection

@section('header')
    @include('posts.header')
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

        @if (0 < count($posts))
            <div class="mb-2">
                <h1 class="mb-3">Articles disponibles</h1>
                @foreach ($posts as $post)
                    <h1>{{ $post->title }}</h1>
                    <p>{{ $post->slug }}</p>
                    <p><a class="btn btn-primary" href="{{ route('news.edit', $post) }}">Editer</a></p>
                @endforeach
                {{-- <div
                    class="scrollbar-thumb:!bg-slate-300 scrollbar-thumb:!rounded scrollbar-track:!bg-slate-100 scrollbar-track:!rounded scrollbar:!h-1.5 scrollbar:!w-1.5 scrollbar:bg-transparent overflow-x-auto">
                    <table class="table table-hover table-bordered">
                        <thead>
                            <tr style="border-width: 0;">
                                <th scope="col" style="border-width: 1px 1px;">URL d'origine</th>
                                <th scope="col" style="border-width: 1px 1px;">URL raccourci</th>
                                <th colspan="2" scope="col" style="border-width: 0;"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($posts as $post)
                                <tr class="align-middle">
                                    <td>{{ $post->url }}</td>
                                    <td><a
                                            href="{{ route('post.show', ['post' => $post]) }}">{{ route('post.show', compact('post')) }}</a>
                                    </td>
                                    <td>
                                        <a href={{ route('post.edit', compact('post')) }}>
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
                </div> --}}
            </div>
        @endif

        {{-- <div class="mb-3">
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
        </div> --}}
    </div>

    <a class="btn btn-info mb-4" href={{ route('news.create') }}>Nouveau</a>
@endsection
