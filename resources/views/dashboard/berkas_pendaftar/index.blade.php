@extends('layouts.main')
@section('container')

<div class="container text-center my-4">
  <div class="row">
    <div class="col">
        @if (isset($berkas->pas_foto) && $berkas->pas_foto !== null)
          <img src="{{ asset('storage/'.$berkas->pas_foto_file) }}" alt="foto profil" class="rounded-circle img-thumbnail" style="width: 180px; height: 180px;">  
        @else
          <img src="{{ asset('assets/images/temporary-profile.jpg') }}" alt="foto profil" class="rounded-circle img-thumbnail" style="width: 180px; height: 180px;">            
        @endif
        <br>
        <table class="table text-start mt-3">
          <tr>
            <td>Nama</td>
            <td>:</td>
            <td>{{ $user->name }}</td>
          </tr>
          <tr>
            <td>Email</td>
            <td>:</td>
            <td>{{ $user->email }}</td>
          </tr>
          <tr>
            <td>Pilihan Prodi</td>
            <td>:</td>
            <td>
              pilihan 1: {{ $user->register->pilihan1Prodi->nama }} <br>
              pilihan 2: {{ $user->register->pilihan2Prodi->nama }} <br>
              pilihan 3: {{ $user->register->pilihan3Prodi->nama }}
            </td>
          </tr>
        </table>
    </div>
  </div>
</div>

@endsection