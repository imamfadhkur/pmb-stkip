@extends('layouts.main')
@section('container')

<div class="container my-5 p-5">
    @foreach ($jalur_masuks as $jalur_masuk)    
        <div class="row">
            <div class="col">
                <div class="card text-center m-3">
                    <div class="card-header">
                      <h5>{{ $jalur_masuk->nama }}</h5>
                    </div>
                    <div class="card-body">
                      {{-- <h5 class="card-title">Special title treatment</h5> --}}
                        @php
                            $deskripsi = strip_tags($jalur_masuk->deskripsi); // menghapus tag HTML dari deskripsi
                            $desk = Str::limit($deskripsi, rand(160, 200)); // membatasi jumlah karakter secara random
                        @endphp
                        <p class="card-text">{!! $desk !!}</p>
                      <a href="/info-jalur-seleksi/{{ $jalur_masuk->id }}" class="">Selengkapnya</a>
                    </div>
                    <div class="card-footer text-body-secondary">
                      {{ $jalur_masuk->updated_at->format('d F Y H:i:s') }}
                    </div>
                </div>
            </div>
        </div>
    @endforeach
    <div class="row">
        <div class="d-flex justify-content-end">
            {{ $jalur_masuks->links() }}
        </div>
    </div>
</div>

@endsection