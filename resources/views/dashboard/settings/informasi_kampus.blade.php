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
    <div class="container">
        <div class="row">
            <div class="col-6">
                <form action="{{ url('settings/update-data-info-kampus') }}" method="POST">
                    @csrf
                    <label class="mt-4" for="name">Nama Kampus:</label>
                    <input type="text" name="name" class="form-control" value="{{ $name }}">
                    <label class="mt-4" for="alamat">Alamat:</label>
                    <input type="text" name="alamat" class="form-control" value="{{ $alamat }}">
                    <label class="mt-4" for="email">Email:</label>
                    <input type="text" name="email" class="form-control" value="{{ $email }}">
                    <label class="mt-4" for="noTelp">Nomor Telepon:</label>
                    <input type="text" name="noTelp" class="form-control" value="{{ $noTelp }}">
                    <button type="submit" class="btn btn-primary mt-3">Simpan</button>
                </form>
            </div>
        </div>
    </div>
    {{-- end content --}}

    </div>
</div>

@endsection