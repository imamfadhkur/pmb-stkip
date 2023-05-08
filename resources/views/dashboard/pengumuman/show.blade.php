@extends('layouts.main')
@section('container')

<div class="wrapper d-flex align-items-stretch">
  @include('dashboard.layouts.sidebar')
  <div id="content" class="p-md-3">
    @include('dashboard.layouts.navbar')


    {{-- content --}}
    <div class="container-fluid">
        <div class="row">
            <div class="col">
                <h3>{{ $informasi->title }}</h3>
                @if ($informasi->image !== null)
                    <img class="img-fluid w-25" src="{{ asset('storage/'.$informasi->image) }}" alt="pengumuman">
                @endif
                <p>{!! $informasi->content !!}</p>
                <br>
                <a href="/admin-pengumuman" class="btn btn-primary">back</a>
                <a href="{{ route('admin-pengumuman.edit', $informasi->slug) }}" class="btn btn-warning ms-2">edit</a>
            </div>
        </div>
    </div>
    {{-- end content --}}

    </div>
</div>

@endsection