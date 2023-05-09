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
    <a href="/prodi/create" class="btn btn-primary mb-2"><i class="bi bi-plus-square"></i> Tambah data prodi</a>
    <table class="table table-hover">
        <tr>
            <th>No.</th>
            <th>Nama Prodi</th>
            <th>Action</th>
        </tr>
        @foreach ($prodis as $prodi)
            <tr>
                <td>{{ $loop->iteration }}.</td>
                <td>{{ $prodi->nama }}</td>
                <td>
                    <a class="btn btn-sm btn-warning m-1" title="lihat" href="{{ route('prodi.show',$prodi->id) }}" style="display: inline-block;"><i class="bi bi-eye"></i></a>
                    <a class="btn btn-sm btn-warning m-1" title="edit" href="/prodi/{{ $prodi->id }}/edit" style="display: inline-block;"><i class="bi bi-pencil"></i></a>
                    <form action="{{ route('prodi.destroy', $prodi->id) }}" method="POST" style="display: inline-block;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger m-1" onclick="return confirm('Apakah anda yakin ingin menghapus?')"><i class="bi bi-trash"></i></button>
                    </form>                      
                </td>                
            </tr>
        @endforeach
    </table>
    <div class="d-flex justify-content-end">
        {{ $prodis->links() }}
    </div>
    {{-- end content --}}

    </div>
</div>

@endsection