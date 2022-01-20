@extends('layouts.auth', ['title' => 'Login']) <!-- biar ga ngetik lagi codingnya jadi manggil yang ada di auth -->

@section('content') <!-- mulai section bagian konten, buat ambil konten layout/auth juga -->
<div class="container">
    <!-- Outer Row -->
    <div class="row justify-content-center">
        <div class="col-md-4">
            <div class="img-logo text-center mt-5">
                
            </div>
            <div class="card o-hidden border-0 shadow-lg mb-3 mt-5">
                <div class="card-body p-4">
                    @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                    @endif
                    <div class="text-center">
                        <h1 class="h5 text-gray-900 mb-3">Login Admin</h1>
                    </div>
                    <form action="{{ route('login') }}" method="POST"> <!-- file nya di dalem folder vendor laravel fortify -->
                        @csrf
                        <div class="form-group">
                            <label class="font-weight-bold textuppercase">Email address</label>
                            <input type="email" name="email" value="{{ old('email') }}" class="form-control @error('email') isinvalid @enderror" placeholder="Masukkan Alamat Email">
                            @error('email')
                            <div class="alert alert-danger mt-2">
                                {{ $message }} <!-- ini nampilin pesan error kalo email salah-->
                            </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label class="font-weight-bold textuppercase">Password</label>
                            <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="Masukkan Password">
                            @error('password')
                            <div class="alert alert-danger mt-2">
                                {{ $message }} <!-- ini nampilin pesan error kalo pass salah-->
                            </div>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-primary btn-block">LOGIN</button>
                        <hr>
                        <a href="/forgot-password">Lupa Password ?</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection