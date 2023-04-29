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
    @if (session('messageError'))
        <div class="alert alert-danger">
            {{ session('messageError') }}
        </div>
    @endif
    <a href="/settings/create_sosmed" class="btn btn-primary mb-2"><i class="bi bi-plus-square"></i> Tambah sosmed</a>
    <table class="table table-hover">
        <tr>
            <th></th>
            <th>Platform</th>
            <th>Link</th>
            <th>Icon</th>
            <th>Action</th>
        </tr>
        @foreach ($sosmeds as $sosmed)
            <tr>
                <td>{{ $loop->iteration }}.</td>
                <td>{{ $sosmed->nama_platform }}</td>
                <td><a href="{{ $sosmed->link }}" class="text-decoration-none" target="_blank">{{ $sosmed->link }}</a></td>
                <td>{!! $sosmed->icon !!}</td>
                <td style="display: flex; gap: 10px;">
                    <form action="/settings/edit-sosmed" method="POST"> @csrf <input type="hidden" value="{{ $sosmed->id }}" name="id"><button type="submit" title="edit {{ $sosmed->nama_platform }}" class="btn btn-sm btn-warning"><i class="bi bi-pencil"></i></button></form>
                    <form action="/settings/delete-sosmed" method="POST"> @csrf <input type="hidden" value="{{ $sosmed->id }}" name="id"><button type="submit" title="hapus {{ $sosmed->nama_platform }}" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus?')"><i class="bi bi-trash"></i></button></form>
                </td>                
            </tr>
        @endforeach
    </table>
    {{-- end content --}}

    </div>
</div>

@endsection