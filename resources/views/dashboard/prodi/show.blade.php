@extends('layouts.main')
@section('container')

<div class="wrapper d-flex align-items-stretch">
  @include('dashboard.layouts.sidebar')
  <div id="content" class="p-md-3">
    @include('dashboard.layouts.navbar')
    
{{-- content --}}
<h3>{{ $prodi->nama }}</h3>
{{-- end content --}}
<p class="mb-3">{!! $prodi->deskripsi !!}</p>
<a href="/prodi" class="btn btn-primary">back</a>
<a href="{{ route('prodi.edit', $prodi->id) }}" class="btn btn-warning ms-2">edit</a>
    </div>
</div>

@endsection