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
    @if (session('messageFailed'))
        <div class="alert alert-danger">
            {{ session('messageFailed') }}
        </div>
    @endif
    <a href="/admin-pengumuman/create" class="btn btn-primary mb-2"><i class="bi bi-plus-square"></i> Buat pengumuman</a>
    <table class="table table-hover">
        <tr>
            <th>No.</th>
            <th>Judul</th>
            <th>Action</th>
        </tr>
        @foreach ($informasis as $informasi)
            <tr>
                <td>{{ $loop->iteration }}.</td>
                <td>{{ $informasi->title }}</td>
                <td>
                    <a class="btn btn-sm btn-primary m-1" title="lihat data" href="/admin-pengumuman/{{ $informasi->id }}" style="display: inline-block;"><i class="bi bi-eye"></i></a>
                    <a class="btn btn-sm btn-warning m-1" title="edit" href="/admin-pengumuman/{{ $informasi->id }}/edit" style="display: inline-block;"><i class="bi bi-pencil"></i></a>
                    <form action="{{ route('admin-pengumuman.destroy', $informasi->id) }}" method="POST" style="display: inline-block;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger m-1" onclick="return confirm('Apakah anda yakin ingin menghapus?')"><i class="bi bi-trash"></i></button>
                    </form>                      
                </td>                
            </tr>
        @endforeach
    </table>
    <div class="d-flex justify-content-end">
        {{ $informasis->links() }}
    </div>
    {{-- end content --}}

    </div>
</div>

@endsection