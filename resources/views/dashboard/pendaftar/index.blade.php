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
      <div style="margin-right: auto; margin-bottom: 0;">
        <a href="/register/create" class="btn btn-primary mb-2"><i class="bi bi-plus-square"></i> Tambah data pendaftar</a>
        <a href="{{ route('export.register') }}" class="btn btn-success mb-2"><i class="bi bi-box-arrow-up-right"></i> Ekspor data</a>
      </div>
      <form style="margin-left: auto; margin-bottom: 0;" action="/register-sort" method="GET" class="m-2">
        <label for="sort">urut berdasarkan: </label>
        <select id="sort" name="sort" class="me-1">
            <option value="nama" {{ request('sort') == 'nama' ? 'selected' : '' }}>Nama</option>
            <option value="nama_sekolah" {{ request('sort') == 'nama_sekolah' ? 'selected' : '' }}>Asal Sekolah</option>
            <option value="pembayaran" {{ request('sort') == 'pembayaran' ? 'selected' : '' }}>Status Pembayaran</option>
        </select>
        <select name="ascdesc" id="ascdesc">
            <option value="ASC" {{ request('ascdesc') == 'ASC' ? 'selected' : '' }}>Naik</option>
            <option value="DESC" {{ request('ascdesc') == 'DESC' ? 'selected' : '' }}>Turun</option>
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
        <th>Status Diterima</th>
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
            @if ($register->status_diterima === "diterima")
              <p class="text-success"><b>{{ $register->status_diterima }}</b></p>
            @else
              <p class="text-danger"><b>{{ $register->status_diterima }}</b></p>
            @endif
          </td>
          <td>
            <a class="btn btn-warning btn-sm m-1" title="lihat" href="{{ route('register.show',$register->email) }}" style="display: inline-block;"><i class="bi bi-eye"></i></a>
            <form action="/change-status-pembayaran" method="POST" class="d-inline">
              @csrf
              <input type="hidden" name="regist_id" value="{{ $register->id }}">
              @if ($register->pembayaran === "belum")
              <button title="Verifikasi Pembayaran {{ $register->nama }}" type="submit" onclick="return confirm('Apakah {{ $register->nama }} sudah membayar?')" class="btn btn-sm btn-primary m-1">
                <i class="bi bi-cash-coin"></i>
              </button>
              @else
              <button disabled title="Verifikasi Pembayaran {{ $register->nama }}" type="submit" onclick="return confirm('Apakah {{ $register->nama }} sudah membayar?')" class="btn btn-sm btn-primary m-1">
                <i class="bi bi-cash-coin"></i>
              </button>
              @endif
            </form>
            <form action="/change-status-diterima" method="POST" class="d-inline">
              @csrf
              <input type="hidden" name="regist_id" value="{{ $register->id }}">
              @if ($register->status_diterima === "diterima")
              <button disabled title="Rubah Status Diterima {{ $register->nama }}" type="submit" onclick="return confirm('Apakah Anda yakin?')" class="btn btn-sm btn-warning m-1">
                <i class="bi bi-check2-square"></i>
              </button>
              @else
              <button title="Rubah Status Diterima {{ $register->nama }}" type="submit" onclick="return confirm('Apakah Anda yakin?')" class="btn btn-sm btn-warning m-1">
                <i class="bi bi-check2-square"></i>
              </button>
              @endif
            </form>
            @can('superadmin')
              <a class="btn btn-warning btn-sm m-1" title="edit" href="{{ route('register.edit',$register->email) }}" style="display: inline-block;"><i class="bi bi-pencil"></i></a>
              <form action="/hapus/{{ $register->id }}" method="POST" class="d-inline">
                @csrf
                @method('DELETE')
                <input type="hidden" name="id" value="{{ $register->id }}">
                <button onclick="return confirm('apakah anda yakin ingin menghapus?')" title="Hapus pendaftar {{ $register->nama }}" type="submit" class="btn btn-sm btn-danger m-1">
                  <i class="bi bi-trash"></i>
                </button>
              </form>
            @endcan
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