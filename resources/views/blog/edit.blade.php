<x-layout>
    <div style="min-height:100vh; background: linear-gradient(135deg, #272e3bcb, #2c2d3fcc);">
    <div class="container py-5">
        <h2 class="text-white mb-4">Modifica post</h2>

        <form action="{{ route('posts.update', $post) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label class="form-label text-white">Titolo</label>
                <input type="text" name="title" class="form-control"
                    value="{{ old('title', $post->title) }}">
                @error('title') <div class="text-danger">{{ $message }}</div> @enderror
            </div>

            <div class="mb-3">
                <label class="form-label text-white">Descrizione</label>
                <textarea name="description" rows="6" class="form-control">{{ old('description', $post->description) }}</textarea>
                @error('description') <div class="text-danger">{{ $message }}</div> @enderror
            </div>

            <div class="mb-3">
                <label class="form-label text-white">Categoria</label>
                <select name="category_id" class="form-select">
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}"
                            @selected(old('category_id', $post->category_id) == $category->id)>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
                @error('category_id') <div class="text-danger">{{ $message }}</div> @enderror
            </div>

            <div class="mb-3">
                <label class="form-label text-white d-block">Tag</label>
                @foreach ($tags as $tag)
                    <div class="form-check form-check-inline text-white">
                        <input class="form-check-input" type="checkbox" name="tag[]"
                            value="{{ $tag->id }}" id="tag{{ $tag->id }}"
                            @checked(in_array($tag->id, old('tag', $post->tags->pluck('id')->toArray())))>
                        <label class="form-check-label" for="tag{{ $tag->id }}">{{ $tag->message }}</label>
                    </div>
                @endforeach
            </div>

            <div class="mb-3">
                <label class="form-label text-white">Immagine</label>
                @if ($post->image)
                    <div class="mb-2">
                        <img src="{{ Storage::url($post->image) }}" alt="{{ $post->title }}" style="max-height:150px">
                    </div>
                @endif
                <input type="file" name="image" class="form-control">
                <small class="text-secondary">Lascia vuoto per mantenere l'immagine attuale.</small>
                @error('image') <div class="text-danger">{{ $message }}</div> @enderror
            </div>

            <button type="submit" class="btn btn-primary">Salva modifiche</button>
            <a href="{{ route('posts.show', $post) }}" class="btn btn-secondary">Annulla</a>
        </form>
    </div>
    </div>
</x-layout>