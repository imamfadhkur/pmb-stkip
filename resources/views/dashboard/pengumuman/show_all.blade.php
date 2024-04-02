@extends('layouts.main')
@section('container')


<center><h3 class="m-3 mt-5">
    Semua Pengumuman
</h3></center>
<div class="container mb-5">
    <div class="row">
        @foreach ($informasis as $informasi)
            <div class="col-sm-4 col-md-4 col-lg-4 col-xl-4">
                <div class="card m-2 p-4">
                    @if ($informasi->image !== null)
                        <img class="img-fluid w-100 h-80" src="{{ asset('storage/'.$informasi->image) }}" class="card-img-top" alt="{{ $informasi->title }}">
                    @else
                        <img class="img-fluid w-100 h-80" src="https://picsum.photos/200/150?grayscale&random&keyword={{ $informasi->title }}" class="card-img-top" alt="{{ $informasi->title }}">
                    @endif
                    <div class="card-body">
                        <h5 class="card-title">{{ $informasi->title }}</h5>
                        <p class="card-text">{!! Str::limit($informasi->content,50) !!}</p>
                        <a href="{{ url('pengumuman/'. $informasi->slug) }}" class="btn btn-primary">Lihat</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    <div class="row">
        <div class="col">
            <div class="d-flex justify-content-end">
                {{ $informasis->links() }}
            </div>
        </div>
    </div>
</div>



@endsection