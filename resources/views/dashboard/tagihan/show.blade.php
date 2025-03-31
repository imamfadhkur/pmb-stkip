@extends('layouts.main')
@section('container')

<div class="wrapper d-flex align-items-stretch">
    @include('dashboard.layouts.sidebar')
    <div id="content" class="p-md-3">
        @include('dashboard.layouts.navbar')

        {{-- content --}}
        <h1 class="text-center mb-4">Detail Tagihan</h1>
        @include('components.error_success')
        <div class="row justify-content-center">
            <div class="col-md-8 mb-4">
                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">Tagihan ID: {{ $tagihan['id'] }}</h5>
                    </div>
                    <div class="card-body">
                        <h5 class="card-title mb-4">Mahasiswa: <i class="fa fa-user"></i> {{ $tagihan['nama'] ?? '-' }}</h5>
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <tbody>
                                    <tr>
                                        <th>Nomor Invoice</th>
                                        <td><i class="fa fa-file-invoice"></i></td>
                                        <td>{{ $tagihan['nomor_invoice'] ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Nomor Virtual Account</th>
                                        <td><i class="fa fa-credit-card"></i></td>
                                        <td>{{ $tagihan['nomor_virtual_account'] ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Jenis Tagihan</th>
                                        <td><i class="fa fa-tags"></i></td>
                                        <td>{{ $tagihan['jenis_tagihan'] ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Tanggal Tagihan</th>
                                        <td><i class="fa fa-calendar-alt"></i></td>
                                        <td>{{ $tagihan['tanggal_tagihan'] ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Tanggal Jatuh Tempo</th>
                                        <td><i class="fa fa-hourglass-end"></i></td>
                                        <td>{{ $tagihan['tanggal_jatuh_tempo'] ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Email</th>
                                        <td><i class="fa fa-envelope"></i></td>
                                        <td>{{ $tagihan['email'] ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Nomor Telepon</th>
                                        <td><i class="fa fa-phone"></i></td>
                                        <td>{{ $tagihan['nomor_telepon'] ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Nominal Tagihan</th>
                                        <td><i class="fa fa-money-bill-wave"></i></td>
                                        <td>Rp. {{ $tagihan['nominal_tagihan'] ? number_format($tagihan['nominal_tagihan'], 0, ',', '.') : '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Nominal Terbayar</th>
                                        <td><i class="fa fa-money-bill-wave"></i></td>
                                        <td>Rp. {{ $tagihan['nominal_terbayar'] ? number_format($tagihan['nominal_terbayar'], 0, ',', '.') : '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Nomor Jurnal Pembukuan</th>
                                        <td><i class="fa fa-book"></i></td>
                                        <td>{{ $tagihan['nomor_jurnal_pembukuan'] ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Channel Pembayaran</th>
                                        <td><i class="fa fa-university"></i></td>
                                        <td>{{ $tagihan['channel_pembayaran'] ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Tanggal Terbayar</th>
                                        <td><i class="fa fa-calendar-check"></i></td>
                                        <td>{{ $tagihan['tanggal_terbayar'] ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Status</th>
                                        <td></td>
                                        <td>
                                            <span class="badge {{ $tagihan['status'] === 'SUKSES' ? 'bg-success' : ($tagihan['status'] === 'PENDING' ? 'bg-warning text-dark' : 'bg-danger') }}">
                                                {{ $tagihan['status'] ?? '-' }}
                                            </span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Keterangan</th>
                                        <td><i class="fa fa-info-circle"></i></td>
                                        <td>{{ $tagihan['keterangan'] ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Pembuat Tagihan</th>
                                        <td><i class="fa fa-user-tie"></i></td>
                                        <td>{{ $tagihan['penagih'] ?? '-' }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="text-end mt-4">
                            <a href="javascript:history.back()" class="btn btn-primary">
                                <i class="fa fa-arrow-left"></i> Kembali
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- end content --}}

        </div>
</div>

@endsection