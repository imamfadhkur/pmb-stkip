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
    @include('components.error_success')

    <div class="row">
      
      <div class="col">
        <a href="{{ url('register/create') }}" class="btn btn-sm btn-primary mb-2"><i class="bi bi-plus-square"></i> Tambah data</a>
        
        <a href="{{ route('export.register') }}" class="btn btn-sm btn-success mb-2"><i class="bi bi-box-arrow-up-right"></i> Ekspor data</a>
      </div>

      <div class="col text-center">
        <button type="button" class="btn btn-sm btn-info mb-2" data-bs-toggle="modal" data-bs-target="#generateDataModal">
          <i class="bi bi-gear"></i>
        </button>
        <button type="button" class="btn btn-sm btn-danger mb-2" data-bs-toggle="modal" data-bs-target="#deleteAllDataModal">
          <i class="bi bi-trash"></i>
        </button>

        <!-- Generate Data Modal -->
        <div class="modal fade" id="generateDataModal" tabindex="-1" aria-labelledby="generateDataModalLabel" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="generateDataModalLabel">Generate Data Siakad</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                <p>Tindakan ini akan membuat akun mahasiswa baru di siakad, ketik "lanjutkan" apabila anda yakin?</p>
                <input type="text" id="confirmLanjutkan" class="form-control" placeholder="Ketik 'lanjutkan'" autocomplete="off">
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" id="nextButton" class="btn btn-primary" disabled>Next</button>
              </div>
            </div>
          </div>
        </div>

        <!-- Finalisasi Data Modal -->
        <div class="modal fade" id="finalizeDataModal" tabindex="-1" aria-labelledby="finalizeDataModalLabel" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="finalizeDataModalLabel">Finalisasi Data Siakad</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                <p>Data camaba sebanyak {{ $registers->total() }} apakah sudah melakukan seluruh proses registrasi dan tes? <br> <b>Mohon hapus data camaba yang gagal test atau tidak registrasi ulang,</b> pastikan bahwa disini merupakan data final. <br><br> Apabila data sudah siap maka ketik "saya yakin" untuk finalisasi data ke siakad.</p>
                <input type="text" id="confirmSayaYakin" class="form-control" placeholder="Ketik 'saya yakin'" autocomplete="off">
              </div>
              <div class="modal-footer">
                <a href="{{ url('register') }}" id="clearDataButton" class="btn btn-secondary">Bersihkan Data</a>
                <button type="button" id="finalizeButton" class="btn btn-primary" disabled onclick="this.disabled=true; this.innerHTML='Mengirim...'; document.getElementById('clearDataButton').disabled=true;">Saya Yakin</button>
              </div>
            </div>
          </div>
        </div>

        <script>
          document.getElementById('confirmLanjutkan').addEventListener('input', function() {
            document.getElementById('nextButton').disabled = this.value !== 'lanjutkan';
          });

          document.getElementById('nextButton').addEventListener('click', function() {
            $('#generateDataModal').modal('hide');
            $('#finalizeDataModal').modal('show');
          });

          document.getElementById('confirmSayaYakin').addEventListener('input', function() {
            document.getElementById('finalizeButton').disabled = this.value !== 'saya yakin';
          });

          document.getElementById('finalizeButton').addEventListener('click', function() {
            window.location.href = "{{ url('api/insert-mahasiswa') }}";
          });
        </script>

        <!-- Delete All Data Modal -->
        <div class="modal fade" id="deleteAllDataModal" tabindex="-1" aria-labelledby="deleteAllDataModalLabel" aria-hidden="true">
          <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="deleteAllDataModalLabel">Hapus Semua Data</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
            <p>Tindakan ini akan menghapus semua data pendaftar, ketik "hapus semua pendaftar" apabila anda yakin?</p>
            <input type="text" id="confirmHapusSemua" class="form-control" placeholder="Ketik 'hapus semua pendaftar'" autocomplete="off">
            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
            {{-- <button type="button" id="deleteAllButton" class="btn btn-danger" disabled>Hapus Semua</button> --}}
            <form id="deleteAllForm" action="{{ url('delete-all-register') }}" method="POST" class="d-inline">
              @csrf
              @method('DELETE')
              <button type="submit" id="deleteAllButton" class="btn btn-danger" disabled>Hapus Semua</button>
            </form>
            </div>
          </div>
          </div>
        </div>

        <script>
          document.getElementById('confirmLanjutkan').addEventListener('input', function() {
          document.getElementById('nextButton').disabled = this.value !== 'lanjutkan';
          });

          document.getElementById('nextButton').addEventListener('click', function() {
          $('#generateDataModal').modal('hide');
          $('#finalizeDataModal').modal('show');
          });

          document.getElementById('confirmSayaYakin').addEventListener('input', function() {
          document.getElementById('finalizeButton').disabled = this.value !== 'saya yakin';
          });

          document.getElementById('finalizeButton').addEventListener('click', function() {
          window.location.href = "{{ url('api/insert-mahasiswa') }}";
          });

          document.getElementById('confirmHapusSemua').addEventListener('input', function() {
          document.getElementById('deleteAllButton').disabled = this.value !== 'hapus semua pendaftar';
          });
        </script>
      </div>
      
      <div class="col">
        {{-- <form action="{{ url('register-sort') }}" method="GET" class="m-2">
          @csrf
          <label for="sort">urut berdasarkan: </label>
          <select id="sort" name="sort" class="me-1">
            <option value="created_at" {{ request('sort') == 'created_at' ? 'selected' : '' }}>Tanggal pendaftaran</option>
              <option value="nama" {{ request('sort') == 'nama' ? 'selected' : '' }}>Nama</option>
              <option value="nama_sekolah" {{ request('sort') == 'nama_sekolah' ? 'selected' : '' }}>Asal Sekolah</option>
              <option value="pembayaran" {{ request('sort') == 'pembayaran' ? 'selected' : '' }}>Status Pembayaran</option>
          </select>
          <select name="ascdesc" id="ascdesc">
              <option value="ASC" {{ request('ascdesc') == 'ASC' ? 'selected' : '' }}>Naik</option>
              <option value="DESC" {{ request('ascdesc') == 'DESC' ? 'selected' : '' }}>Turun</option>
          </select>
          <button type="submit" class="btn btn-sm text-light" style="background-color: #007bff"><i class="bi bi-filter"></i></button>
        </form> --}}
      
        <form id="search-form" action="{{ url('register') }}" method="GET" class="d-flex mb-1">
            <div class="input-group">
              <input type="text" id="search" name="search" class="form-control btn-sm" value="{{ request('search') }}" placeholder="Cari data...">
              <button type="button" class="btn btn-primary btn-sm" disabled>Cari</button>
            </div>
        </form>           
      </div>

    </div>
{{--     
    <div style="display: flex; align-items: center">
      
      <div style="margin-right: auto; margin-bottom: 0;">
      </div>
      
      <div style="margin-left: auto; margin-bottom: 0;">
      </div>

    </div> --}}

    @isset($success_data_diterima)
      <div class="alert alert-success">
        {{ $success_data_diterima }}
      </div>
    @endisset

    @error('diterima_di')
      <div class="alert alert-danger mt-2">{{ $message }}</div>
    @enderror
    
    @if ($registers->isEmpty())
        <p class="text-center text-muted">Tidak ada data yang ditemukan.</p>
    @else

      <div id="register-table-body">

        <table class="table table-hover">
          <thead>
          <tr>
            <th>No.</th>
            <th>Nama</th>
            <th>Alamat</th>
            <th>Asal Sekolah</th>
            <th>Jalur Masuk</th>
            <th>Bukti Pembayaran</th>
            <th>Status Pembayaran</th>
            <th>Status Diterima</th>
            <th>Action</th>
          </tr>
          </thead>
          
          <tbody>
          
            @foreach ($registers as $register)
              <tr>
                <td>{{ $registers->firstItem() + $loop->index }}.</td>
                <td>@isset($register->nama)
                    {{$register->nama}} ({{ $register->jk }})
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
                      <p class="text-danger"><b>belum terverifikasi</b></p>
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
                <td>
                  <a class="btn btn-warning btn-sm m-1" title="lihat" href="{{ route('register.show',$register->email) }}" style="display: inline-block;"><i class="bi bi-eye"></i></a>
                  <form action="{{ url('change-status-pembayaran') }}" method="POST" class="d-inline">
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
                      <form method="POST" action="{{ url('change-status-diterima') }}">
                      @csrf
                        <div class="modal-body">
                            <div class="form-group">
                              <input type="hidden" name="regist_id" value="{{ $register->id }}">
                                  <label for="diterima_di"><b>{{ $register->nama }} diterima di prodi?</b></label>
                                  @if ($register->pilihan1Prodi)
                                  <div class="form-check">
                                    <input class="form-check-input" type="radio" name="diterima_di" value="{{ $register->pilihan1Prodi->id }}" id="diterima_1{{ $register->id }}" {{ $register->diterima_di === $register->pilihan1Prodi->id ? 'checked' : '' }} onclick="updateProdiName('{{ $register->pilihan1Prodi->nama }}', {{ $register->id }})">
                                    <label class="form-check-label" for="diterima_1{{ $register->id }}">
                                    {{ $register->pilihan1Prodi->nama }}
                                    </label>
                                  </div>
                                  @endif
                                  @if ($register->pilihan2Prodi)
                                  <div class="form-check">
                                    <input class="form-check-input" type="radio" name="diterima_di" value="{{ $register->pilihan2Prodi->id }}" id="diterima_2{{ $register->id }}" {{ $register->diterima_di === $register->pilihan2Prodi->id ? 'checked' : '' }} onclick="updateProdiName('{{ $register->pilihan2Prodi->nama }}', {{ $register->id }})">
                                    <label class="form-check-label" for="diterima_2{{ $register->id }}">
                                    {{ $register->pilihan2Prodi->nama }}
                                    </label>
                                  </div>
                                  @endif
                                  @if ($register->pilihan3Prodi)
                                  <div class="form-check">
                                    <input class="form-check-input" type="radio" name="diterima_di" value="{{ $register->pilihan3Prodi->id }}" id="diterima_3{{ $register->id }}" {{ $register->diterima_di === $register->pilihan3Prodi->id ? 'checked' : '' }} onclick="updateProdiName('{{ $register->pilihan3Prodi->nama }}', {{ $register->id }})">
                                    <label class="form-check-label" for="diterima_3{{ $register->id }}">
                                    {{ $register->pilihan3Prodi->nama }}
                                    </label>
                                  </div>
                                  @endif
                                  <input type="hidden" name="prodi_name" id="prodi_name{{ $register->id }}" value="" placeholder="nama_prodi">
                                  <script>
                                  function updateProdiName(prodiName, registerId) {
                                    document.getElementById('prodi_name' + registerId).value = prodiName;
                                  }
                                  </script>
                            </div>
                            <!-- ... other input fields ... -->
                            <input type="hidden" name="name" placeholder="name" value="{{ $register->nama }}">
                            <input type="hidden" name="role" placeholder="role" value="mahasiswa">
                            <input type="hidden" name="jenis_kelamin" placeholder="jenis_kelamin" value="{{ $register->jk }}">
                            <input type="hidden" name="tempat_lahir" placeholder="tempat_lahir" value="{{ $register->tempat_lahir }}">
                            <input type="hidden" name="tanggal_lahir" placeholder="tanggal_lahir" value="{{ $register->tanggal_lahir }}">
                            <input type="hidden" name="alamat" placeholder="alamat" value="{{ $register->alamat }}">
                            <input type="hidden" name="kewarganegaraan" placeholder="kewarganegaraan" value="{{ $register->kewarganegaraan }}">
                            <input type="hidden" name="nik" placeholder="nik" value="{{ $register->identitas_kewarganegaraan }}">
                            <input type="hidden" name="nisn" placeholder="nisn" value="{{ $register->nisn }}">
                            <input type="hidden" name="nama_ibu" placeholder="nama_ibu" value="{{ $register->nama_ibu }}">
                            <input type="hidden" name="tanggal_daftar" placeholder="tanggal_daftar" id="" value="{{ $register->created_at }}">
                            <input type="hidden" name="nama_jalur_masuk" placeholder="nama_jalur_masuk" id="" value="{{ $register->jalurMasuk->nama }}">
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
                    <form action="{{ url('hapus/'. $register->id) }}" method="POST" class="d-inline">
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
            
          </tbody>
          
        </table>
      
        <div class="card-footer d-flex justify-content-center">
            {{ $registers->links('pagination::bootstrap-5') }}
        </div>

      </div>

    @endif

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

<script>
  $(document).ready(function() {
      $('#search').on('keyup', function() {
          var search = $(this).val();
  
          $.ajax({
              url: "{{ url('register-search') }}",
              type: "GET",
              data: { search: search },
              success: function(response) {
                  $('#register-table-body').html(response);
              }
          });
      });
  });
  </script>
  

@endsection