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
                <table class="table table-hover">
                    <tr>
                        <td>Nama Jalur</td>
                        <td>{{ $jalurMasuk->nama }}</td>
                    </tr>
                    <tr>
                        <td>Biaya</td>
                        <td>{{ $jalurMasuk->biaya }}</td>
                    </tr>
                    <tr>
                        <td>Jumlah Pendaftar</td>
                        <td>{{ $jalurMasuk->jumlah_pendaftar }}</td>
                    </tr>
                    <tr>
                        <td>Kuota Tersedia <b>(sisa)</b></td>
                        <td>
                            <ol>
                                @if (count($available) > 0)
                                    @foreach ($available as $item)
                                        <li>{{ $item->prodi_name }} <b>({{ $item->kuota }})</b></li>
                                    @endforeach
                                @else
                                    <i class="text-secondary">tidak ada data</i>
                                @endif
                            </ol>
                        </td>
                    </tr>
                    <tr>
                        <td>Kuota Terpenuhi</td>
                        <td>
                            <ol>
                                @if (count($unavailable) == 0)
                                    <i class="text-secondary">tidak ada data</i>
                                @else
                                    @foreach ($unavailable as $item)
                                        <li>{{ $item->prodi_name }}</li>
                                    @endforeach
                                @endif
                            </ol>
                        </td>
                    </tr>
                    <tr>
                        <td>Deskripsi</td>
                        <td>{!! $jalurMasuk->deskripsi !!}</td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <a href="{{ url('jalur-masuk') }}" class="btn btn-primary">back</a>
                            <a href="{{ route('jalur-masuk.edit', $jalurMasuk->id) }}" class="btn btn-warning ms-2">edit</a>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>
</div>
{{-- end content --}}

@endsection