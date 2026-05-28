<x-layout>

<div class="container py-5">

    <div class="row justify-content-center">

        <div class="col-12 col-xl-10">

            {{-- HERO --}}
            <div class="position-relative mb-4 rounded-4 overflow-hidden shadow">

                @if($post->image)
                    <img src="{{ asset('storage/' . $post->image) }}"
                         class="w-100"
                         style="height: 420px; object-fit: cover;"
                         alt="{{ $post->title }}">
                @else
                    <div class="bg-dark text-white d-flex align-items-center justify-content-center"
                         style="height: 420px;">
                        <h3>No Image Available</h3>
                    </div>
                @endif

                {{-- overlay --}}
                <div class="position-absolute bottom-0 start-0 w-100 p-4"
                     style="background: linear-gradient(to top, rgba(0,0,0,0.75), transparent);">

                    <span class="badge bg-secondary mb-2">
                        {{ $post->category?->name ?? 'Uncategorized' }}
                    </span>

                    <h1 class="text-white fw-bold m-0">
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

                        <p class="fs-5 lh-lg">
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
                            <strong>{{ $post->created_at->format('d M Y') }}</strong>
                        </p>

                        <p class="mb-0">
                            🏷 Categoria:
                            <strong>{{ $post->category?->name ?? '-' }}</strong>
                        </p>

                    </div>

                    <div class="d-grid gap-2">

                        <a href="{{ route('posts.index') }}"
                           class="btn btn-outline-dark rounded-3 fw-semibold">
                            Torna indietro
                        </a>

                        <a href="{{ route('posts.edit', $post->id) }}"
                           class="btn btn-warning rounded-3">
                            ✏️ Modifica
                        </a>

                    </div>

                </div>

            </div>

        </div>
    </div>

</div>
</x-layout>
