@extends('layouts.main')
@section('container')
<!-- Jumbotron -->
<div class="jumbotron my-4">
<div class="container-fluid text-center text-white" style="background-image: url({{ asset('assets/images/stkippgri-bkl-gedung-depan-blackv.jpg') }}); background-size: cover; background-repeat: no-repeat; background-position: center center; height: 100vh; display: flex; justify-content: center; align-items: center;">
    <h1 style="display: flex; flex-direction: column;"> Penerimaan Mahasiswa Baru <br>STKIP PGRI Bangkalan <br>
        <center>
        @auth
            <a class="btn btn-my-primary text-light btn-lg mt-4" href="{{ url('dashboard') }}" role="button" style="display: inline-block; max-width: max-content;">Dashboard</a>
        @else
            <a class="btn btn-my-primary text-light btn-lg mt-4" href="{{ url('jalur-pendaftaran') }}" role="button" style="display: inline-block; max-width: max-content;">Daftar Sekarang</a>
        @endauth
        </center>
    </h1>
</div>
</div>

@endsection