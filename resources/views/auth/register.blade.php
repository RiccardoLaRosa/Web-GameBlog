<x-layout>
      <!-- Form -->
      <div class="d-flex justify-content-center align-items-center mb-5 mt-5">
          <div class="col-11 col-lg-8">
            <h2>Pagina di Registrazione</h2>
            <p class="mb-4 ">Inserisci i tuoi dati Personali</p>
            <form class="row" action="{{ route('register.store') }}" method="POST">
            @csrf
              <div class="mb-3 col-12 col-md-6">
                <label for="exampleInputname" class="form-label">Nome</label>
                <input type="text" class="form-control @error('name') is-invalid @enderror" id="exampleInputname" name="name" value="{{ old('name') }}">
                @error('name')
                    <div class="alert alert-danger">{{$message}}</div>
                @enderror
              </div>
                <div class="mb-3 col-12 col-md-6">
                    <label for="exampleInputEmail1" class="form-label">Email</label>
                    <input type="email" class="form-control @error('email') is-invalid @enderror" id="exampleInputEmail1" aria-describedby="emailHelp" name="email" value="{{ old('email') }}">
                    @error('email')
                        <div class="alert alert-danger">{{$message}}</div>
                    @enderror
                </div>
                <div class="mb-3 col-12 col-md-6">
                    <label for="exampleInputPassword1" class="form-label">Password</label>
                    <input type="password" class="form-control @error('password') is-invalid @enderror" id="exampleInputPassword1" name="password">
                    @error('password')
                        <div class="alert alert-danger">{{$message}}</div>
                    @enderror
                </div>
                <div class="mb-3 col-12 col-md-6">
                    <label for="exampleInputPassword2" class="form-label">Conferma Password</label>
                    <input type="password" class="form-control" id="exampleInputPassword2" name="password_confirmation">
                </div>
                <div class="col-12">
                    <button class="btn btn-primary mt-3" type="submit">Registrati</button>
                </div>
            </form>

        </div>
    </div>

</x-layout>