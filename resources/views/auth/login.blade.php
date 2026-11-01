<x-layout>
      <div class="d-flex justify-content-center align-items-center m-6">
          <div class="col-11 col-md-8 col-lg-6">
            <h1 class="mb-3 text-center">Benvenuto</h1>
            <h6 class="mb-4 text-center mt-1 text-black-50">Non hai ancora un account? <a href="{{route('register')}}">Crea un account</a></h6>
            <form class="row justify-content-center" action="{{ route('login.store') }}" method="POST">
            @csrf
                <div class="mb-3 col-12 col-md-7">
                    <label for="exampleInputEmail1" class="form-label">Email</label>
                    <input type="email" class="form-control @error('email') is-invalid @enderror" id="exampleInputEmail1" aria-describedby="emailHelp" name="email" value="{{ old('email') }}">
                    @error('email')
                        <div class="alert alert-danger">{{$message}}</div>
                    @enderror
                </div>
                <div class="mb-3 col-12 col-md-7">
                    <label for="exampleInputPassword1" class="form-label">Password</label>
                    <input type="password" class="form-control @error('password') is-invalid @enderror" id="exampleInputPassword1" name="password">
                    @error('password')
                        <div class="alert alert-danger">{{$message}}</div>
                    @enderror
                </div>
                <div class="col-12 col-md-7">
                    <button class="btn btn-primary" type="submit">Accedi</button>
                </div>
                @if (config('app.privacy_owner_email'))
                    <div class="col-12 col-md-7 mt-3 small text-black-50">
                        Password dimenticata? Scrivi a
                        <a href="mailto:{{ config('app.privacy_owner_email') }}">{{ config('app.privacy_owner_email') }}</a>
                    </div>
                @endif
            </form>

        </div>
    </div>

</x-layout>
