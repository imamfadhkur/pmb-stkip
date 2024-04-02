@extends('layouts.main')
@section('container')

<div class="container my-5">
    <div class="row">
        <div class="col">
            <h3 class="mx-4 mt-2">Data Diri</h3>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <form action="{{ URL('asal-sekolah') }}" method="POST">
                @csrf
                  <input type="text" value="{{ old('jenjang_pendidikan', $jenjang_pendidikan) }}" name="jenjang_pendidikan">
                  <input type="text" value="{{ old('sistem_kuliah', $sistem_kuliah) }}" name="sistem_kuliah">
                  <input type="text" value="{{ old('jalur_masuk', $jalur_masuk) }}" name="jalur_masuk">
                <div class="form-group m-4">
                  <label for="nama">Nama</label>
                  <input type="text" name="nama" class="form-control" value="{{ old('nama') }}">
                  @error('nama')
                    <div class="alert alert-danger">{{ $message }}</div>
                  @enderror
                </div>
              
                <div class="form-group m-4">
                  <label for="jk">Jenis Kelamin</label>
                  <select name="jk" class="form-control">
                    <option value="L" {{ old('jk', $jk) == 'L' ? 'selected' : '' }}>Laki-laki</option>
                    <option value="P" {{ old('jk', $jk) == 'P' ? 'selected' : '' }}>Perempuan</option>
                  </select> 
                  @error('jk')
                    <div class="alert alert-danger">{{ $message }}</div>
                  @enderror
                </div>
              
                <div class="form-group m-4">
                  <label for="hp">Nomor HP</label>
                  <input type="number" name="hp" class="form-control">
                  @error('hp')
                    <div class="alert alert-danger">{{ $message }}</div>
                  @enderror
                </div>

                <div class="form-group m-4">
                  <label for="email">Email</label>
                  <input type="email" name="email" class="form-control">
                </div>

                <div class="form-group m-4">
                  <label for="tempat_lahir">Tempat, Tanggal Lahir</label><br>
                  <input type="text" name="tempat_lahir">
                  <input type="date" name="tanggal_lahir">
                </div>

                <div class="form-group m-4">
                  <label for="alamat">Alamat</label>
                  <input type="text" name="alamat" class="form-control">
                </div>

                <div class="form-group m-4">
                  <label for="kewarganegaraan">Negara</label>
                  <input type="text" name="kewarganegaraan" class="form-control">
                </div>

                <div class="form-group m-4">
                  <label for="identitas_kewarganegaraan">Nomor NIK</label>
                  <input type="number" name="identitas_kewarganegaraan" class="form-control">
                </div>
              
                <button type="submit" class="btn btn-primary mx-4">Selanjutnya</button>
              </form>              
        </div>
    </div>
</div>

@endsection