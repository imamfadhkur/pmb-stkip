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
    <a href="/settings/create-data-bank" class="btn btn-primary mb-2"><i class="bi bi-plus-square"></i> Tambah data bank</a>
    <table class="table table-hover">
        <tr>
            <th>No.</th>
            <th>Nama Bank</th>
            <th>Nomor Rekening</th>
            <th>Nama Pemilik</th>
            <th>Action</th>
        </tr>
        @foreach ($banks as $bank)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $bank->nama_bank }}</td>
                <td>{{ $bank->nomor_rekening }}</td>
                <td>{{ $bank->nama_pemilik }}</td>
                <td>
                    <a href="/settings/edit-data-bank/{{ $bank->id }}" class="btn btn-sm btn-warning mb-2"><i class="bi bi-pencil"></i></a>
                    <form class="d-inline" action="/settings/delete-data-bank/{{ $bank->id }}" method="post">
                        @csrf
                        <button type="submit" class="btn btn-sm btn-danger mb-2" onclick="return confirm('yakin ingin dihapus?')"><i class="bi bi-trash"></i></button>
                    </form>
                </td>
            </tr>
        @endforeach
    </table>
    <div class="d-flex justify-content-end">
        {{ $banks->links() }}
    </div>
    {{-- end content --}}

    </div>
</div>

@endsection