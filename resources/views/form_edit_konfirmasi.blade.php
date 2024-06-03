@extends('layouts.main')
@section('container')

<div class="container my-5">
    <div class="row">
        <div class="col">
            <h4 class="mx-4 mt-3">Edit Data Anda:</h4>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <form action="{{ url('daftar') }}" method="POST">
                @csrf

                <table class="table mx-4">
                    <tr>
                        <td>Jenjang Pendidikan</td>
                        <td>
                            <select class="form-control" id="jenjang_pendidikan" name="jenjang_pendidikan">
                                @foreach(DB::table('jenjang_pendidikans')->get() as $jp)
                                    <option value="{{ $jp->id }}" {{ ($jenjang_pendidikan == $jp->id) ? 'selected' : '' }}>{{ $jp->nama }}</option>
                                @endforeach
                            </select>
                        </td>
                    </tr>
                    <tr><td>sistem kuliah</td>
                        <td>
                            <select class="form-control" id="sistem_kuliah" name="sistem_kuliah">
                                @foreach(DB::table('sistem_kuliahs')->get() as $sk)
                                    <option value="{{ $sk->id }}" {{ ($sistem_kuliah == $sk->id) ? 'selected' : '' }}>{{ $sk->nama }}</option>
                                @endforeach
                            </select>
                        </td>
                    </tr>
                    <tr><td>jalur masuk</td>
                        <td>
                            <select class="form-control" id="jalur_masuk" name="jalur_masuk">
                                @foreach(DB::table('jalur_masuks')->get() as $jm)
                                    <option value="{{ $jm->id }}" {{ ($jalur_masuk == $jm->id) ? 'selected' : '' }}>{{ $jm->nama }}</option>
                                @endforeach
                            </select>
                        </td>
                    </tr>
                    <tr><td>nama</td>
                        <td><input type="text" name="nama" class="form-control" value="{{ old('nama', $nama) }}">
                            @error('nama')
                              <div class="alert alert-danger mt-2">{{ $message }}</div>
                            @enderror</td>
                    </tr>
                    <tr><td>jenis kelamin</td>
                        <td><select name="jk" class="form-control">
                            <option value="L" {{ old('jk', $jk) == 'L' ? 'selected' : '' }}>Laki-laki</option>
                            <option value="P" {{ old('jk', $jk) == 'P' ? 'selected' : '' }}>Perempuan</option>
                          </select>
                          @error('jk')
                            <div class="alert alert-danger mt-2">{{ $message }}</div>
                          @enderror </td>
                    </tr>
                    <tr><td>hp</td>
                        <td><input type="number" name="hp" class="form-control" value="{{ old('hp', $hp) }}">
                            @error('hp')
                              <div class="alert alert-danger mt-2">{{ $message }}</div>
                            @enderror</td>
                    </tr>
                    <tr><td>email</td>
                        <td><input type="email" name="email" class="form-control" value="{{ old('email', $email) }}">@error('email')
                            <div class="alert alert-danger mt-2">{{ $message }}</div>
                          @enderror</td>
                    </tr>
                    <tr><td>tempat, tanggal lahir</td>
                        <td>
                            <input type="text" name="tempat_lahir" value="{{ old('tempat_lahir', $tempat_lahir) }}" required>
                            <input type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir', $tanggal_lahir) }}" required>
                            @error('tanggal_lahir')
                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                  @enderror</td>
                    </tr>
                    <tr><td>alamat</td>
                        <td><input type="text" name="alamat" class="form-control" value="{{ old('alamat', $alamat) }}">
                            @error('alamat')
                              <div class="alert alert-danger mt-2">{{ $message }}</div>
                            @enderror</td>
                    </tr>
                    <tr><td>kewarganegaraan</td>
                        <td><input type="text" name="kewarganegaraan" class="form-control" value="{{ old('kewarganegaraan', $kewarganegaraan) }}">
                            @error('kewarganegaraan')
                            <div class="alert alert-danger mt-2">{{ $message }}</div>
                          @enderror</td>
                    </tr>
                    <tr><td>identitas kewarganegaraan</td>
                        <td><input type="number" name="identitas_kewarganegaraan" class="form-control" value="{{ old('identitas_kewarganegaraan', $identitas_kewarganegaraan) }}">@error('identitas_kewarganegaraan')
                            <div class="alert alert-danger mt-2">{{ $message }}</div>
                          @enderror
                        </td>
                    </tr>
                    <tr><td>nama ibu</td>
                        <td><input type="text" name="nama_ibu" class="form-control" value="{{ old('nama_ibu',$nama_ibu) }}">
                            @error('nama_ibu')
                              <div class="alert alert-danger mt-2">{{ $message }}</div>
                            @enderror</td>
                    </tr>
                    <tr><td>nama sekolah asal</td>
                        <td><input type="text" name="nama_sekolah" class="form-control" value="{{ old('nama_sekolah',$nama_sekolah) }}">
                            @error('nama_sekolah')
                              <div class="alert alert-danger mt-2">{{ $message }}</div>
                            @enderror</td>
                    </tr>
                    <tr><td>jenis sekolah</td>
                        <td><input type="text" name="jenis_sekolah" class="form-control" placeholder="SMA/SMK/MA/Lainnya" value="{{ old('jenis_sekolah',$jenis_sekolah) }}">
                            @error('jenis_sekolah')
                              <div class="alert alert-danger mt-2">{{ $message }}</div>
                            @enderror</td>
                    </tr>
                    <tr><td>jurusan sekolah</td>
                        <td><input type="text" name="jurusan_sekolah" placeholder="IPA/IPS/Lainnya" class="form-control" value="{{ old('jurusan_sekolah',$jurusan_sekolah) }}">
                            @error('jurusan_sekolah')
                              <div class="alert alert-danger mt-2">{{ $message }}</div>
                            @enderror</td>
                    </tr>
                    <tr><td>tahun lulus</td>
                        <td><input type="number" name="tahun_lulus" class="form-control" value="{{ old('tahun_lulus',$tahun_lulus) }}">
                            @error('tahun_lulus')
                              <div class="alert alert-danger mt-2">{{ $message }}</div>
                            @enderror</td>
                    </tr>
                    <tr><td>nisn</td>
                        <td><input type="number" name="nisn" class="form-control" value="{{ old('nisn',$nisn) }}">
                            @error('nisn')
                              <div class="alert alert-danger mt-2">{{ $message }}</div>
                            @enderror</td>
                    </tr>
                    <tr><td>alamat sekolah</td>
                        <td><input type="text" name="alamat_sekolah" class="form-control" value="{{ old('alamat_sekolah',$alamat_sekolah) }}">
                            @error('alamat_sekolah')
                              <div class="alert alert-danger mt-2">{{ $message }}</div>
                            @enderror</td>
                    </tr>
                    <tr><td>pilihan 1</td>
                        <td>
                            <select class="form-control" id="pilihan1" name="pilihan1">
                                @foreach(DB::table('prodis')->get() as $pilihan)
                                <option value="{{ $pilihan->id }}" {{ ($pilihan1 == $pilihan->id) ? 'selected' : '' }}>{{ $pilihan->nama }}</option>
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
                                <option value="{{ $pilihan->id }}" {{ ($pilihan2 == $pilihan->id) ? 'selected' : '' }}>{{ $pilihan->nama }}</option>
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
                                <option value="{{ $pilihan->id }}" {{ ($pilihan3 == $pilihan->id) ? 'selected' : '' }}>{{ $pilihan->nama }}</option>
                                @endforeach
                            </select>
                                @error('pilihan3')
                                  <div class="alert alert-danger mt-2">{{ $message }}</div>
                                @enderror
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td><i class="text-danger">disarankan untuk memilih 3 prodi yang berbeda.</i><br></td>
                    </tr>
                  </table>
                <button type="submit" class="btn btn-primary me-4" value="save" name="type">Daftar</button>
              </form>              
        </div>
    </div>
</div>

@endsection