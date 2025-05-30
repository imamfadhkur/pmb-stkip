@extends('layouts.main')
@section('container')

<div class="container my-5 p-5">
  <div class="row">
    <div class="col">
      <h2 class="m-3 text-center"><a class="text-decoration-none" href="{{ url('info-prodi') }}">Semua Prodi</a></h2>
    </div>
  </div>
    @foreach ($prodis as $prodi)    
        <div class="row">
            <div class="col">
                <div class="card text-center m-3">
                    <div class="card-header">
                      <h5>{{ $prodi->nama }}</h5>
                    </div>
                    <div class="card-body">
                      {{-- <h5 class="card-title">Special title treatment</h5> --}}
                        @php
                            $deskripsi = strip_tags($prodi->deskripsi); // menghapus tag HTML dari deskripsi
                            $desk = Str::limit($deskripsi, rand(160, 200)); // membatasi jumlah karakter secara random
                        @endphp
                        <p class="card-text">{!! $desk !!}</p>
                      <a href="{{ url('info-prodi/'. $prodi->id) }}" class="">Selengkapnya</a>
                    </div>
                    <div class="card-footer text-body-secondary">
                        @if($prodi->updated_at)
                            {{ $prodi->updated_at->format('d F Y H:i:s') }}
                        @endif
                    </div>                  
                </div>
            </div>
        </div>
    @endforeach
    <div class="row">
        <div class="d-flex justify-content-end">
            {{ $prodis->links() }}
        </div>
    </div>
</div>

@endsection