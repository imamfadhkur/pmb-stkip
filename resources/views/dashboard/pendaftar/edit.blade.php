@extends('layouts.main')
@section('container')

<div class="wrapper d-flex align-items-stretch">
  @include('dashboard.layouts.sidebar')
  <div id="content" class="p-md-3">
    @include('dashboard.layouts.navbar')
    

<form action="{{ route('register.update', $register->id) }}" method="POST" enctype="multipart/form-data">
    @method('PUT')
    @csrf
    <table class="table mx-4">
        <tr><td>nama</td>
            <td><input type="text" name="nama" class="form-control" value="{{ old('nama', $register->nama) }}">
                @error('nama')
                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                @enderror</td>
        </tr>
        <tr><td>jenis kelamin</td>
            <td><select name="jk" class="form-control">
                <option value="L" {{ old('jk', $register->jk) == 'L' ? 'selected' : '' }}>Laki-laki</option>
                <option value="P" {{ old('jk', $register->jk) == 'P' ? 'selected' : '' }}>Perempuan</option>
                </select>
                @error('jk')
                <div class="alert alert-danger mt-2">{{ $message }}</div>
                @enderror </td>
        </tr>
        <tr><td>hp</td>
            <td><input type="number" name="hp" class="form-control" value="{{ old('hp', $register->hp) }}">
                @error('hp')
                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                @enderror</td>
        </tr>
        <tr><td>email</td>
            <td><input type="email" name="email" class="form-control" value="{{ old('email', $register->email) }}">@error('email')
                <div class="alert alert-danger mt-2">{{ $message }}</div>
                @enderror</td>
        </tr>
        <tr><td>tempat, tanggal lahir</td>
            <td>
                <input type="text" name="tempat_lahir" value="{{ old('tempat_lahir', $register->tempat_lahir) }}" required>
                <input type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir', $register->tanggal_lahir) }}" required>
                @error('tanggal_lahir')
        <div class="alert alert-danger mt-2">{{ $message }}</div>
        @enderror</td>
        </tr>
        <tr><td>alamat</td>
            <td><input type="text" name="alamat" class="form-control" value="{{ old('alamat', $register->alamat) }}">
                @error('alamat')
                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                @enderror</td>
        </tr>
        <tr><td>kewarganegaraan</td>
            <td><input type="text" name="kewarganegaraan" class="form-control" value="{{ old('kewarganegaraan', $register->kewarganegaraan) }}">
                @error('kewarganegaraan')
                <div class="alert alert-danger mt-2">{{ $message }}</div>
                @enderror</td>
        </tr>
        <tr><td>identitas kewarganegaraan</td>
            <td><input type="number" name="identitas_kewarganegaraan" class="form-control" value="{{ old('identitas_kewarganegaraan', $register->identitas_kewarganegaraan) }}">@error('identitas_kewarganegaraan')
                <div class="alert alert-danger mt-2">{{ $message }}</div>
                @enderror
            </td>
        </tr>
        <tr><td>nama sekolah asal</td>
            <td><input type="text" name="nama_sekolah" class="form-control" value="{{ old('nama_sekolah',$register->nama_sekolah) }}">
                @error('nama_sekolah')
                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                @enderror</td>
        </tr>
        <tr><td>jenis sekolah</td>
            <td><input type="text" name="jenis_sekolah" class="form-control" placeholder="SMA/SMK/MA/Lainnya" value="{{ old('jenis_sekolah',$register->jenis_sekolah) }}">
                @error('jenis_sekolah')
                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                @enderror</td>
        </tr>
        <tr><td>jurusan sekolah</td>
            <td><input type="text" name="jurusan_sekolah" placeholder="IPA/IPS/Lainnya" class="form-control" value="{{ old('jurusan_sekolah',$register->jurusan_sekolah) }}">
                @error('jurusan_sekolah')
                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                @enderror</td>
        </tr>
        <tr><td>tahun lulus</td>
            <td><input type="number" name="tahun_lulus" class="form-control" value="{{ old('tahun_lulus',$register->tahun_lulus) }}">
                @error('tahun_lulus')
                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                @enderror</td>
        </tr>
        <tr><td>alamat sekolah</td>
            <td><input type="text" name="alamat_sekolah" class="form-control" value="{{ old('alamat_sekolah',$register->alamat_sekolah) }}">
                @error('alamat_sekolah')
                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                @enderror</td>
        </tr>
        <tr>
            <td>Jenjang Pendidikan</td>
            <td>
                <select class="form-control" id="jenjang_pendidikan_id" name="jenjang_pendidikan_id">
                    @foreach(DB::table('jenjang_pendidikans')->get() as $jp)
                        <option value="{{ $jp->id }}" {{ (old('jenjang_pendidikan_id',$register->jenjang_pendidikan_id) == $jp->id) ? 'selected' : '' }}>{{ $jp->nama }}</option>
                    @endforeach
                </select>
                @error('jenjang_pendidikan_id')
                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                @enderror
            </td>
        </tr>
        <tr><td>sistem kuliah</td>
            <td>
                <select class="form-control" id="sistem_kuliah_id" name="sistem_kuliah_id">
                    @foreach(DB::table('sistem_kuliahs')->get() as $sk)
                        <option value="{{ $sk->id }}" {{ (old('sistem_kuliah_id',$register->sistem_kuliah_id) == $sk->id) ? 'selected' : '' }}>{{ $sk->nama }}</option>
                    @endforeach
                </select>
                @error('sistem_kuliah_id')
                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                @enderror
            </td>
        </tr>
        <tr><td>jalur masuk</td>
            <td>
                <select class="form-control" id="jalur_masuk_id" name="jalur_masuk_id">
                    @foreach(DB::table('jalur_masuks')->get() as $jm)
                        <option value="{{ $jm->id }}" {{ (old('jalur_masuk_id',$register->jalur_masuk_id) == $jm->id) ? 'selected' : '' }}>{{ $jm->nama }}</option>
                    @endforeach
                </select>
                @error('jalur_masuk_id')
                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                @enderror
            </td>
        </tr>
        <tr><td>pilihan 1</td>
            <td>
                <select class="form-control" id="pilihan1" name="pilihan1">
                    @foreach(DB::table('prodis')->get() as $pilihan)
                    <option value="{{ $pilihan->id }}" {{ (old('pilihan1', $register->pilihan1) == $pilihan->id) ? 'selected' : '' }}>{{ $pilihan->nama }}</option>
                    @endforeach
                </select>
                    @error('pilihan1')
                        <div class="alert alert-danger mt-2">{{ $message }}</div>
                    @enderror
            </td>
        </tr>
        <tr><td>pilihan 2</td>
            <td>
                <select class="form-control" id="pilihan2" name="pilihan2">
                    @foreach(DB::table('prodis')->get() as $pilihan)
                    <option value="{{ $pilihan->id }}" {{ (old('pilihan2', $register->pilihan2) == $pilihan->id) ? 'selected' : '' }}>{{ $pilihan->nama }}</option>
                    @endforeach
                </select>
                    @error('pilihan2')
                        <div class="alert alert-danger mt-2">{{ $message }}</div>
                    @enderror
            </td>
        </tr>
        <tr><td>pilihan 3</td>
            <td>
                <select class="form-control" id="pilihan3" name="pilihan3">
                    @foreach(DB::table('prodis')->get() as $pilihan)
                    <option value="{{ $pilihan->id }}" {{ (old('pilihan3', $register->pilihan3) == $pilihan->id) ? 'selected' : '' }}>{{ $pilihan->nama }}</option>
                    @endforeach
                </select>
                    @error('pilihan3')
                        <div class="alert alert-danger mt-2">{{ $message }}</div>
                    @enderror
            </td>
        </tr>
        <tr>
            <td>Pembayaran</td>
            <td>
                <div class="form-check">
                    <input type="radio" class="form-check-input @error('pembayaran') is-invalid @enderror" name="pembayaran" value="sudah" {{ old('pembayaran', $register->pembayaran) === 'sudah' ? 'checked' : '' }}>
                    <label class="form-check-label">sudah</label>
                </div>
                <div class="form-check">
                    <input type="radio" class="form-check-input @error('pembayaran') is-invalid @enderror" name="pembayaran" value="belum" {{ old('pembayaran', $register->pembayaran) === 'belum' ? 'checked' : '' }}>
                    <label class="form-check-label">belum</label>
                </div>
                @error('pembayaran')
                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                @enderror
            </td>
        </tr>
        <tr><td>bukti pembayaran</td>
            <td>
                <img class="img-preview" class="mb-2" src="{{ asset('storage/'.$register->bukti_pembayaran) }}" alt="pengumuman" style="max-width: 100px;" hidden>
                @if($register->bukti_pembayaran)
                <script>document.querySelector('.img-preview').removeAttribute('hidden')</script>
                @endif
                <input type="file" name="bukti_pembayaran" id="bukti_pembayaran" class="form-control{{ $errors->has('bukti_pembayaran') ? ' is-invalid' : '' }}" onchange="previewImage()">
                @if ($errors->has('bukti_pembayaran'))
                    <div class="invalid-feedback">
                        {{ $errors->first('bukti_pembayaran') }}
                    </div>
                @endif
                @error('bukti_pembayaran')
                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                @enderror
            </td>
        </tr>
        <tr>
            <td>Status Penerimaan</td>
            <td>
                <div class="form-check">
                    <input type="radio" class="form-check-input @error('status_diterima') is-invalid @enderror" name="status_diterima" value="diterima" {{ old('status_diterima', $register->status_diterima) === 'diterima' ? 'checked' : '' }}>
                    <label class="form-check-label">diterima</label>
                </div>
                <div class="form-check">
                    <input type="radio" class="form-check-input @error('status_diterima') is-invalid @enderror" name="status_diterima" value="tidak diterima" {{ old('status_diterima', $register->status_diterima) === 'tidak diterima' ? 'checked' : '' }}>
                    <label class="form-check-label">tidak diterima</label>
                </div>
                @error('pembayaran')
                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                @enderror
            </td>
        </tr>
        <tr>
            <td></td>
            <td><i class="text-danger">3 pilihan tidak boleh sama.</i><br></td>
        </tr>
        </table>
    <a href="{{ route('register.index') }}" class="btn btn-danger">cancel</a>
    <button type="submit" class="btn btn-primary me-4" value="save" name="type">update</button>
</form>


    </div>
</div>
<script>
    function previewImage() {
        const image = document.querySelector('#bukti_pembayaran');
        const imgPreview = document.querySelector('.img-preview');

        // imgPreview.style.display = 'block';
        imgPreview.classList.add('mb-2');

        const oFReader = new FileReader();
        oFReader.readAsDataURL(image.files[0]);

        oFReader.onload = function(oFREvent){
            imgPreview.src = oFREvent.target.result;
        }
    }
</script>
@endsection