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
        <a href="{{ url('register/create') }}" class="btn btn-primary mb-2"><i class="bi bi-plus-square"></i> Tambah data pendaftar</a>
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

    @isset($success_data_diterima)
      <div class="alert alert-success">
        {{ $success_data_diterima }}
      </div>
    @endisset
    @error('diterima_di')
      <div class="alert alert-danger mt-2">{{ $message }}</div>
    @enderror
    <table class="table table-hover">
      <tr>
        <th>No.</th>
        <th>Nama</th>
        <th>Jenis Kelamin</th>
        <th>Alamat</th>
        <th>Asal Sekolah</th>
        <th>Jalur Masuk</th>
        <th>Bukti Pembayaran</th>
        <th>Status Pembayaran</th>
        <th>Status Diterima</th>
        <th>Periode Pendaftaran</th>
        <th>Action</th>
      </tr>
      @foreach ($registers as $register)
        <tr>
          <td>{{ $loop->iteration }}.</td>
          <td>@isset($register->nama)
              {{$register->nama}}
          @endisset</td>
          <td>@isset($register->jk)
              {{$register->jk}}
          @endisset</td>
          <td>@isset($register->alamat)
              {{$register->alamat}}
          @endisset</td>
          <td>@isset($register->nama_sekolah)
              {{$register->nama_sekolah}}
          @endisset</td>
          <td>@isset($register->jalurMasuk->nama)
              {{$register->jalurMasuk->nama}}
          @endisset</td>
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
              <p><b class="text-success">{{ $register->status_diterima }}</b> - {{ $register->diterima_di !== null ? $register->diterimadi->nama : '(prodi belum ditentukan)' }}</p>
            @else
              <p class="text-danger"><b>{{ $register->status_diterima }}</b></p>
            @endif
          </td>
          <td>{{ $register->created_at->format('Y') }}</td>
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

            <!-- Button trigger modal -->
            <button type="button" title="Diterima di?" class="btn btn-sm btn-warning m-1" data-bs-toggle="modal" data-bs-target="#createModal{{ $register->id }}">
              <i class="bi bi-check2-square"></i>
            </button>

            <!-- Modal -->
            <div class="modal fade" id="createModal{{ $register->id }}" tabindex="-1" aria-labelledby="createModal{{ $register->id }}Label" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <h1 class="modal-title fs-5" id="createModal{{ $register->id }}Label">Penempatan Prodi</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                <form method="POST" action="/change-status-diterima">
                @csrf
                  <div class="modal-body">
                      <div class="form-group">
                        <input type="hidden" name="regist_id" value="{{ $register->id }}">
                          <label for="diterima_di"><b>{{ $register->nama }} diterima di prodi?</b></label>
                          @if ($register->pilihan1Prodi)
                            <div class="form-check">
                              <input class="form-check-input" type="radio" name="diterima_di" value="{{ $register->pilihan1Prodi->id }}" id="diterima_1{{ $register->id }}" {{ $register->diterima_di === $register->pilihan1Prodi->id ? 'checked' : '' }}>
                              <label class="form-check-label" for="diterima_1{{ $register->id }}">
                                {{ $register->pilihan1Prodi->nama }}
                              </label>
                            </div>
                          @endif
                          @if ($register->pilihan2Prodi)
                            <div class="form-check">
                              <input class="form-check-input" type="radio" name="diterima_di" value="{{ $register->pilihan2Prodi->id }}" id="diterima_2{{ $register->id }}" {{ $register->diterima_di === $register->pilihan2Prodi->id ? 'checked' : '' }}>
                              <label class="form-check-label" for="diterima_2{{ $register->id }}">
                                {{ $register->pilihan2Prodi->nama }}
                              </label>
                            </div>
                          @endif
                          @if ($register->pilihan3Prodi)
                            <div class="form-check">
                              <input class="form-check-input" type="radio" name="diterima_di" value="{{ $register->pilihan3Prodi->id }}" id="diterima_3{{ $register->id }}" {{ $register->diterima_di === $register->pilihan3Prodi->id ? 'checked' : '' }}>
                              <label class="form-check-label" for="diterima_3{{ $register->id }}">
                                {{ $register->pilihan3Prodi->nama }}
                              </label>
                            </div>
                          @endif
                      </div>
                      <!-- ... other input fields ... -->
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button id="createSubmit" type="submit" class="btn btn-primary">Save changes</button>
                  </div>
                </form>
                </div>
              </div>
            </div>

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
  </script>

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