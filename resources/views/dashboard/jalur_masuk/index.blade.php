@extends('layouts.main')
@section('container')

<div class="wrapper d-flex align-items-stretch">
  @include('dashboard.layouts.sidebar')
  <div id="content" class="p-md-3">
    @include('dashboard.layouts.navbar')


    {{-- content --}}
    @if (session('messageSuccess'))
        <div class="alert alert-success">
            {{ session('messageSuccess') }}
        </div>
    @endif
    <a href="/jalur-masuk/create" class="btn btn-primary mb-2"><i class="bi bi-plus-square"></i> Tambah data jalur masuk</a>
    <table class="table table-hover">
        <tr>
            <th>No.</th>
            <th>Nama Jalur</th>
            <th>Biaya</th>
            <th>Jumlah Pendaftar</th>
            <th>Jumlah Maksimal Pendaftar</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
        @foreach ($jalurMasuks as $jalurMasuk)
            <tr>
                <td>{{ $loop->iteration }}.</td>
                <td>{{ $jalurMasuk->nama }}</td>
                <td>{{ $jalurMasuk->biaya }}</td>
                <td>{{ $jalurMasuk->jumlah_pendaftar }}</td>
                <td>{{ $jalurMasuk->jumlah_maks_pendaftar }}</td>
                <td>{{ $jalurMasuk->status }}</td>
                <td>
                    <a class="btn btn-sm btn-warning m-1" title="lihat" href="{{ route('jalur-masuk.show',$jalurMasuk->id) }}" style="display: inline-block;"><i class="bi bi-eye"></i></a>
                    <a class="btn btn-sm btn-warning m-1" title="edit" href="/jalur-masuk/{{ $jalurMasuk->id }}/edit" style="display: inline-block;"><i class="bi bi-pencil"></i></a>
                    <form action="{{ route('jalur-masuk.destroy', $jalurMasuk->id) }}" method="POST" style="display: inline-block;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger m-1" onclick="return confirm('Apakah anda yakin ingin menghapus?')"><i class="bi bi-trash"></i></button>
                    </form>                      
                </td>                
            </tr>
        @endforeach
    </table>
    <div class="d-flex justify-content-end">
        {{ $jalurMasuks->links() }}
    </div>
    {{-- end content --}}

    </div>
</div>

@endsection