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
            <h3 class="mx-4 mt-2">Pemberkasan</h3>
            <p class="mx-4"><span class="text-danger">*</span>Lengkapi berkas dibawah ini</p>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <form action="{{ url('daftar') }}" method="POST" enctype="multipart/form-data">
                @csrf
                
                @if ($errors->any())
                    <ul class="alert alert-danger">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                @endif
                {{-- data hidden --}}
                <input type="hidden" value="{{ $jenjang_pendidikan }}" name="jenjang_pendidikan">
                <input type="hidden" value="{{ $sistem_kuliah }}" name="sistem_kuliah">
                <input type="hidden" value="{{ $jalur_masuk }}" name="jalur_masuk">
                <input type="hidden" value="{{ $nama }}" name="nama">
                <input type="hidden" value="{{ $jk }}" name="jk">
                <input type="hidden" value="{{ $hp }}" name="hp">
                <input type="hidden" value="{{ $email }}" name="email">
                <input type="hidden" value="{{ $tempat_lahir }}" name="tempat_lahir">
                <input type="hidden" value="{{ $tanggal_lahir }}" name="tanggal_lahir">
                <input type="hidden" value="{{ $alamat }}" name="alamat">
                <input type="hidden" value="{{ $kewarganegaraan }}" name="kewarganegaraan">
                <input type="hidden" value="{{ $identitas_kewarganegaraan }}" name="identitas_kewarganegaraan">
                <input type="hidden" value="{{ $nama_sekolah }}" name="nama_sekolah">
                <input type="hidden" value="{{ $jenis_sekolah }}" name="jenis_sekolah">
                <input type="hidden" value="{{ $jurusan_sekolah }}" name="jurusan_sekolah">
                <input type="hidden" value="{{ $tahun_lulus }}" name="tahun_lulus">
                <input type="hidden" value="{{ $alamat_sekolah }}" name="alamat_sekolah">
                <input type="hidden" value="{{ $nisn }}" name="nisn">
                <input type="hidden" value="{{ $nama_ibu }}" name="nama_ibu">
                <input type="hidden" value="{{ $pilihan1 }}" name="pilihan1">
                <input type="hidden" value="{{ $pilihan2 }}" name="pilihan2">
                <input type="hidden" value="{{ $pilihan3 }}" name="pilihan3">
                
                <div class="form-group m-4">
                    <label><span class="text-danger">*</span>Pas Foto</label>
                    <input type="file" name="pas_foto" class="form-control" required>
                </div>
                
                <div class="form-group m-4">
                    <label><span class="text-danger">*</span>Ijazah/SKL</label>
                    <input type="file" name="ijazah_skl" class="form-control" required>
                </div>
                
                <div class="form-group m-4">
                    <label><span class="text-danger">*</span>SKHUN</label>
                    <input type="file" name="skhun" class="form-control" required>
                </div>
                
                <div class="form-group m-4">
                    <label><span class="text-danger">*</span>KK</label>
                    <input type="file" name="kk" class="form-control" required>
                </div>
                
                <div class="form-group m-4">
                    <label><span class="text-danger">*</span>KTP</label>
                    <input type="file" name="ktp" class="form-control" required>
                </div>
                
                <div class="form-group m-4">
                    <label><span class="text-danger">*</span>Akta Kelahiran</label>
                    <input type="file" name="akta" class="form-control" required>
                </div>

                <button type="submit" class="btn btn-primary mx-4" value="save" name="type" onclick="return confirm('Apakah anda yakin data yang anda masukkan benar?')">Daftar</button>
              </form>              
        </div>
    </div>
</div>

@endsection