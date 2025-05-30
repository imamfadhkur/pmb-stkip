@extends('layouts.main')
@section('container')

<div class="container my-5 p-5"> 
    <div class="row">
        <div class="col">
            <h4 class="m-3"><a href="{{ url('/') }}" class="text-decoration-none text-dark"><i class="bi bi-house-door"></i>:</a> <a href="{{ url('info-jalur-masuk') }}">Jalur Masuk</a> / <a href="{{ url('info-jalur-masuk/'. $jalur_masuk->id) }}" class="">{{ $jalur_masuk->nama }}</a></h4>
            <div class="card m-3">
                <div class="card-body">
                    <div class="mb-4">
                        <h3 class="card-title">{{ $jalur_masuk->nama }}</h3>
                        @if($jalur_masuk->updated_at)
                            <i class="text-secondary">Di update pada: {{ $jalur_masuk->updated_at->format('d F Y H:i:s') }}</i>
                        @endif
                    </div>
                    <div>
                        <p>biaya: {{ $jalur_masuk->biaya }}</p>
                        <p>jumlah pendaftar: {{ $jalur_masuk->jumlah_pendaftar }}</p>
                        <p>jumlah maksimum pendaftar: {{ $jalur_masuk->jumlah_maks_pendaftar }}</p>
                        <p>
                            <table class="table table-border table-hover">
                                <tr>
                                    <td>prodi</td>
                                    <td>sisa kuota</td>
                                </tr>
                                @if (count($jalur_masuk_prodi) == 0)
                                    <tr>
                                        <td colspan="2"><i class="text-secondary">tidak ada data</i></td>
                                    </tr>
                                @else
                                    @foreach ($jalur_masuk_prodi as $jmp)
                                        <tr>
                                            <td>{{ $jmp->prodi_name }}</td>
                                            <td>{{ $jmp->kuota }}</td>
                                        </tr>
                                    @endforeach
                                @endif
                            </table>
                        </p>
                        {{-- <p>status: {{ $jalur_masuk->status }}</p> --}}
                        <p class="card-text mt-3">{!! $jalur_masuk->deskripsi !!}</p>
                        <i><a href="{{ url('info-jalur-masuk') }}">Kembali...</a></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection