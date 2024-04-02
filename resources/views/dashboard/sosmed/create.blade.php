@extends('layouts.main')
@section('container')

<div class="wrapper d-flex align-items-stretch">
  @include('dashboard.layouts.sidebar')
  <div id="content" class="p-md-3">
    @include('dashboard.layouts.navbar')
    
    {{-- content --}}
    <form method="POST" action="{{ url('settings/store_sosmed') }}">
    @csrf
    <div class="mb-3">
        <label for="nama_platform" class="form-label">Nama Platform</label>
        <input type="text" class="form-control @error('nama_platform') is-invalid @enderror" id="nama_platform" name="nama_platform" value="{{ old('nama_platform') }}">
        @error('nama_platform')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </div>
    <div class="mb-3">
        <label for="link" class="form-label">Link</label>
        <input type="text" class="form-control @error('link') is-invalid @enderror" id="link" name="link"  value="{{ old('link') }}" required>
        @error('link')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </div>
    <div class="mb-3">
        <label for="icon" class="form-label">Icon</label>
        <select class="form-select @error('icon') is-invalid @enderror" id="icon" name="icon">
            <option value="" selected disabled>Pilih Icon</option>
            <option value="<i class='bi bi-pinterest'></i>" {{ old('icon') == "<i class='bi bi-pinterest'></i>" ? 'selected' : '' }}><i class="bi bi-pinterest"></i> Pinterest</option>
            <option value="<i class='bi bi-facebook'></i>" {{ old('icon') == "<i class='bi bi-facebook'></i>" ? 'selected' : '' }}><i class="bi bi-facebook"></i> Facebook</option>
            <option value="<i class='bi bi-whatsapp'></i>" {{ old('icon') == "<i class='bi bi-whatsapp'></i>" ? 'selected' : '' }}><i class="bi bi-whatsapp"></i> WhatSapp</option>
            <option value="<i class='bi bi-messenger'></i>" {{ old('icon') == "<i class='bi bi-messenger'></i>" ? 'selected' : '' }}><i class="bi bi-messenger"></i> Messanger</option>
            <option value="<i class='bi bi-meta'></i>" {{ old('icon') == "<i class='bi bi-meta'></i>" ? 'selected' : '' }}><i class="bi bi-meta"></i> Meta</option>
            <option value="<i class='bi bi-linkedin'></i>" {{ old('icon') == "<i class='bi bi-linkedin'></i>" ? 'selected' : '' }}><i class="bi bi-linkedin"></i> LinkedIn</option>
            <option value="<i class='bi bi-tiktok'></i>" {{ old('icon') == "<i class='bi bi-tiktok'></i>" ? 'selected' : '' }}><i class="bi bi-tiktok"></i> TikTok</option>
            <option value="<i class='bi bi-instagram'></i>" {{ old('icon') == "<i class='bi bi-instagram'></i>" ? 'selected' : '' }}><i class="bi bi-instagram"></i> Instagram</option>
            <option value="<i class='bi bi-youtube'></i>" {{ old('icon') == "<i class='bi bi-youtube'></i>" ? 'selected' : '' }}><i class="bi bi-youtube"></i> YouTube</option>
            <option value="<i class='bi bi-twitter'></i>" {{ old('icon') == "<i class='bi bi-twitter'></i>" ? 'selected' : '' }}><i class="bi bi-twitter"></i> Twitter</option>
            <option value="<i class='bi bi-envelope'></i>" {{ old('icon') == "<i class='bi bi-envelope'></i>" ? 'selected' : '' }}><i class="bi bi-envelope"></i> Email</option>
        </select>
        @error('icon')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </div>
    
    <button type="submit" class="btn btn-primary">Submit</button>
</form>
{{-- end content --}}

    </div>
</div>

@endsection