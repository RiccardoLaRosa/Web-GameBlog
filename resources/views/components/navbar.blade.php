<nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm">
    <div class="container-fluid justify-content-center ps-6 pe-6">
        <!-- Brand -->
        <a class="navbar-brand fw-bold fs-2 text-gradient me-4" href="/">GameBlog</a>

        <!-- Toggle per mobile -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown"
            aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Menu -->
        <div class="collapse navbar-collapse justify-content-center" id="navbarNavDropdown">
            <ul class="navbar-nav me-auto">

                <li class="nav-item">
                    <a class="nav-link px-2 fs-5" href="/">Home</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link px-2 fs-5" href="{{route('posts.index')}}">Posts</a>
                </li>

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle px-2 fs-5" href="#" role="button" data-bs-toggle="dropdown">
                        Categorie
                    </a>
                    <ul class="dropdown-menu">
                        @foreach ($categories as $category)
                            <li><a class="dropdown-item fs-6" href="{{route('byCategory', $category)}}">{{$category->name}}</a></li>
                        @endforeach
                    </ul>
                </li>
            </ul>

            <!-- Auth Links -->
            <ul class="navbar-nav ms-auto justify-content-center">
                @guest
                    <li class="nav-item">
                        <a class="nav-link px-2 fs-5" href="{{route('login')}}">Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link px-2 fs-5" href="{{route('register')}}">Registrati</a>
                    </li>
                @endguest

                <li class="nav-item dropdown">
                    @auth
                        <a class="nav-link px-2 fs-5 dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                            Bentornato, {{auth()->user()->name}}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end mt-1 px-2 text-center">
                            <li><a class="dropdown-item fs-6" href="{{route('posts.create')}}">Nuovo Post</a></li>
                            <li><a class="dropdown-item fs-6" href="#">Gestisci Categorie</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <form action="{{route('logout')}}" method="POST" class="px-3 py-2">
                                @csrf
                                <button type="submit" class="btn btn-danger w-100 fs-6">Logout</button>
                            </form>
                        </ul>
                    @endauth
                </li>
            </ul>
        </div>
    </div>
</nav>