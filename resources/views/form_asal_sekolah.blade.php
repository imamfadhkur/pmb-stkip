@extends('layouts.main')
@section('container')

{{-- cek kalau data simpanan tidak ada, maka redirect ke menu pendaftaran awal --}}
@if(!isset($jenjang_pendidikan) && !old('jenjang_pendidikan'))
  <script>
    window.location.replace("/jalur-pendaftaran");
  </script>
@endif

<div class="container my-4">
    <div class="row">
        <div class="col">
            <h3 class="mx-4 mt-2">Asal Sekolah</h3>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <form action="/data-prodi" method="POST">
                @csrf
                
                {{-- data hidden --}}
                <input type="hidden" value="{{ old('jenjang_pendidikan', $jenjang_pendidikan) }}" name="jenjang_pendidikan">
                <input type="hidden" value="{{ old('sistem_kuliah', $sistem_kuliah) }}" name="sistem_kuliah">
                <input type="hidden" value="{{ old('jalur_masuk', $jalur_masuk) }}" name="jalur_masuk">
                <input type="hidden" value="{{ old('nama', $nama) }}" name="nama">
                <input type="hidden" value="{{ old('jk', $jk) }}" name="jk">
                <input type="hidden" value="{{ old('hp', $hp) }}" name="hp">
                <input type="hidden" value="{{ old('email', $email) }}" name="email">
                <input type="hidden" value="{{ old('tempat_lahir', $tempat_lahir) }}" name="tempat_lahir">
                <input type="hidden" value="{{ old('tanggal_lahir', $tanggal_lahir) }}" name="tanggal_lahir">
                <input type="hidden" value="{{ old('alamat', $alamat) }}" name="alamat">
                <input type="hidden" value="{{ old('kewarganegaraan', $kewarganegaraan) }}" name="kewarganegaraan">
                <input type="hidden" value="{{ old('identitas_kewarganegaraan', $identitas_kewarganegaraan) }}" name="identitas_kewarganegaraan">
                
                <div class="form-group m-4">
                  <label for="nama_sekolah">Nama Sekolah</label>
                  <input type="text" name="nama_sekolah" class="form-control" value="{{ old('nama_sekolah') }}">
                  @error('nama_sekolah')
                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                  @enderror
                </div>
              
                <div class="form-group m-4">
                  <label for="jenis_sekolah">Jenis Sekolah</label>
                  <input type="text" name="jenis_sekolah" class="form-control" placeholder="SMA/SMK/MA/Lainnya" value="{{ old('jenis_sekolah') }}">
                  @error('jenis_sekolah')
                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                  @enderror
                </div>
              
                <div class="form-group m-4">
                  <label for="jurusan_sekolah">Jurusan</label>
                  <input type="text" name="jurusan_sekolah" placeholder="IPA/IPS/Lainnya" class="form-control" value="{{ old('jurusan_sekolah') }}">
                  @error('jurusan_sekolah')
                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                  @enderror
                </div>

                <div class="form-group m-4">
                  <label for="tahun_lulus">Tahun Lulus</label>
                  <input type="number" name="tahun_lulus" class="form-control" value="{{ old('tahun_lulus') }}">
                  @error('tahun_lulus')
                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                  @enderror
                </div>

                <div class="form-group m-4">
                  <label for="alamat_sekolah">Alamat Sekolah</label><br>
                  <input type="text" name="alamat_sekolah" class="form-control" value="{{ old('alamat_sekolah') }}">
                  @error('alamat_sekolah')
                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                  @enderror
                </div>
              
                <button type="submit" class="btn btn-primary mx-4">Selanjutnya</button>
              </form>              
        </div>
    </div>
</div>

@endsection