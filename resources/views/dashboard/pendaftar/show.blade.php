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
    <tr><td>nama ibu</td>
        <td>{{ $register->nama_ibu }}</td>
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
    <tr><td>NISN</td>
        <td>{{ $register->nisn }}</td>
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
    <tr><td>Status Pembayaran</td>
        <td>
            @if ($register->pembayaran === "belum")
                <p class="text-danger"><b>belum</b></p>
            @else
                <p class="text-success"><b>sudah</b></p>
            @endif
        </td>
    </tr>
    <tr><td>Status Penerimaan</td>
        <td>
            @if ($register->status_diterima === "diterima")
                <p class="text-success"><b>{{ $register->status_diterima }}</b></p>
            @else
                <p class="text-danger"><b>{{ $register->status_diterima }}</b></p>
            @endif
        </td>
    </tr>
    <tr><td>Diterima di Prodi</td>
        <td>
            @if ($register->diterima_di !== null)
                <p class="text-success"><b>{{ $register->diterimadi->nama }}</b></p>
            @else
                <p class="text-secondary"><i>belum ditentukan</i></p>
            @endif
        </td>
    </tr>
    <tr><td>Bukti Pembayaran</td>
        <td>
            <img style="max-width: 100%;" src="{{ asset('storage/'.$register->bukti_pembayaran) }}" alt="{{ $register->nama }}">
        </td>
    </tr>
</tr>
<tr>
    <td>Pas Foto 3*4
    </td>
    <td>
        @if (isset($berkas->pas_foto_file) && $berkas->pas_foto_file !== null)
            <a style="color: blue; text-decoration: none" href="{{ asset('storage/'.$berkas->pas_foto_file) }}" download="{{ $berkas->pas_foto }}">{{ $berkas->pas_foto }}</a>
        @else
        <i class="text-secondary">belum upload</i>
        @endif        
    </td>
</tr>
<tr>
    <td>ijazah/skl
    </td>
    <td>
        @if (isset($berkas->ijazah_skl_file) && $berkas->ijazah_skl_file !== null)
            <a style="color: blue; text-decoration: none" href="{{ asset('storage/'.$berkas->ijazah_skl_file) }}" download="{{ $berkas->ijazah_skl }}">{{ $berkas->ijazah_skl }}</a>
        @else
        <i class="text-secondary">belum upload</i>
        @endif        
    </td>
</tr>
<tr>
    <td>KK 
    </td>
    <td>
        @if (isset($berkas->kk_file) && $berkas->kk_file !== null)
            <a style="color: blue; text-decoration: none" href="{{ asset('storage/'.$berkas->kk_file) }}" download="{{ $berkas->kk }}">{{ $berkas->kk }}</a>
        @else
        <i class="text-secondary">belum upload</i>
        @endif        
    </td>
</tr>
<tr>
    <td>KTP 
    </td>
    <td>
        @if (isset($berkas->ktp_file) && $berkas->ktp_file !== null)
            <a style="color: blue; text-decoration: none" href="{{ asset('storage/'.$berkas->ktp_file) }}" download="{{ $berkas->ktp }}">{{ $berkas->ktp }}</a>
        @else
        <i class="text-secondary">belum upload</i>
        @endif        
    </td>
</tr>
<tr>
    <td>Akta Kelahiran 
    </td>
    <td>
        @if (isset($berkas->akta_file) && $berkas->akta_file !== null)
            <a style="color: blue; text-decoration: none" href="{{ asset('storage/'.$berkas->akta_file) }}" download="{{ $berkas->akta }}">{{ $berkas->akta }}</a>
        @else
        <i class="text-secondary">belum upload</i>
        @endif        
    </td>
</tr>
<tr>
    <td>Dokumen pendukung jalur masuk yang dipilih
    </td>
    <td>
        @if (isset($berkas->doc_pend_jalur_masuk_file) && $berkas->doc_pend_jalur_masuk_file !== null)
            <a style="color: blue; text-decoration: none" href="{{ asset('storage/'.$berkas->doc_pend_jalur_masuk_file) }}" download="{{ $berkas->doc_pend_jalur_masuk }}">{{ $berkas->doc_pend_jalur_masuk }}</a>
        @else
        <i class="text-secondary">belum upload</i>
        @endif        
    </td>
</tr>
<tr>
    <td>Periode Pendaftaran 
    </td>
    <td>
        {{ $register->created_at->format('Y') }}
    </td>
</tr>
<tr>
    <td>Tanggal Pendaftaran 
    </td>
    <td>
        {{ $register->created_at->format('H:i:s d/m/Y') }}
    </td>
</tr>
</table>
<a href="{{ route('register.index') }}" class="btn btn-sm btn-primary ms-4">
    <i class="bi bi-arrow-left"></i> Back
</a>
@can('superadmin')    
    <a href="{{ route('register.edit', $register->email) }}" class="btn btn-sm btn-warning ms-2">
        <i class="bi bi-pencil"></i> Edit
    </a>
    <form action="{{ url('hapus/'. $register->id) }}" method="POST" class="d-inline">
        @csrf
        @method('DELETE')
        <input type="hidden" name="id" value="{{ $register->id }}">
        <button onclick="return confirm('apakah anda yakin ingin menghapus?')" title="Hapus pendaftar {{ $register->nama }}" type="submit" class="btn btn-sm btn-danger m-1">
            <i class="bi bi-trash"></i> Delete
        </button>
    </form>
@endcan


    </div>
</div>

@endsection