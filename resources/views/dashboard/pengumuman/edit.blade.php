@extends('layouts.main')
@section('container')

<div class="wrapper d-flex align-items-stretch">
  @include('dashboard.layouts.sidebar')
  <div id="content" class="p-md-3">
    @include('dashboard.layouts.navbar')


    {{-- content --}}
    <div class="container">
        <div class="row">
            <div class="col-10">
                @if (session('messageFailed'))
                    <div class="alert alert-danger">
                        {{ session('messageFailed') }}
                    </div>
                @endif
                <form action="{{ route('admin-pengumuman.update', $informasi->slug) }}" method="POST" enctype="multipart/form-data">
                    @method('PUT')
                    @csrf
                    <div class="form-group">
                        <label for="title">Judul:</label>
                        <input type="text" name="title" id="title" class="form-control{{ $errors->has('title') ? ' is-invalid' : '' }}" value="{{ old('title', $informasi->title) }}">
                        @if ($errors->has('title'))
                            <div class="invalid-feedback">
                                {{ $errors->first('title') }}
                            </div>
                        @endif
                    </div>
                    <div class="form-group">
                        <label class="mt-4" for="image">Gambar:</label>
                        @if($informasi->image)
                            <img class="m-2" src="{{ asset('storage/'.$informasi->image) }}" alt="pengumuman" style="max-width: 100px;">
                        @endif
                        <input type="file" name="image" id="image" class="form-control{{ $errors->has('image') ? ' is-invalid' : '' }}">
                        @if ($errors->has('image'))
                            <div class="invalid-feedback">
                                {{ $errors->first('image') }}
                            </div>
                        @endif
                    </div>
                    <div class="form-group">
                        <label class="mt-4" for="content">Isi Pengumumam:</label>
                        <textarea class="{{ $errors->has('content') ? ' is-invalid' : '' }}" name="content" id="editor1" required>{{ old('content', $informasi->content) }}</textarea>
                        @if ($errors->has('content'))
                            <div class="invalid-feedback">
                                {{ $errors->first('content') }}
                            </div>
                        @endif
                    </div>
                    <a href="/admin-pengumuman" class="btn btn-danger">cancel</a>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
    </div>
    {{-- end content --}}

    </div>
</div>

<script>
    CKEDITOR.replace( 'editor1' );
</script>

@endsection