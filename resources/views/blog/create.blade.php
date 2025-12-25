<x-layout>
    <form action="{{route('posts.store')}}" method="POST" enctype="multipart/form-data" class="m-5 col-6 mb-5">
        @csrf
        @if (session('success'))
            <div style="color: green">{{session('success')}}</div>
        @endif
        <h2>Inserisci qui il tuo Post</h2>

        <div class="mb-3">
            <label for="exampleInputTitle" class="form-label">Titolo</label>
            <input type="text" class="form-control @error('title') is-invalid" @enderror id="exampleInputTitle" name="title" value="{{old('title')}}">
            @error('title')
                <div class="bg-danger">{{$message}}</div>
            @enderror
        </div>

         <div class="mb-3">
            <label for="exampleInputDescription" class="form-label">Descrizione</label>
            <input type="text" class="form-control" id="exampleInputDescription" name="description">
            @error('description')
                <div class="bg-danger">{{$message}}</div>
            @enderror
        </div>

        <select name="category_id" id="">
            <option value="">-- Selezione categoria --</option>
            @foreach ($categories as $category)
                <option value="{{$category->id}}">{{$category->name}}</option>
            @endforeach
        </select>

        @foreach ($tags as $tag) 
            <input type="checkbox" name="tag[]" id="tag{{$tag->id}}" value="{{$tag->id}}">
            <label for="tag{{$tag->id}}">{{$tag->message}}</label>
        @endforeach

        <div class="mb-3">
            <label for="exampleInputImage" class="form-label">Inserisci il tuo File</label>
            <input type="file" class="form-control" id="exampleInputImage" name="image">
        </div>

        <button type="submit" class="btn btn-success">Inserisci</button>
    </form>
</x-layout>