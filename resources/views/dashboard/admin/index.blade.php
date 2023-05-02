@extends('layouts.main')
@section('container')

<div class="wrapper d-flex align-items-stretch">
  @include('dashboard.layouts.sidebar')
  <div id="content" class="p-md-3">
    @include('dashboard.layouts.navbar')

    @if (session('messageSuccess'))
        <div class="alert alert-success">
            {{ session('messageSuccess') }}
        </div>
    @endif
    
    <div style="display: flex; align-items: center">
      <a style="margin-right: auto; margin-bottom: 0;" href="/register/create" class="btn btn-primary mb-2"><i class="bi bi-plus-square"></i> Tambah data pendaftar</a>
      <form style="margin-left: auto; margin-bottom: 0;" action="register-sort" method="POST" class="m-2">
        @csrf
        <label for="sort">urut berdasarkan: </label>
        <select id="sort" name="sort" class="me-1">
          <option value="nama" selected>Nama</option>
          <option value="nama_sekolah">Asal Sekolah</option>
          <option value="pembayaran">Status Pembayaran</option>
        </select>
        <select name="ascdesc" id="ascdesc">
          <option value="ASC" selected>Naik</option>
          <option value="DESC">Turun</option>
        </select>
        <button type="submit" class="btn btn-sm text-light" style="background-color: #007bff"><i class="bi bi-filter"></i></button>
      </form>
    </div>

    <table class="table table-hover">
      <tr>
        <th>No.</th>
        <th>Nama</th>
        <th>Jenis Kelamin</th>
        <th>Alamat</th>
        <th>Asal Sekolah</th>
        <th>Jalur Masuk</th>
        <th>Biaya Pendaftaran</th>
        <th>Bukti Pembayaran</th>
        <th>Status Pembayaran</th>
        <th>Action</th>
      </tr>
      @foreach ($registers as $register)
        <tr>
          <td>{{ $loop->iteration }}.</td>
          <td>{{ $register->nama }}</td>
          <td>{{ $register->jk }}</td>
          <td>{{ $register->alamat }}</td>
          <td>{{ $register->nama_sekolah }}</td>
          <td>{{ $register->jalurMasuk->nama }}</td>
          <td>{{ number_format($register->jalurMasuk->biaya, 0, ',', '.') }}</td>
          <td>
            @if ($register->bukti_pembayaran)
            <a class="test-popup-link mfp-with-zoom" href="{{ asset('storage/'.$register->bukti_pembayaran) }}">
              <img src="{{ asset('storage/'.$register->bukti_pembayaran) }}" alt="Bukti Pembayaran {{ $register->nama }}" class="rounded w-50" style="max-height: 50px;" data-magnify-src="{{ asset('storage/'.$register->bukti_pembayaran) }}" data-magnify="gallery">
            </a>
                      
            @else
            <p class="text-danger"><b>belum upload</b></p>
            @endif
          </td>
          <td>
            @if ($register->pembayaran === "belum")
                <p class="text-danger"><b>belum</b></p>
            @else
                <p class="text-success"><b>sudah</b></p>
            @endif
          </td>
          <td>
            <form action="/change-status-pembayaran" method="POST" class="d-inline">
              @csrf
              <input type="hidden" name="regist_id" value="{{ $register->id }}">
              <button title="Verifikasi Pembayaran {{ $register->nama }}" type="submit" onclick="return confirm('Apakah {{ $register->nama }} sudah membayar?')" class="btn btn-sm btn-primary m-1">
                <i class="bi bi-cash-coin"></i>
              </button>
            </form>
            <form action="/edit-pendaftaran" method="POST" class="d-inline">
              @csrf
              <input type="hidden" name="regist_id" value="{{ $register->id }}">
              <button title="Edit pendaftar {{ $register->nama }}" type="submit" class="btn btn-sm btn-warning m-1">
                <i class="bi bi-pencil"></i>
              </button>
            </form>
            <form action="/hapus-pendaftaran" method="POST" class="d-inline">
              @csrf
              <input type="hidden" name="regist_id" value="{{ $register->id }}">
              <button title="Hapus pendaftar {{ $register->nama }}" type="submit" class="btn btn-sm btn-danger m-1">
                <i class="bi bi-trash"></i>
              </button>
            </form>
          </td>
        </tr>
      @endforeach
    </table>
    <div class="d-flex justify-content-end">
      {{ $registers->links() }}
    </div>

  </div>
</div>

  <script>
    $(document).ready(function() {
      $('.test-popup-link').magnificPopup({
        type: 'image',
        zoom: {
          enabled: true
        }
      });
    });
  </script>  

@endsection