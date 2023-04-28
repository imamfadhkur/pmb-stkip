@extends('layouts.main')
@section('container')

<div class="container my-4">
    <div class="row">
        <div class="col">
            <h4 class="mx-4 mt-3">Konfirmasi Data Anda:</h4>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <form action="daftar" method="POST">
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
                <input type="hidden" value="{{ $pilihan1 }}" name="pilihan1">
                <input type="hidden" value="{{ $pilihan2 }}" name="pilihan2">
                <input type="hidden" value="{{ $pilihan3 }}" name="pilihan3">

                <table class="table mx-4">
                    <tr>
                        <td>Jenjang Pendidikan</td>
                        <td>
                            @php
                                $jenjangPendidikan = DB::table('jenjang_pendidikans')->where('id', $jenjang_pendidikan)->first();
                            @endphp
                            {{ $jenjangPendidikan->nama }}
                        </td>
                    </tr>
                    <tr><td>sistem kuliah</td>
                        <td>
                            @php
                                $sistemKuliah = DB::table('sistem_kuliahs')->where('id', $sistem_kuliah)->first();
                            @endphp
                            {{ $sistemKuliah->nama }}
                        </td>
                    </tr>
                    <tr><td>jalur masuk</td>
                        <td>
                            @php
                                $jalurMasuk = DB::table('jalur_masuks')->where('id', $jalur_masuk)->first();
                            @endphp
                            {{ $jalurMasuk->nama }}
                        </td>
                    </tr>
                    <tr><td>nama</td>
                        <td>{{ $nama }}</td>
                    </tr>
                    <tr><td>jenis kelamin</td>
                        <td>{{ $jk }}</td>
                    </tr>
                    <tr><td>hp</td>
                        <td>{{ $hp }}</td>
                    </tr>
                    <tr><td>email</td>
                        <td>{{ $email }}</td>
                    </tr>
                    <tr><td>tempat, tanggal lahir</td>
                        <td>{{ $tempat_lahir }}, {{ \Carbon\Carbon::parse($tanggal_lahir)->format('d-m-Y') }}</td>
                    </tr>
                    <tr><td>alamat</td>
                        <td>{{ $alamat }}</td>
                    </tr>
                    <tr><td>kewarganegaraan</td>
                        <td>{{ $kewarganegaraan }}</td>
                    </tr>
                    <tr><td>identitas kewarganegaraan</td>
                        <td>{{ $identitas_kewarganegaraan }}</td>
                    </tr>
                    <tr><td>nama sekolah</td>
                        <td>{{ $nama_sekolah }}</td>
                    </tr>
                    <tr><td>jenis sekolah</td>
                        <td>{{ $jenis_sekolah }}</td>
                    </tr>
                    <tr><td>jurusan sekolah</td>
                        <td>{{ $jurusan_sekolah }}</td>
                    </tr>
                    <tr><td>tahun lulus</td>
                        <td>{{ $tahun_lulus }}</td>
                    </tr>
                    <tr><td>alamat sekolah</td>
                        <td>{{ $alamat_sekolah }}</td>
                    </tr>
                    <tr><td>pilihan 1</td>
                        <td>
                            @php
                                $pilihan1 = DB::table('prodis')->where('id', $pilihan1)->first();
                            @endphp
                            {{ $pilihan1->nama }}
                        </td>
                    </tr>
                    <tr><td>pilihan 2</td>
                        <td>
                            @php
                                $pilihan2 = DB::table('prodis')->where('id', $pilihan2)->first();
                            @endphp
                            {{ $pilihan2->nama }}
                        </td>
                    </tr>
                    <tr><td>pilihan 3</td>
                        <td>
                            @php
                                $pilihan3 = DB::table('prodis')->where('id', $pilihan3)->first();
                            @endphp
                            {{ $pilihan3->nama }}
                        </td>
                    </tr>
                  </table>
              
                <button type="submit" class="btn btn-light ms-4" value="edit" name="type">Edit</button>
                <button type="submit" class="btn btn-primary me-4" value="save" name="type">Daftar</button>
              </form>              
        </div>
    </div>
</div>

@endsection