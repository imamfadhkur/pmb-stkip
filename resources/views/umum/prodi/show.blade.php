@extends('layouts.main')
@section('container')

<div class="container my-5 p-5"> 
    <div class="row">
        <div class="col">
            <div class="card m-3">
                <div class="card-body">
                    <div class="mb-3">
                        <h3 class="card-title">{{ $prodi->nama }}</h3>
                        <i class="text-secondary">Di update pada: {{ $prodi->updated_at->format('d F Y H:i:s') }}</i>
                    </div>
                    <div>
                        <p class="card-text mt-3">{!! $prodi->deskripsi !!}</p>
                        <i><a href="/info-prodi">Kembali...</a></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection