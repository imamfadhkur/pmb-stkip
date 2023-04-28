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
    @if($bank === null)
        <a href="/settings/create-data-bank" class="btn btn-primary mb-2"><i class="bi bi-plus-square"></i> Tambah data bank</a>
    @endif
    <table class="table table-hover">
        <tr>
            <th>Nama Bank</th>
            <th>Nomor Rekening</th>
            <th>Nama Pemilik</th>
        </tr>
        @if($bank !== null)
        <tr>
            <td>{{ $bank->nama_bank }}</td>
            <td>{{ $bank->nomor_rekening }}</td>
            <td>{{ $bank->nama_pemilik }}</td>
        </tr>
        @endif
    </table>
    @if($bank !== null)
        <a href="/settings/edit-data-bank" class="btn btn-warning mb-2"><i class="bi bi-pencil-square"></i> Edit data bank</a>
    @endif
    {{-- end content --}}

    </div>
</div>

@endsection