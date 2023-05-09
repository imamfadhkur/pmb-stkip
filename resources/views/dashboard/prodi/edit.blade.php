@extends('layouts.main')
@section('container')

<div class="wrapper d-flex align-items-stretch">
  @include('dashboard.layouts.sidebar')
  <div id="content" class="p-md-3">
    @include('dashboard.layouts.navbar')
    
    {{-- content --}}
    <form method="POST" action="{{ route('prodi.update', $prodi->id) }}">
    @csrf
    @method('PUT')
    <div class="form-group m-2">
        <label for="nama" class="form-label">Nama Prodi</label>
        <input type="text" class="form-control @error('nama') is-invalid @enderror" id="nama" name="nama" value="{{ old('nama', $prodi->nama) }}">
        @error('nama')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </div>
    <div class="form-group m-2 mb-4">
        <label class="mt-4" for="deskripsi">Deskripsi Prodi:</label>
        <textarea class="{{ $errors->has('deskripsi') ? ' is-invalid' : '' }}" name="deskripsi" id="editor1" required>{{ old('deskripsi', $prodi->deskripsi) }}</textarea>
        @if ($errors->has('deskripsi'))
            <div class="invalid-feedback">
                {{ $errors->first('deskripsi') }}
            </div>
        @endif
    </div>
    <a href="/prodi" class="btn btn-danger ms-2">cancel</a>
    <button type="submit" class="btn btn-primary ms-2">Submit</button>
</form>
{{-- end content --}}

    </div>
</div>

<script>
    CKEDITOR.replace( 'editor1' );
</script>

@endsection