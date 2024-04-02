@extends('layouts.main')
@section('container')

<div class="container my-5 p-5"> 
    <div class="row">
        <div class="col">
            <h4 class="m-3"><a href="{{ url('/') }}" class="text-decoration-none text-dark"><i class="bi bi-house-door"></i>:</a> <a href="{{ url('info-prodi') }}">Prodi</a> / <a href="{{ url('info-prodi/'. $prodi->id) }}" class="">{{ $prodi->nama }}</a></h4>
            <div class="card m-3">
                <div class="card-body">
                    <div class="mb-3">
                        <h3 class="card-title">{{ $prodi->nama }}</h3>
                        @if($prodi->updated_at)
                            <i class="text-secondary">Di update pada: {{ $prodi->updated_at->format('d F Y H:i:s') }}</i>
                        @endif
                        <p class="mt-3">kuota: {{ $prodi->kuota }} <br>
                        sisa: {{ $prodi->sisa_kuota }}</p>
                    </div>
                    <div>
                        <p class="card-text mt-3">{!! $prodi->deskripsi !!}</p>
                        <i><a href="{{ url('info-prodi') }}">Kembali...</a></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection