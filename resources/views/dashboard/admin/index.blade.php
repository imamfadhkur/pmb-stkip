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
          <td>{*img}</td>
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

@endsection