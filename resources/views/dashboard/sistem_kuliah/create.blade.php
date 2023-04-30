@extends('layouts.main')
@section('container')

<div class="wrapper d-flex align-items-stretch">
  @include('dashboard.layouts.sidebar')
  <div id="content" class="p-md-3">
    @include('dashboard.layouts.navbar')
    
    {{-- content --}}
    <form method="POST" action="{{ route('sistem-kuliah.store') }}">
    @csrf
    <div class="mb-3">
        <label for="nama" class="form-label">Nama Sistem Kuliah</label>
        <input type="text" class="form-control @error('nama') is-invalid @enderror" id="nama" name="nama" value="{{ old('nama') }}">
        @error('nama')
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