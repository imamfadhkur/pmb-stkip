@extends('layouts.main')
@section('container')

<div class="wrapper d-flex align-items-stretch">
    @include('dashboard.layouts.sidebar')
    <div id="content" class="p-md-3">
        @include('dashboard.layouts.navbar')

        {{-- content --}}
        <div class="container-fluid">
            <div class="card my-4">
                @include('components.error_success')
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h5>List Tagihan</h5>
                    <button class="btn btn-light" data-bs-toggle="modal" data-bs-target="#addTagihanModal">
                        <i class="fas fa-plus"></i> Tambah Tagihan
                    </button>
                </div>

                <div class="card-body" style="max-height: 600px; overflow-y: auto; max-width: 100%; margin: auto;">
                    <div class="row my-1">
                        {{-- <div class="col-8">
                            <form action="{{ route('xx-tagihan.search') }}" method="GET" class="d-flex">
                                <input type="text" name="search" id="search" class="form-control me-2" placeholder="Cari tagihan..." value="{{ request('search') }}">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-search"></i>
                                </button>
                            </form>
                        </div> --}}
                        <div class="col text-end">
                            <a href="{{ route('xx-tagihan.export') }}" class="btn btn-success">
                                <i class="fas fa-file-export"></i> Export Data
                            </a>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead class="table-dark">
                                <tr>
                                    <th>#</th>
                                    <th>Jenis Tagihan</th>
                                    <th>Nomor Invoice</th>
                                    <th>Tanggal Tagihan</th>
                                    <th>Tanggal Jatuh Tempo</th>
                                    <th>Nama</th>
                                    <th>Email</th>
                                    <th>Nominal Tagihan</th>
                                    <th>Status</th>
                                    <th>Keterangan</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="tagihanTableBody">
                                @if ($tagihans && isset($tagihans['data']) && is_array($tagihans['data']) && count($tagihans['data']) > 0)
                                    @foreach ($tagihans['data'] as $tagihan)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $tagihan['jenis_tagihan'] }}</td>
                                            <td>{{ $tagihan['nomor_invoice'] }}</td>
                                            <td>{{ $tagihan['tanggal_tagihan'] }}</td>
                                            <td>{{ $tagihan['tanggal_jatuh_tempo'] }}</td>
                                            <td>{{ $tagihan['nama'] }}</td>
                                            <td>{{ $tagihan['email'] }}</td>
                                            <td>{{ 'Rp. ' . number_format($tagihan['nominal_tagihan'], 0, ',', '.') }}</td>
                                            <td>
                                                @if ($tagihan['status'] === 'SUKSES')
                                                    <span class="badge bg-success">SUKSES</span>
                                                @elseif ($tagihan['status'] === 'PENDING')
                                                    <span class="badge bg-warning text-dark">PENDING</span>
                                                @else
                                                    <span class="badge bg-danger">GAGAL</span>
                                                @endif
                                            </td>
                                            <td>{{ $tagihan['keterangan'] }}</td>
                                            <td>
                                                <a href="{{ route('tagihan.show', $tagihan['id']) }}" class="btn btn-sm btn-info mb-1">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <button class="btn btn-sm btn-warning mb-1" data-bs-toggle="modal" data-bs-target="#editTagihanModal{{ $tagihan['id'] }}">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                <form action="{{ route('tagihan.destroy', $tagihan['id']) }}" method="POST" style="display:inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger mb-1" onclick="return confirm('Are you sure?')">
                                                        <i class="fas fa-trash-alt"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>

                                        <!-- Edit Tagihan Modal -->
                                        <div class="modal fade" id="editTagihanModal{{ $tagihan['id'] }}" aria-labelledby="editTagihanModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="editTagihanModalLabel">Edit Tagihan</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form action="{{ route('tagihan.update', $tagihan['id']) }}" method="POST">
                                                            @csrf
                                                            @method('PATCH')
                                                            <div class="mb-3">
                                                                <label for="jenis_tagihan" class="form-label">Jenis Tagihan</label>
                                                                <input type="text" class="form-control" id="jenis_tagihan" name="jenis_tagihan" value="{{ $tagihan['jenis_tagihan'] }}" disabled>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="nomor_invoice" class="form-label">Nomor Invoice</label>
                                                                <input type="text" class="form-control" id="nomor_invoice" name="nomor_invoice" value="{{ $tagihan['nomor_invoice'] }}" disabled>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="nomor_virtual_account" class="form-label">Nomor Virtual Account</label>
                                                                <input type="text" class="form-control" id="nomor_virtual_account" name="nomor_virtual_account" value="{{ $tagihan['nomor_virtual_account'] }}" disabled>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="tanggal_tagihan" class="form-label">Tanggal Tagihan</label>
                                                                <input type="date" class="form-control" id="tanggal_tagihan" name="tanggal_tagihan" value="{{ $tagihan['tanggal_tagihan'] }}" disabled>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="tanggal_jatuh_tempo" class="form-label">Tanggal Jatuh Tempo</label>
                                                                <input type="date" class="form-control" id="tanggal_jatuh_tempo" name="tanggal_jatuh_tempo" value="{{ $tagihan['tanggal_jatuh_tempo'] }}" required>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="user" class="form-label">Nama</label>
                                                                <select class="form-select" id="user" name="user" required>
                                                                    <option value="" disabled selected>Nama - email</option>
                                                                    @foreach ($registers as $register)
                                                                        <option value="{{ $register->id }}" {{ $tagihan['email'] == $register->email ? 'selected' : '' }}>
                                                                            {{ $register->nama }} - {{ $register->email }}
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="nominal_tagihan" class="form-label">Nominal Tagihan</label>
                                                                <input type="number" class="form-control" id="nominal_tagihan" name="nominal_tagihan" value="{{ $tagihan['nominal_tagihan'] }}" disabled>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="nomor_jurnal_pembukuan" class="form-label">Nomor Jurnal Pembukuan</label>
                                                                <input type="text" class="form-control" id="nomor_jurnal_pembukuan" name="nomor_jurnal_pembukuan" value="{{ $tagihan['nomor_jurnal_pembukuan'] }}" disabled>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="channel_pembayaran" class="form-label">Channel Pembayaran</label>
                                                                <input type="text" class="form-control" id="channel_pembayaran" name="channel_pembayaran" value="{{ $tagihan['channel_pembayaran'] }}" disabled>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="tanggal_terbayar" class="form-label">Tanggal Terbayar</label>
                                                                <input type="datetime-local" class="form-control" id="tanggal_terbayar" name="tanggal_terbayar" value="{{ $tagihan['tanggal_terbayar'] }}" disabled>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="status" class="form-label">Status</label>
                                                                <select class="form-select" id="status" name="status" disabled>
                                                                    <option value="SUKSES" {{ $tagihan['status'] === 'SUKSES' ? 'selected' : '' }}>SUKSES</option>
                                                                    <option value="PENDING" {{ $tagihan['status'] === 'PENDING' ? 'selected' : '' }}>PENDING</option>
                                                                    <option value="GAGAL" {{ $tagihan['status'] === 'GAGAL' ? 'selected' : '' }}>GAGAL</option>
                                                                </select>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="keterangan" class="form-label">Keterangan</label>
                                                                <textarea class="form-control" id="keterangan" name="keterangan">{{ $tagihan['keterangan'] }}</textarea>
                                                            </div>
                                                            <button type="submit" class="btn btn-primary">
                                                                <i class="bi bi-check-circle"></i> Simpan Perubahan
                                                            </button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @else
                                    <p>Tidak ada data tagihan.</p>
                                @endif
                            </tbody>
                        </table>
                        <div class="card-footer d-flex justify-content-center pagination-container">
                            @if(isset($tagihans['links']) && is_array($tagihans['links']))
                                <nav>
                                    <ul class="pagination">
                                        @foreach($tagihans['links'] as $link)
                                            <li class="page-item {{ $link['active'] ? 'active' : '' }}">
                                                <a class="page-link" href="{{ $link['url'] ? url()->current() . '?' . parse_url($link['url'], PHP_URL_QUERY) : '#' }}">
                                                    {!! $link['label'] !!}
                                                </a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </nav>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Add Tagihan Modal -->
        <div class="modal fade" id="addTagihanModal" tabindex="-1" aria-labelledby="addTagihanModalLabel" aria-hidden="true">
            <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addTagihanModalLabel">Tambah Tagihan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('tagihan.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="jenis_tagihan" class="form-label">Jenis Tagihan</label>
                            <input type="text" class="form-control" id="jenis_tagihan" name="jenis_tagihan" required>
                            <div class="form-text text-danger">Field ini wajib diisi.</div>
                        </div>
                        <div class="mb-3">
                            <label for="user" class="form-label">Nama</label>
                            <select class="form-select" id="user" name="user" required>
                                <option value="" disabled selected>Nama - email</option>
                                @foreach ($registers as $register)
                                    <option value="{{ $register->id }}">{{ $register->nama }} - {{ $register->email }}</option>
                                @endforeach
                            </select>
                            <div class="form-text text-danger">Field ini wajib diisi.</div>
                        </div>
                        <div class="mb-3">
                            <label for="tanggal_tagihan" class="form-label">Tanggal Tagihan</label>
                            <input type="date" class="form-control" id="tanggal_tagihan" name="tanggal_tagihan" value="{{ now()->format('Y-m-d') }}" required>
                            <div class="form-text text-danger">Field ini wajib diisi.</div>
                        </div>
                        <div class="mb-3">
                            <label for="tanggal_jatuh_tempo" class="form-label">Tanggal Jatuh Tempo</label>
                            <input type="date" class="form-control" id="tanggal_jatuh_tempo" name="tanggal_jatuh_tempo" required>
                            <div class="form-text text-danger">Field ini wajib diisi.</div>
                        </div>
                        <div class="mb-3">
                            <label for="nominal" class="form-label">Nominal Tagihan</label>
                            <input type="number" class="form-control" id="nominal" name="nominal" placeholder="Masukkan nominal tagihan" required>
                            <div class="form-text text-danger">Field ini wajib diisi.</div>
                        </div>
                        <div class="mb-3">
                            <label for="status" class="form-label">Status</label>
                            <select class="form-select" id="status" name="status" required>
                                <option value="PENDING">PENDING</option>
                            </select>
                            <div class="form-text text-danger">Field ini wajib diisi.</div>
                        </div>
                        <div class="mb-3">
                            <label for="keterangan" class="form-label">Keterangan</label>
                            <textarea class="form-control" id="keterangan" name="keterangan"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-circle"></i> Simpan
                        </button>
                    </form>
                </div>
            </div>
            </div>
        </div>
        {{-- end content --}}

        </div>
</div>

@endsection