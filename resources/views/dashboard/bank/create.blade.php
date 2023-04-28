@extends('layouts.main')
@section('container')

<div class="wrapper d-flex align-items-stretch">
  @include('dashboard.layouts.sidebar')
  <div id="content" class="p-md-3">
    @include('dashboard.layouts.navbar')


    {{-- content --}}
    <div class="container">
        <div class="row">
            <div class="col-6">
                <form action="/settings/tambah-data-bank" method="POST">
                    @csrf
                    <label class="mt-4" for="nama_bank">Nama Bank:</label>
                    <input type="text" name="nama_bank" class="form-control" required>
                    <label class="mt-4" for="nomor_rekening">Nomor Rekening:</label>
                    <input type="number" name="nomor_rekening" class="form-control" required>
                    <label class="mt-4" for="nama_pemilik">Nama Pemilik:</label>
                    <input type="text" name="nama_pemilik" class="form-control" required>
                    <button type="submit" class="btn btn-primary mt-3">Submit</button>
                </form>
            </div>
        </div>
    </div>
    {{-- end content --}}

    </div>
</div>

@endsection