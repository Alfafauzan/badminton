@extends('layouts.auth')
@section('title', 'Login')

@section('auth')
    <div class="container d-flex justify-content-center align-items-center min-vh-100">
        <div class="col-md-6 col-lg-4">
            <div class="card shadow rounded-lg">

                <div class="card-body p-4">
                    <h3 class="text-center font-weight-bold mb-2">Welcome Back</h3>
                    <p class="text-center text-muted mb-4">Sign in to your account</p>

                    {{-- Tampilkan error login jika ada --}}
                    @if (Session::has('success'))
                        <div class="alert alert-success">
                            {{ Session::get('success') }}
                        </div>
                    @endif
                    @if (session('error'))
                        <div class="alert alert-danger" role="alert">
                            {{ session('error') }}
                        </div>
                    @endif

                    {{-- DIUBAH: action menunjuk ke route 'login' --}}
                    <form action="{{ route('login') }}" method="POST">
                        @csrf
                        <div class="form-group mb-3">
                            <label for="email">Email</label>
                            <div class="input-group">
                                {{-- DIUBAH: Tambahkan old() dan @error --}}
                                <input type="email" name="email" id="email"
                                    class="form-control @error('email') is-invalid @enderror" placeholder="you@example.com"
                                    value="{{ old('email') }}">
                                <div class="input-group-append"><span class="input-group-text"><i
                                            class="fas fa-envelope"></i></span></div>
                            </div>
                            @error('email')
                                <span class="text-danger small">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="password">Password</label>
                            <div class="input-group">
                                <input type="password" name="password" id="password"
                                    class="form-control @error('password') is-invalid @enderror"
                                    placeholder="Your password">
                                <div class="input-group-append"><span class="input-group-text"><i
                                            class="fas fa-lock"></i></span></div>
                            </div>
                            @error('password')
                                <span class="text-danger small">{{ $message }}</span>
                            @enderror
                        </div>



                        <button type="submit" class="btn btn-block btn-primary font-weight-bold mt-4">Login</button>
                    </form>

                    <p class="mt-4 text-center">
                        Don't have an account?
                        <a href="{{ route('register') }}" class="text-primary font-weight-bold">Register</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
@endsection
