<x-layout>
    <div class="tab-content" id="pills-tabContent-grid-img">
        <div class="tab-pane tab-example-design fade show active" id="pills-grid-img-design" role="tabpanel"
            aria-labelledby="pills-grid-img-design-tab">

            <!-- Titolo Galleria -->
            <div class="container text-center my-5 position-relative">
                <h1 class="fw-bold display-4 text-gradient mb-3">Le Nostre Selezioni</h1>
                <p class="fs-5">Scopri i giochi e i contenuti più popolari del momento</p>
                <!-- Effetto sottolineatura animata -->
                <div class="mx-auto mt-3 line_animation"></div>
            </div>
            
            {{-- Galleria Immagini --}}
            <div class="gallery m-5">

                <!-- gallery-item -->
                <figure class="gallery__item gallery__item--1 m-0">
                    <img src="{{ asset('image/mario.jpg') }}" alt="Gallery image 1" class="gallery__img rounded-3">
                </figure>
                <!-- gallery-item -->
                <figure class="gallery__item gallery__item--2 m-0">
                    <img src="{{ asset('image/elden.jpg') }}" alt="Gallery image 2" class="gallery__img rounded-3">
                </figure>
                <!-- gallery-item -->
                <figure class="gallery__item gallery__item--3 m-0">
                    <img src="{{ asset('image/hogw.jpg') }}" alt="Gallery image 3" class="gallery__img rounded-3">
                </figure>
                <!-- gallery-item -->
                <figure class="gallery__item gallery__item--4">
                    <img src="{{ asset('image/rema.jpg') }}" alt="Gallery image 4" class="gallery__img rounded-3">
                </figure>
                <!-- gallery-item -->
                <figure class="gallery__item gallery__item--5">
                    <img src="{{ asset('image/db.jpg') }}" alt="Gallery image 6" class="gallery__img rounded-3">
                </figure>

                <!-- gallery-item -->
                <figure class="gallery__item gallery__item--6">
                    <img src="{{ asset('image/BO.jpg') }}" alt="Gallery image 6" class="gallery__img rounded-3">
                </figure>
            </div>
        </div>

        {{-- Sezione News --}}
        <div id="latest-news" class="container my-5">
            <h2 class="mb-4 fw-bold text-center">Ultime Notizie</h2>
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="card h-100 shadow-sm rounded-4 overflow-hidden">
                        <img src="{{ asset('image/nier.jpg') }}" class="card-img-top" alt="News 1">
                        <div class="card-body">
                            <h5 class="card-title">Recensione Nier Automata</h5>
                            <p class="card-text">Scopri tutti i segreti del nuovo titolo FromSoftware e come affrontare i boss più duri.</p>
                            <a href="#" class="btn btn-outline-primary btn-sm">Leggi di più</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card h-100 shadow-sm rounded-4 overflow-hidden">
                        <img src="{{ asset('image/exp.png') }}" class="card-img-top" alt="News 2">
                        <div class="card-body">
                            <h5 class="card-title">Expediction 33</h5>
                            <p class="card-text ">Tutti i consigli per completare ogni livello e trovare tutte le lune nascoste.</p>
                            <a href="#" class="btn btn-outline-primary btn-sm">Leggi di più</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card h-100 shadow-sm rounded-4 overflow-hidden">
                        <img src="{{ asset('image/top.jpg') }}" class="card-img-top" alt="News 3">
                        <div class="card-body">
                            <h5 class="card-title">Top 10 giochi del 2025</h5>
                            <p class="card-text">I giochi più attesi e quelli che hanno fatto più parlare quest'anno.</p>
                            <a href="#" class="btn btn-outline-primary btn-sm">Leggi di più</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Sezione Newsletter --}}
        <div class=" mx-auto mt-3 line_animation2 mb-5 p-3 rounded-4 text-center shadow">
            <h2 class="fw-bold">Non perdere le novità!</h2>
            <p>Iscriviti alla nostra newsletter e resta aggiornato su recensioni, guide e news sui tuoi giochi preferiti.</p>
            <form class="row justify-content-center g-2">
                <div class="col-auto">
                    <input type="email" class="form-control" placeholder="Inserisci la tua email">
                </div>
                <div class="col-auto">
                    <button type="submit" class="btn btn-primary">Iscriviti</button>
                </div>
            </form>
        </div>

</x-layout>
