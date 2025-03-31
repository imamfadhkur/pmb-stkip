@extends('layouts.main')
@section('container')

<div class="container my-5">
    <div class="row">
        <div class="col text-center">
            <h3>Detail Pembayaran</h3>
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-md-6">
            @if($error_custom)
                <div class="alert alert-danger">
                    {{ $error_custom }}
                </div>
            @elseif($tagihan)
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-primary text-white text-center">
                        <h5 class="mb-0">Tagihan Pendaftaran</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <strong>Nama:</strong>
                            <p class="mb-0">{{ $tagihan['nama'] }}</p>
                        </div>
                        <div class="mb-3">
                            <strong>Nomor Bayar:</strong>
                            <p class="mb-0">{{ explode('/', $tagihan['nomor_invoice'])[1] }}</p>
                        </div>
                        <div class="mb-3">
                            <strong>Tanggal Tagihan:</strong>
                            <p class="mb-0">{{ $tagihan['tanggal_tagihan'] }}</p>
                        </div>
                        <div class="mb-3">
                            <strong>Nominal:</strong>
                            <p class="mb-0">Rp{{ number_format($tagihan['nominal_tagihan'], 0, ',', '.') }}</p>
                        </div>
                        <div class="mb-3">
                            <strong>Keterangan:</strong>
                            <p class="mb-0">{{ $tagihan['keterangan'] }}</p>
                        </div>
                        <div class="mb-3">
                            <strong class="text-danger">*Harap simpan informasi ini untuk pembayaran nanti.</strong>
                        </div>
                        <div class="text-center mb-3">
                            <button class="btn btn-success" onclick="window.print()">Print</button>
                        </div>
                    </div>
                    <div class="card-footer text-center bg-light">
                        <center><h5>Tata Cara Pembayaran</h5></center>
                        <img src="{{ asset('assets/images/cara-pembayaran-bank.jpg') }}" alt="" style="max-width: 90%; height: auto;">
                    </div>
                </div>
            @else
                <div class="alert alert-warning">
                    Tidak ada data tagihan yang tersedia.
                </div>
            @endif
        </div>
    </div>
</div>

@endsection
