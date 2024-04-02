@extends('layouts.main')
@section('container')

{{-- cek kalau data simpanan tidak ada, maka redirect ke menu pendaftaran awal --}}
@if(!isset($jenjang_pendidikan) && !old('jenjang_pendidikan'))
  <script>
    window.location.replace("/jalur-pendaftaran");
  </script>
@endif


<div class="container my-5">
    <div class="row">
        <div class="col">
            <h3 class="mx-4 mt-2">Data Diri</h3>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <form action="{{ url('asal-sekolah') }}" method="POST">
                @csrf
                  <input type="hidden" value="{{ old('jenjang_pendidikan', $jenjang_pendidikan) }}" name="jenjang_pendidikan">
                  <input type="hidden" value="{{ old('sistem_kuliah', $sistem_kuliah) }}" name="sistem_kuliah">
                  <input type="hidden" value="{{ old('jalur_masuk', $jalur_masuk) }}" name="jalur_masuk">
                <div class="form-group m-4">
                  <label for="nama">Nama</label>
                  <input type="text" name="nama" class="form-control" value="{{ old('nama') }}">
                  @error('nama')
                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                  @enderror
                </div>
              
                <div class="form-group m-4">
                  <label for="jk">Jenis Kelamin</label>
                  <select name="jk" class="form-control">
                    <option value="L" {{ old('jk') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                    <option value="P" {{ old('jk') == 'P' ? 'selected' : '' }}>Perempuan</option>
                  </select> 
                  @error('jk')
                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                  @enderror               
                </div>
              
                <div class="form-group m-4">
                  <label for="hp">Nomor HP</label>
                  <input type="number" name="hp" class="form-control" value="{{ old('hp') }}">
                  @error('hp')
                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                  @enderror
                </div>

                <div class="form-group m-4">
                  <label for="email">Email</label>
                  <input type="email" name="email" class="form-control" value="{{ old('email') }}">
                  @error('email')
                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                  @enderror
                </div>

                <div class="form-group m-4">
                  <label for="tempat_lahir">Tempat, Tanggal Lahir</label><br>
                  <input type="text" name="tempat_lahir" value="{{ old('tempat_lahir') }}" required>
                  <input type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir') }}" required>
                  @error('tanggal_lahir')
                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                  @enderror
                </div>

                <div class="form-group m-4">
                  <label for="alamat">Alamat</label>
                  <input type="text" name="alamat" class="form-control" value="{{ old('alamat') }}">
                  @error('alamat')
                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                  @enderror
                </div>

                <div class="form-group m-4">
                  <label for="kewarganegaraan">Negara</label>
                  <input type="text" name="kewarganegaraan" class="form-control" value="{{ old('kewarganegaraan') }}">
                  @error('kewarganegaraan')
                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                  @enderror
                </div>

                <div class="form-group m-4">
                  <label for="identitas_kewarganegaraan">Nomor NIK</label>
                  <input type="number" name="identitas_kewarganegaraan" class="form-control" value="{{ old('identitas_kewarganegaraan') }}">
                  @error('identitas_kewarganegaraan')
                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                  @enderror
                </div>

                <div class="form-group m-4">
                  <label for="nisn">NISN</label>
                  <input type="number" name="nisn" class="form-control" value="{{ old('nisn') }}">
                  @error('nisn')
                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                  @enderror
                </div>

                <div class="form-group m-4">
                  <label for="nama_ibu">Nama Ibu</label>
                  <input type="text" name="nama_ibu" class="form-control" value="{{ old('nama_ibu') }}">
                  @error('nama_ibu')
                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                  @enderror
                </div>
              
                <button type="submit" class="btn btn-primary mx-4">Selanjutnya</button>
              </form>              
        </div>
    </div>
</div>

@endsection