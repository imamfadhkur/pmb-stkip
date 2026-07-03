@extends('layouts.main')

@section('custom_css')
<style>
    .invoice-card {
        border-top: 5px solid #0d6efd;
        border-radius: 10px;
    }
    .bg-soft-primary {
        background-color: rgba(13, 110, 253, 0.1);
        color: #0d6efd;
    }
    .dashed-line {
        border-top: 2px dashed #e9ecef;
        margin: 20px 0;
    }
    .va-box {
        background: #f8f9fa;
        border: 2px dashed #dee2e6;
        border-radius: 8px;
        padding: 15px;
    }
    @media print {
        .no-print { display: none !important; }
        .invoice-card { box-shadow: none !important; border: 1px solid #ddd !important; }
    }
</style>
@endsection

@section('container')
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            
            {{-- Notifikasi Sukses --}}
            <div class="alert alert-success text-center mb-4 shadow-sm border-0">
                <i class="bi bi-check-circle-fill fs-4 d-block mb-2"></i>
                <h4 class="alert-heading fw-bold">Pendaftaran Berhasil!</h4>
                <p class="mb-0">Data Anda telah kami terima. Silakan selesaikan pembayaran.</p>
            </div>

            @if($error_custom)
                <div class="alert alert-danger shadow-sm">{{ $error_custom }}</div>
            @elseif($tagihan)
            
            {{-- KARTU TAGIHAN --}}
            <div class="card shadow-lg border-0 invoice-card mb-4">
                <div class="card-body p-4 p-lg-5">
                    
                    {{-- Header Invoice --}}
                    <div class="text-center mb-4">
                        <h5 class="text-muted text-uppercase small ls-1">Total Tagihan</h5>
                        <h1 class="fw-bold text-primary display-4">
                            Rp {{ number_format($tagihan['nominal_tagihan'], 0, ',', '.') }}
                        </h1>
                        <span class="badge bg-warning text-dark px-3 py-2 rounded-pill mt-2">
                            Menunggu Pembayaran
                        </span>
                    </div>

                    <div class="dashed-line"></div>

                    {{-- Detail Pembayaran --}}
                    <div class="row mb-3">
                        <div class="col-6 text-muted">Batas Pembayaran</div>
                        <div class="col-6 text-end fw-bold text-danger">
                            {{ \Carbon\Carbon::parse($tagihan['tanggal_jatuh_tempo'])->format('d F Y') }}
                        </div>
                    </div>
                    
                    <div class="row mb-4">
                        <div class="col-6 text-muted">ID Pendaftar</div>
                        <div class="col-6 text-end fw-bold">{{ $tagihan['nama'] }}</div>
                    </div>

                    {{-- Virtual Account Box --}}
                    <div class="va-box text-center mb-4">
                        <p class="mb-2 text-muted small">Nomor Virtual Account (VA)</p>
                        @php
                            // Mengambil logika dari file lama: memisahkan nomor invoice untuk dapat VA
                            $va_number = isset($tagihan['nomor_invoice']) ? explode('/', $tagihan['nomor_invoice'])[1] : '-';
                            // Jika format lama menggunakan prefix 5047, kita tambahkan (sesuai file lama)
                            $full_va = '5047' . $va_number; 
                        @endphp
                        
                        <h3 class="fw-bold letter-spacing-2 mb-3" id="vaNumber">{{ $full_va }}</h3>
                        
                        <button class="btn btn-sm btn-outline-primary rounded-pill px-4" onclick="copyToClipboard('{{ $full_va }}')">
                            <i class="bi bi-clipboard me-1"></i> Salin Nomor VA
                        </button>
                    </div>

                    {{-- Accordion Cara Bayar --}}
                    <div class="accordion accordion-flush border rounded" id="accordionPayment">
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed fw-bold" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne">
                                    <i class="bi bi-info-circle me-2 text-primary"></i> Panduan Pembayaran
                                </button>
                            </h2>
                            <div id="flush-collapseOne" class="accordion-collapse collapse" data-bs-parent="#accordionPayment">
                                <div class="accordion-body text-center">
                                    {{-- Menggunakan gambar aset lama --}}
                                    <img src="{{ asset('assets/images/cara-pembayaran-bank.jpg') }}" class="img-fluid rounded shadow-sm" alt="Panduan Pembayaran">
                                    <div class="mt-3 text-start small text-muted">
                                        <ol>
                                            <li>Datang ke ATM / Mobile Banking terdekat.</li>
                                            <li>Pilih menu <strong>Transfer / Pembayaran Virtual Account</strong>.</li>
                                            <li>Masukkan kode VA: <strong>{{ $full_va }}</strong>.</li>
                                            <li>Pastikan nama yang muncul sesuai dengan nama Anda.</li>
                                            <li>Simpan bukti transaksi.</li>
                                        </ol>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                
                {{-- Footer Action --}}
                <div class="card-footer bg-light p-4 text-center no-print">
                    <button onclick="window.print()" class="btn btn-dark me-2">
                        <i class="bi bi-printer me-1"></i> Cetak Invoice
                    </button>
                    <a href="{{ url('/dashboard') }}" class="btn btn-primary">
                        Masuk Dashboard <i class="bi bi-arrow-right ms-1"></i>
                    </a>
                </div>
            </div>
            @endif

        </div>
    </div>
</div>

<script>
    function copyToClipboard(text) {
        navigator.clipboard.writeText(text).then(function() {
            alert('Nomor VA berhasil disalin!');
        }, function(err) {
            console.error('Gagal menyalin: ', err);
        });
    }
</script>
@endsection