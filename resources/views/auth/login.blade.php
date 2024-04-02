@extends('layouts.main')
@section('container')
<div class="container my-5">
    <div class="row d-flex justify-content-center align-items-center">
        <div class="col col-md-8 col-lg-6">
                <main class="form-signin p-4 shadow-lg">
                <h1 class="h3 mb-3 fw-normal text-center">Please Login</h1>
                <form action="{{ URL('login') }}" method="POST">
                    @csrf
                    @error('email')
                        <div class="alert alert-danger mt-2">{{ $message }}</div>
                    @enderror
                    <div class="form-group mt-4">
                        @isset($username)
                        <input type="hidden" value="{{ $username }}" name="oldemail">
                        <input type="hidden" value="{{ $password }}" name="oldpassword">
                        <div class="alert alert-warning" role="alert">
                            <p>Catat dan simpan data berikut ini untuk login anda: <br>Username: {{ $username }} <br>Password: {{ $password }} <br>dan rubah password anda ketika login</p>
                        </div>
                        @endisset
                        Username/Email
                        <input type="text" class="form-control my-2 @error('email')
                            is-invalid
                        @enderror" name="email" id="email" required value="{{ old('email') }}">
                    </div>
                    <div class="form-group mt-4">
                        Password
                        <input type="password" class="form-control my-2" id="password" name="password" placeholder="Password" required>
                        <input type="checkbox" onclick="showPassword()" class="mb-4"> Show Password
                    </div>
                    @if (session()->has('loginError'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <b>{{ session('loginError') }}</b>
                            @if (session()->has('username')) <br><br>
                                Username dan password anda adalah: <br>Username: {{ session('username') }} <br>Password: {{ session('password') }}
                                <input type="hidden" value="{{ session('username') }}" name="oldemail">
                                <input type="hidden" value="{{ session('password') }}" name="oldpassword">
                            @endif
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                    <input type="hidden" value="camaba" name="role">
                    <button class="w-100 btn btn-lg btn-primary" type="submit">Login</button>
                </form>
                </main>
        </div>
    </div>
</div>
@endsection