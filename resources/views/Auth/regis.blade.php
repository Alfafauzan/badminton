@extends('layouts.auth')
@section('title', 'Register')

@section('auth')
    <div class="container d-flex justify-content-center align-items-center min-vh-100">
        <div class="col-md-6 col-lg-5">
            <div class="card shadow rounded-lg">
                <div class="card-body p-4">
                    <h3 class="text-center font-weight-bold mb-2">Create Account</h3>
                    <p class="text-center text-muted mb-4">Join us by creating your account</p>

                    {{-- DIUBAH: action menunjuk ke route 'register' --}}
                    <form action="{{ route('register') }}" method="POST">
                        @csrf

                        {{-- Name --}}
                        <div class="form-group mb-3">
                            <label for="name">Full Name</label>
                            <div class="input-group">
                                <input type="text" name="name" id="name"
                                    class="form-control @error('name') is-invalid @enderror" placeholder="Your full name"
                                    value="{{ old('name') }}">
                                <div class="input-group-append"><span class="input-group-text"><i
                                            class="fas fa-user"></i></span></div>
                            </div>
                            @error('name')
                                <span class="text-danger small">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- Email --}}
                        <div class="form-group mb-3">
                            <label for="email">Email</label>
                            <div class="input-group">
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

                        {{-- Password --}}
                        <div class="form-group mb-3">
                            <label for="password">Password</label>
                            <div class="input-group">
                                <input type="password" name="password" id="password"
                                    class="form-control @error('password') is-invalid @enderror"
                                    placeholder="Create password">
                                <div class="input-group-append"><span class="input-group-text"><i
                                            class="fas fa-lock"></i></span></div>
                            </div>
                            @error('password')
                                <span class="text-danger small">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- Confirm Password --}}
                        <div class="form-group mb-3">
                            <label for="password_confirmation">Confirm Password</label>
                            <div class="input-group">
                                <input type="password" name="password_confirmation" id="password_confirmation"
                                    class="form-control" placeholder="Repeat password">
                                <div class="input-group-append"><span class="input-group-text"><i
                                            class="fas fa-lock"></i></span></div>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-block btn-primary font-weight-bold mt-4">Register</button>
                    </form>

                    <p class="mt-4 text-center">
                        Already have an account?
                        <a href="{{ route('login') }}" class="text-primary font-weight-bold">Login</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
@endsection
