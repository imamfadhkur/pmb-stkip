@extends('layouts.main')
@section('container')

<div class="wrapper d-flex align-items-stretch">
  @include('dashboard.layouts.sidebar')
  <div id="content" class="p-md-3">
    @include('dashboard.layouts.navbar')
    
    {{-- content --}}
    <form method="POST" action="{{ route('jalur-masuk.store') }}">
    @csrf
    <div class="form-group m-2">
        <label for="nama" class="form-label">Nama Jalur</label>
        <input type="text" class="form-control @error('nama') is-invalid @enderror" id="nama" name="nama" value="{{ old('nama') }}">
        @error('nama')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </div>
    <div class="form-group m-2">
        <label for="biaya" class="form-label">Biaya</label>
        <input type="number" class="form-control @error('biaya') is-invalid @enderror" id="biaya" name="biaya"  value="{{ old('biaya') }}">
        @error('biaya')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </div>
    {{-- <div class="form-group m-2">
        <label for="jumlah_maks_pendaftar" class="form-label">Jumlah Maksimal Pendaftar</label>
        <input type="number" class="form-control @error('jumlah_maks_pendaftar') is-invalid @enderror" id="jumlah_maks_pendaftar" name="jumlah_maks_pendaftar"  value="{{ old('jumlah_maks_pendaftar') }}">
        @error('jumlah_maks_pendaftar')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </div> --}}
    <div class="form-group m-2">
        <label class="form-label">Jumlah Pendaftar per Prodi</label>
        <table class="table table-hover">
            @foreach ($prodis as $prodi)
                <tr>
                    <td>
                        <input type="hidden" value="{{ $prodi->id }}">
                        <label for="kuota_{{ $prodi->id }}" class="form-label">{{ $prodi->nama }}</label>
                    </td>
                    <td>
                        <input type="text" class="form-control @error('kuota_' . $prodi->id) is-invalid @enderror" id="kuota_{{ $prodi->id }}" name="kuota_{{ $prodi->id }}"  value="{{ old('kuota_' . $prodi->id) }}" required>
                        @error('kuota_' . $prodi->id)
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </td>
                </tr>
            @endforeach
        </table>
        @error('jumlah_maks_pendaftar')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </div>
    <div class="form-group m-2">
        <label for="status" class="form-label">Status</label>
        <select class="form-select @error('status') is-invalid @enderror" id="status" name="status">
            <option value="aktif" {{ old('status') == "aktif" ? 'selected' : '' }}>Aktif</option>
            <option value="tidak aktif" {{ old('status') == "tidak aktif" ? 'selected' : '' }}>Tidak Aktif</option>
        </select>
        @error('status')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </div>
    <div class="form-group m-2 mb-4">
        <label class="mt-4" for="deskripsi">Deskripsi Jalur Masuk:</label>
        <textarea class="{{ $errors->has('deskripsi') ? ' is-invalid' : '' }}" name="deskripsi" id="editor1" required>{{ old('deskripsi') }}</textarea>
        @if ($errors->has('deskripsi'))
            <div class="invalid-feedback">
                {{ $errors->first('deskripsi') }}
            </div>
        @endif
    </div>
    
    <button type="submit" class="btn btn-primary">Submit</button>
</form>
{{-- end content --}}

    </div>
</div>

<script>
    CKEDITOR.replace( 'editor1' );
</script>

@endsection