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
        @include('components.error_success')
        <a href="{{ url('prodi/create') }}" class="btn btn-primary mb-2"><i class="bi bi-plus-square"></i> Tambah data prodi</a>
        <div class="row">
                @foreach ($prodis as $prodi)
                        <div class="col-md-4 mb-3">
                                <div class="card">
                                        <div class="card-body">
                                                <h5 class="card-title">{{ $prodi->nama }}</h5>
                                                <p class="card-text">Kuota diterima: {{ $prodi->kuota }}</p>
                                                <p class="card-text">Sisa: {{ $prodi->sisa_kuota }}</p>
                                                <a class="btn btn-sm btn-primary m-1" title="lihat" href="{{ route('prodi.show',$prodi->id) }}"><i class="bi bi-eye"></i></a>
                                                <a class="btn btn-sm btn-warning m-1" title="edit" href="{{ url('prodi/'. $prodi->id .'/edit') }}"><i class="bi bi-pencil"></i></a>
                                                <form action="{{ route('prodi.destroy', $prodi->id) }}" method="POST" style="display: inline-block;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-danger m-1" onclick="return confirm('Apakah anda yakin ingin menghapus?')"><i class="bi bi-trash"></i></button>
                                                </form>
                                        </div>
                                </div>
                        </div>
                @endforeach
        </div>
        <div class="d-flex justify-content-end">
                {{ $prodis->links() }}
        </div>
        {{-- end content --}}

    </div>
</div>

@endsection
