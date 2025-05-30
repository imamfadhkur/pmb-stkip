@extends('layouts.main')
@section('container')

<div class="wrapper d-flex align-items-stretch">
  @include('dashboard.layouts.sidebar')
  <div id="content" class="p-md-3">
    @include('dashboard.layouts.navbar')
    
    {{-- content --}}
    <form method="POST" action="{{ url('user/'. $user->id) }}">
        @method('PUT')
    @csrf
    <div class="mb-3">
        <label for="name" class="form-label">Nama</label>
        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $user->name) }}">
        @error('name')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </div>
    <div class="mb-3">
        <label for="email" class="form-label">email</label>
        <input type="text" class="form-control @error('email') is-invalid @enderror" id="email" name="email"  value="{{ old('email', $user->email) }}">
        @error('email')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </div>
    <div class="mb-3">
        <label for="password" class="form-label">Password</label>
        <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password"  value="{{ old('password') }}">
        @error('password')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </div>
    <div class="mb-3">
        <label for="password_confirmation" class="form-label">Confirm Password</label>
        <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror" id="password_confirmation" name="password_confirmation"  value="{{ old('password_confirmation') }}">
        @error('password_confirmation')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </div>
    <div class="mb-3">
        <input type="checkbox" onclick="showPassword()" class="mb-4"> Show Password
    </div>
    <div class="mb-3">
        <label for="level" class="form-label">Level</label>
        <select class="form-select @error('level') is-invalid @enderror" id="level" name="level">
            <option value="" selected disabled>Pilih Level</option>
            <option value="camaba" {{ old('level', $user->level) == "camaba" ? 'selected' : '' }}>camaba</option>
            <option value="admin" {{ old('level', $user->level) == "admin" ? 'selected' : '' }}>admin</option>
            <option value="superadmin" {{ old('level', $user->level) == "superadmin" ? 'selected' : '' }}>superadmin</option>
        </select>
        @error('level')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </div>
    <a href="{{ url('user') }}" class="btn btn-warning">Cancel</a>
    <button type="submit" class="btn btn-primary">Submit</button>
</form>
{{-- end content --}}

    </div>
</div>

@endsection