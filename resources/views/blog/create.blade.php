<x-layout>

    <div class="container py-5">

        <div class="row justify-content-center">
            <div class="col-12 col-md-8 col-lg-6">

                <div class="card shadow-sm border-0 rounded-4">
                    <div class="card-body p-4">

                        <h3 class="text-center mb-4 fw-bold">
                            Inserisci un nuovo Post
                        </h3>

                        {{-- Success message --}}
                        @if (session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif

                        <form action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            {{-- TITOLO --}}
                            <div class="mb-3">
                                <label class="form-label">Titolo</label>
                                <input type="text" name="title" value="{{ old('title') }}"
                                    class="form-control @error('title') is-invalid @enderror"
                                    placeholder="Inserisci il titolo">

                                @error('title')
                                    <div class="invalid-feedback d-block">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            {{-- DESCRIZIONE --}}
                            <div class="mb-3">
                                <label class="form-label">Descrizione</label>
                                <input type="text" name="description" value="{{ old('description') }}"
                                    class="form-control @error('description') is-invalid @enderror"
                                    placeholder="Inserisci la descrizione">

                                @error('description')
                                    <div class="invalid-feedback d-block">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            {{-- CATEGORIA --}}
                            <div class="mb-3">
                                <label class="form-label">Categoria</label>
                                <select name="category_id" class="form-select">
                                    <option value="">-- Seleziona categoria --</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}">
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- TAGS --}}
                            <div class="mb-3">
                                <label class="form-label">Tag</label>

                                <div class="d-flex flex-wrap gap-2">
                                    @foreach ($tags as $tag)
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="tag[]"
                                                value="{{ $tag->id }}" id="tag{{ $tag->id }}">

                                            <label class="form-check-label" for="tag{{ $tag->id }}">
                                                {{ $tag->message }}
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            {{-- IMMAGINE --}}
                            <div class="mb-3">
                                <label class="form-label">Immagine</label>
                                <input type="file" name="image" class="form-control">
                            </div>

                            {{-- BUTTON --}}
                            <div class="d-grid">
                                <button type="submit" class="btn btn-success btn-lg">
                                    Inserisci Post
                                </button>
                            </div>

                        </form>

                    </div>
                </div>

            </div>
        </div>

    </div>

</x-layout>
