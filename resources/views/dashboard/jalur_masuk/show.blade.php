@extends('layouts.main')
@section('container')

<div class="wrapper d-flex align-items-stretch">
  @include('dashboard.layouts.sidebar')
  <div id="content" class="p-md-3">
    @include('dashboard.layouts.navbar')
    
{{-- content --}}
    <div class="container mb-5">
        <div class="row">
            <div class="col">
                <h3>{{ $jalurMasuk->nama }}</h3>
                <p>biaya: {{ $jalurMasuk->biaya }}</p>
                <p>jumlah pendaftar: {{ $jalurMasuk->jumlah_pendaftar }}</p>
                <p>jumlah maks pendaftar: {{ $jalurMasuk->jumlah_maks_pendaftar }}</p>
                <p>status: {{ $jalurMasuk->status }}</p>
                <p class="mb-1">{!! $jalurMasuk->deskripsi !!}</p>
                <a href="/jalur-masuk" class="btn btn-primary">back</a>
                <a href="{{ route('jalur-masuk.edit', $jalurMasuk->id) }}" class="btn btn-warning ms-2">edit</a>
            </div>
        </div>
    </div>
</div>
</div>
{{-- end content --}}

@endsection