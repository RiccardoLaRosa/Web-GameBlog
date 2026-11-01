<footer class="bg-dark text-light py-5 mt-auto">
    <div class="container">
        <div class="row g-4">

            <!-- Logo e descrizione -->
            <div class="col-md-6">
                <div class="p-3 bg-secondary bg-opacity-10 rounded-3 h-100 d-flex flex-column justify-content-between">
                    <h5 class="navbar-brand fw-bold fs-4 text-gradient me-4">GameBlog</h5>
                    <p class="text-light">
                        Il tuo punto di riferimento per notizie, recensioni e guide sui videogiochi.
                    </p>
                    <small class="text-secondary">&copy; {{ date('Y') }} GameBlog</small>
                </div>
            </div>

            <!-- Link utili -->
            <div class="col-md-6">
                <div class="p-3 bg-secondary bg-opacity-10 rounded-3 h-100">
                    <h5 class="fw-bold mb-3">Link Utili</h5>
                    <ul class="list-unstyled">
                        <li><a href="{{ url('/') }}" class="text-white text-decoration-none d-block py-1 fw-semibold">Home</a></li>
                        <li><a href="{{ route('posts.index') }}" class="text-white text-decoration-none d-block py-1 fw-semibold">Posts</a></li>
                        <li><a href="{{ route('privacy') }}" class="text-white text-decoration-none d-block py-1 fw-semibold">Privacy Policy</a></li>
                    </ul>
                </div>
            </div>

        </div>

        <div class="text-center text-white mt-4 small">
            Tutti i diritti riservati.
        </div>
    </div>
</footer>
