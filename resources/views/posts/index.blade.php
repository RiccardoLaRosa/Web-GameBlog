<x-layout>
    <div class="py-5" style="min-height:100vh; background: linear-gradient(135deg, #272e3bcb, #2c2d3fcc);">
        <div class="py-5">
            <div class="ms-6 me-6">
                <!-- Titolo della sezione -->
                <h2 class="text-white fw-bold mb-2">Ultimi Post</h2>
                <p class="text-secondary text-white mb-4">Scopri le ultime novità dal nostro blog di giochi. Non perdere
                    i post più
                    interessanti!</p>

                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                <div class="list-group">
                    @foreach ($posts as $post)
                        <div
                            class="list-group-item list-group-item-dark mb-3 rounded d-flex flex-column flex-md-row align-items-stretch align-items-md-center justify-content-between gap-3 gap-md-0">

                            <!-- Immagine -->
                            @if ($post->image)
                                <img src="{{ Storage::url($post->image) }}" alt="{{ $post->title }}"
                                    class="img-fluid rounded me-md-3 img-index flex-shrink-0">
                            @else
                                <div class="rounded me-md-3 img-index flex-shrink-0 bg-dark text-white small d-flex align-items-center justify-content-center">
                                    No Image
                                </div>
                            @endif

                            <!-- Testo -->
                            <div class="flex-grow-1 me-md-3">
                                <div class="d-flex flex-wrap flex-xl-nowrap row-gap-1 align-items-center mb-1">
                                    <h5 class="text-black fw-semibold mb-0 me-2 fs-4 text-break">{{ $post->title }}</h5>

                                    {{-- Badge --}}
                                    @foreach ($post->tags as $tag)
                                        @if ($tag->id == 1)
                                            <span class="badge bg-success me-2 fs-6">Nuovo</span>
                                        @endif

                                        @if ($tag->id == 2)
                                            <span class="badge bg-primary me-2 fs-6">DLC</span>
                                        @endif

                                        @if ($tag->id == 3)
                                            <span class="badge bg-warning me-2 fs-6">Popolare</span>
                                        @endif

                                    @endforeach

                                    {{-- Badge Categoria --}}
                                    @if ($post->category)
                                        <span class="badge bg-secondary me-2 fs-6">{{$post->category->name}}</span>
                                    @endif

                                </div>
                                <p class="text-secondary mb-0 small text-black fs-6 text-break">
                                    {{ Str::limit($post->description, 300) }}</p>
                            </div>

                            <!-- Pulsante -->
                            <a href="{{route('posts.show', $post)}}" class="btn btn-primary btn-sm pe-4 ps-4 py-2 fs-5 fw-semibold">Leggi</a>
                        </div>
                    @endforeach
                    <div class="d-flex justify-content-center mt-4">
                        {{ $posts->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layout>
