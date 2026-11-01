<x-layout>

<div class="container py-5">

    <div class="row justify-content-center">

        <div class="col-12 col-xl-10">

            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            {{-- HERO --}}
            <div class="position-relative mb-4 rounded-4 overflow-hidden shadow">

                @if($post->image)
                    <img src="{{ asset('storage/' . $post->image) }}"
                         class="w-100 hero-media"
                         style="object-fit: cover;"
                         alt="{{ $post->title }}">
                @else
                    <div class="bg-dark text-white d-flex align-items-center justify-content-center hero-media">
                        <h3>No Image Available</h3>
                    </div>
                @endif

                {{-- overlay --}}
                <div class="position-absolute bottom-0 start-0 w-100 p-4"
                     style="background: linear-gradient(to top, rgba(0,0,0,0.75), transparent);">

                    <span class="badge bg-secondary mb-2">
                        {{ $post->category?->name ?? 'Uncategorized' }}
                    </span>

                    <h1 class="text-white fw-bold m-0 text-break">
                        {{ $post->title }}
                    </h1>

                </div>
            </div>

            {{-- CONTENT --}}
            <div class="row g-4">

                {{-- LEFT --}}
                <div class="col-lg-8">

                    <div class="bg-white rounded-4 shadow-sm p-4">

                        <h5 class="fw-bold mb-3">Descrizione</h5>

                        <p class="fs-5 lh-lg text-break">
                            {{ $post->description }}
                        </p>

                        <hr>

                        {{-- TAGS --}}
                        @if($post->tags->count())
                            <div class="mt-3">
                                <h6 class="fw-bold mb-2">Tags</h6>

                                @foreach($post->tags as $tag)
                                    <span class="badge bg-primary me-1 mb-1">
                                        {{ $tag->message }}
                                    </span>
                                @endforeach
                            </div>
                        @endif

                    </div>
                </div>

                {{-- RIGHT SIDEBAR --}}
                <div class="col-lg-4">

                    <div class="bg-white rounded-4 shadow-sm p-4 mb-3">

                        <h6 class="fw-bold">Info post</h6>

                        <hr>

                        <p class="mb-2">
                            📅 Creato il:
                            <strong>{{ $post->created_at->translatedFormat('d M Y') }}</strong>
                        </p>

                        <p class="mb-0">
                            🏷 Categoria:
                            <strong>{{ $post->category?->name ?? '-' }}</strong>
                        </p>

                    </div>

                    {{-- ISCRIZIONE AL GIOCO --}}
                    <div id="iscrizione" class="bg-white rounded-4 shadow-sm p-4 mb-3">

                        <h6 class="fw-bold">Iscrizione al gioco</h6>

                        <hr>

                        @auth
                            @if ($isSubscribed)
                                <p>Sei iscritto a questo gioco.</p>

                                <form action="{{ route('posts.unsubscribe', $post) }}" method="POST" class="d-grid">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger rounded-3">Annulla iscrizione</button>
                                </form>
                            @else
                                <form action="{{ route('posts.subscribe', $post) }}" method="POST" class="d-grid">
                                    @csrf

                                    <div class="form-check mb-3">
                                        <input type="checkbox" name="consent" value="1" id="consent" required
                                            class="form-check-input @error('consent') is-invalid @enderror">
                                        <label class="form-check-label small" for="consent">
                                            Acconsento al trattamento del mio nome e della mia email per registrare l'iscrizione a questo articolo.
                                            <a href="{{ route('privacy') }}">Privacy Policy</a>
                                        </label>
                                        @error('consent')
                                            <div class="invalid-feedback d-block">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>

                                    <button type="submit" class="btn btn-primary rounded-3">Iscriviti</button>
                                </form>
                            @endif
                        @else
                            <p>Accedi per iscriverti a questo gioco.</p>

                            <div class="d-grid">
                                <a href="{{ route('login') }}" class="btn btn-primary rounded-3">Accedi</a>
                            </div>
                        @endauth

                    </div>
                    <div class="d-grid gap-2">

                        <a href="{{ route('posts.index') }}"
                           class="btn btn-outline-dark rounded-3 fw-semibold">
                            Torna indietro
                        </a>

                        @can('admin')
                            <a href="{{ route('posts.edit', $post->id) }}"
                               class="btn btn-warning rounded-3">
                                ✏️ Modifica
                            </a>

                            <form action="{{ route('posts.destroy', $post) }}" method="POST" class="d-grid"
                                onsubmit="return confirm('Eliminare questo post?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger rounded-3">🗑️ Elimina</button>
                            </form>
                        @endcan

                    </div>

                </div>

            </div>

        </div>
    </div>

</div>
</x-layout>
