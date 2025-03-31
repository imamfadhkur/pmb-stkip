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
            <h3 class="mx-4 mt-2">Pilih 3 Prodi yang berbeda ya, {{ $nama }}!</h3>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <form action="{{ url('berkas') }}" method="POST">
                @csrf
                
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
                
                @if (session('errorProdi'))
                    <div class="alert alert-danger">{{ session('errorProdi') }}</div>
                @endif
                <div class="form-group m-4">
                <label>Pilihan 1</label>
                <select class="form-control" id="pilihan1" name="pilihan1">
                    @foreach($prodis as $pilihan)
                    @if ($pilihan->sisa_kuota > 0)
                        <option value="{{ $pilihan->id }}">{{ $pilihan->nama }}</option>
                    @endif
                    @endforeach
                </select>
                </div>
            
                <div class="form-group m-4">
                <label>Pilihan 2</label>
                <select class="form-control" id="pilihan2" name="pilihan2">
                    @foreach($prodis as $pilihan2)
                    @if ($pilihan2->sisa_kuota > 0)
                        <option value="{{ $pilihan2->id }}">{{ $pilihan2->nama }}</option>
                    @endif
                    @endforeach
                </select>
                </div>
            
                <div class="form-group m-4">
                <label>Pilihan 3</label>
                <select class="form-control" id="pilihan3" name="pilihan3">
                    @foreach($prodis as $pilihan3)
                    @if ($pilihan3->sisa_kuota > 0)
                        <option value="{{ $pilihan3->id }}">{{ $pilihan3->nama }}</option>
                    @endif
                    @endforeach
                </select>
                <i class="text-danger">disarankan untuk memilih 3 prodi yang berbeda.</i><br>
                </div>

                <button type="submit" class="btn btn-primary mx-4">Selanjutnya</button>
              </form>              
        </div>
    </div>
</div>

@endsection