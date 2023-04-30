@extends('layouts.main')
@section('container')

<div class="wrapper d-flex align-items-stretch">
  @include('dashboard.layouts.sidebar')
  <div id="content" class="p-md-3">
    @include('dashboard.layouts.navbar')
    
    {{-- content --}}
    <form method="POST" action="{{ route('jalur-masuk.update', $jalur_masuk->id) }}">
    @csrf
    @method('PUT')
    <div class="mb-3">
        <label for="nama" class="form-label">Nama Jalur</label>
        <input type="text" class="form-control @error('nama') is-invalid @enderror" id="nama" name="nama" value="{{ old('nama', $jalur_masuk->nama) }}">
        @error('nama')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </div>
    <div class="mb-3">
        <label for="biaya" class="form-label">Biaya</label>
        <input type="number" class="form-control @error('biaya') is-invalid @enderror" id="biaya" name="biaya"  value="{{ old('biaya', $jalur_masuk->biaya) }}">
        @error('biaya')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </div>
    <div class="mb-3">
        <label for="jumlah_maks_pendaftar" class="form-label">Jumlah Maksimal Pendaftar</label>
        <input type="number" class="form-control @error('jumlah_maks_pendaftar') is-invalid @enderror" id="jumlah_maks_pendaftar" name="jumlah_maks_pendaftar"  value="{{ old('jumlah_maks_pendaftar', $jalur_masuk->jumlah_maks_pendaftar) }}">
        @error('jumlah_maks_pendaftar')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </div>
    <div class="mb-3">
        <label for="status" class="form-label">Status</label>
        <select class="form-select @error('status') is-invalid @enderror" id="status" name="status">
            <option value="aktif" {{ old('status', $jalur_masuk->status) == "aktif" ? 'selected' : '' }}>Aktif</option>
            <option value="tidak aktif" {{ old('status', $jalur_masuk->status) == "tidak aktif" ? 'selected' : '' }}>Tidak Aktif</option>
        </select>
        @error('status')
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