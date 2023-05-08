@extends('layouts.main')
@section('container')

    {{-- content --}}
    <div class="container">
        <div class="row m-4">
            <div class="col-10 mt-4">
                <h3>{{ $informasi->title }}</h3>
                @if ($informasi->image !== null)
                    <img class="img-fluid w-70" src="{{ asset('storage/'.$informasi->image) }}" alt="pengumuman">
                @endif
                <p>{!! $informasi->content !!}</p>
                <br>
                <a href="/pengumuman/index" class="btn btn-primary">kembali</a>
            </div>
        </div>
    </div>
    {{-- end content --}}


@endsection