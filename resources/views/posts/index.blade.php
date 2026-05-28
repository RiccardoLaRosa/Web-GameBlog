<x-layout>
    <div class="py-5" style="min-height:100vh; background: linear-gradient(135deg, #272e3bcb, #2c2d3fcc);">
        <div class="py-5">
            <div class="ms-6 me-6">
                <!-- Titolo della sezione -->
                <h2 class="text-white fw-bold mb-2">Ultimi Post</h2>
                <p class="text-secondary text-white mb-4">Scopri le ultime novità dal nostro blog di giochi. Non perdere
                    i post più
                    interessanti!</p>

                <div class="list-group">
                    @foreach ($posts as $post)
                        <div
                            class="list-group-item list-group-item-dark mb-3 rounded d-flex align-items-center justify-content-between">

                            <!-- Immagine -->
                            <img src="{{ Storage::url($post->image) }}" alt="{{ $post->title }}"
                                class="img-fluid rounded me-3 img-index">

                            <!-- Testo -->
                            <div class="flex-grow-1 me-3">
                                <div class="d-flex align-items-center mb-1">
                                    <h5 class="text-black fw-semibold mb-0 me-2 fs-4">{{ $post->title }}</h5>

                                    {{-- Badge --}}
                                    @foreach ($post->tags as $tag)
                                        @if ($tag->id == 1)
                                            <span class="badge bg-success me-2 fs-6">Nuovo</span>
                                        @endif

                                        @if ($tag->id == 2)
                                            <span class="badge bg-warning me-2 fs-6">Popolare</span>
                                        @endif

                                        @if ($tag->id == 3)
                                            <span class="badge bg-primary me-2 fs-6">DLC</span>
                                        @endif

                                    @endforeach

                                    {{-- Badge Categoria --}}
                                    <span class="badge bg-secondary me-2 fs-6">{{$post->category->name}}</span>

                                </div>
                                <p class="text-secondary mb-0 small text-black fs-6">
                                    {{ Str::limit($post->description, 300) }}</p>
                            </div>

                            <!-- Pulsante -->
                            <a href="#" class="btn btn-primary btn-sm pe-4 ps-4 py-2 fs-5 fw-semibold">Leggi</a>
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
