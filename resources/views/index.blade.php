@extends('layouts.main')
@section('container')
<!-- Jumbotron -->
<div class="jumbotron my-4">
<div class="container-fluid text-center text-white" style="background-image: url({{ asset('assets/images/stkippgri-bkl-gedung-depan-blackv.jpg') }}); background-size: cover; background-repeat: no-repeat; background-position: center center; height: 100vh; display: flex; justify-content: center; align-items: center;">
    <h1> Penerimaan Mahasiswa Baru <br>STKIP PGRI Bangkalan <br>
        @auth
            <a class="btn btn-primary btn-lg" href="/dashboard" role="button">Dashboard</a>
        @else
            <a class="btn btn-primary btn-lg" href="/jalur-pendaftaran" role="button">Daftar Sekarang</a>
        @endauth
    </h1>
</div>
</div>

@endsection