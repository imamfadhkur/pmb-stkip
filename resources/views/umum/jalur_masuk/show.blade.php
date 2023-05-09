@extends('layouts.main')
@section('container')

<div class="container my-5 p-5"> 
    <div class="row">
        <div class="col">
            <div class="card m-3">
                <div class="card-body">
                    <div class="mb-4">
                        <h3 class="card-title">{{ $jalur_masuk->nama }}</h3>
                        <i class="text-secondary">Di update pada: {{ $jalur_masuk->updated_at->format('d F Y H:i:s') }}</i>
                    </div>
                    <div>
                        <p>biaya: {{ $jalur_masuk->biaya }}</p>
                        <p>jumlah pendaftar: {{ $jalur_masuk->jumlah_pendaftar }}</p>
                        <p>jumlah maks pendaftar: {{ $jalur_masuk->jumlah_maks_pendaftar }}</p>
                        <p>status: {{ $jalur_masuk->status }}</p>
                        <p class="card-text mt-3">{!! $jalur_masuk->deskripsi !!}</p>
                        <i><a href="/info-jalur-seleksi">Kembali...</a></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection