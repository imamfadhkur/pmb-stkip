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
                <h3>Buat Pengumuman</h3>
                <form action="/admin-pengumuman" method="POST" enctype="multipart/form-data">
                    @csrf
                    <label class="mt-4" for="title">Judul:</label>
                    <input type="text" name="title" id="title" class="form-control" required>
                    <label class="mt-4" for="image">Gambar:</label>
                    <input type="file" name="image" id="image" class="form-control">
                    <label class="mt-4" for="content">Isi Pengumumam:</label>
                    <textarea name="content" id="editor1" required></textarea>
                    <input type="hidden" name="jenis" value="daftar-ulang">
                    <button type="submit" class="btn btn-primary mt-3">Submit</button>
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