@extends('layouts.main')
@section('container')

<div class="wrapper d-flex align-items-stretch">
  @include('dashboard.layouts.sidebar')
  <div id="content" class="p-md-3">
    @include('dashboard.layouts.navbar')
    

<table class="table mx-4">
    <tr><td>nama</td>
        <td>{{ $register->nama }}</td>
    </tr>
    <tr><td>jenis kelamin</td>
        <td>{{ $register->jk }}</td>
    </tr>
    <tr><td>hp</td>
        <td>{{ $register->hp }}</td>
    </tr>
    <tr><td>email</td>
        <td>{{ $register->email }}</td>
    </tr>
    <tr><td>tempat, tanggal lahir</td>
        <td>{{ $register->tempat_lahir }}, {{ \Carbon\Carbon::parse($register->tanggal_lahir)->format('d-m-Y') }}</td>
    </tr>
    <tr><td>alamat</td>
        <td>{{ $register->alamat }}</td>
    </tr>
    <tr><td>kewarganegaraan</td>
        <td>{{ $register->kewarganegaraan }}</td>
    </tr>
    <tr><td>identitas kewarganegaraan</td>
        <td>{{ $register->identitas_kewarganegaraan }}</td>
    </tr>
    <tr><td>nama sekolah asal</td>
        <td>{{ $register->nama_sekolah }}</td>
    </tr>
    <tr><td>jenis sekolah</td>
        <td>{{ $register->jenis_sekolah }}</td>
    </tr>
    <tr><td>jurusan sekolah</td>
        <td>{{ $register->jurusan_sekolah }}</td>
    </tr>
    <tr><td>tahun lulus</td>
        <td>{{ $register->tahun_lulus }}</td>
    </tr>
    <tr><td>alamat sekolah</td>
        <td>{{ $register->alamat_sekolah }}</td>
    </tr>
    <tr>
        <td>Jenjang Pendidikan</td>
        <td>
            @php
                $jenjangPendidikan = DB::table('jenjang_pendidikans')->where('id', $register->jenjang_pendidikan_id)->first();
            @endphp
            {{ $jenjangPendidikan->nama }}
        </td>
    </tr>
    <tr><td>sistem kuliah</td>
        <td>
            @php
                $sistemKuliah = DB::table('sistem_kuliahs')->where('id', $register->sistem_kuliah_id)->first();
            @endphp
            {{ $sistemKuliah->nama }}
        </td>
    </tr>
    <tr><td>jalur masuk</td>
        <td>
            @php
                $jalurMasuk = DB::table('jalur_masuks')->where('id', $register->jalur_masuk_id)->first();
            @endphp
            {{ $jalurMasuk->nama }}
        </td>
    </tr>
    <tr><td>pilihan 1</td>
        <td>
            @php
                $pilihan1 = DB::table('prodis')->where('id', $register->pilihan1)->first();
            @endphp
            {{ $pilihan1->nama }}
        </td>
    </tr>
    <tr><td>pilihan 2</td>
        <td>
            @php
                $pilihan2 = DB::table('prodis')->where('id', $register->pilihan2)->first();
            @endphp
            {{ $pilihan2->nama }}
        </td>
    </tr>
    <tr><td>pilihan 3</td>
        <td>
            @php
                $pilihan3 = DB::table('prodis')->where('id', $register->pilihan3)->first();
            @endphp
            {{ $pilihan3->nama }}
        </td>
    </tr>
</table>
<a href="{{ route('register.index') }}" class="btn btn-primary ms-4">back</a>
<a href="{{ route('register.edit', $register->email) }}" class="btn btn-warning ms-2">edit</a>


    </div>
</div>

@endsection