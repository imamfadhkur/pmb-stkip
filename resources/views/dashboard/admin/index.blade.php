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
    
    <table class="table table-hover">
      <tr>
        <th>No.</th>
        <th>Nama</th>
        <th>Email</th>
        <th>Alamat</th>
        <th>Asal Sekolah</th>
        <th>Bukti Pembayaran</th>
        <th>Pembayaran Registrasi</th>
        <th>Action</th>
      </tr>
      @foreach ($registers as $register)
        <tr>
          <td>{{ $loop->iteration }}.</td>
          <td>{{ $register->nama }}</td>
          <td>{{ $register->email }}</td>
          <td>{{ $register->alamat }}</td>
          <td>{{ $register->nama_sekolah }}</td>
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
            <form action="/change-status-pembayaran" method="POST">
              @csrf
              <input type="hidden" name="regist_id" value="{{ $register->id }}">
              <button title="Verifikasi Pembayaran {{ $register->nama }}" type="submit" onclick="return confirm('Apakah {{ $register->nama }} sudah membayar?')" class="btn btn-primary">
                <i class="bi bi-cash-coin"></i>
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