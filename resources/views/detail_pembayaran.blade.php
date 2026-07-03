@extends('layouts.main')

@section('custom_css')
<style>
    /* Style standar untuk layar */
    .invoice-card {
        border-top: 5px solid #0d6efd; /* Aksen biru di atas */
    }
    
    /* Ganti pengaturan data-label agar lebih tegas dan konsisten */
    .data-label {
        color: #495057;
        font-weight: 500;
        padding-right: 15px; /* Tambah jarak dengan nilai */
        /* Hapus width: 160px; karena sekarang menggunakan col-5 */
    }

    .data-value {
        font-weight: 700;
        color: #212529;
        font-size: 1.05rem;
    }

    /* Penyesuaian Flexbox untuk VA dan Nominal agar tombol copy sejajar */
    .data-value-wrapper {
        display: flex;
        align-items: center;
    }

    /* COPY BUTTON STYLE */
    .btn-copy {
        cursor: pointer;
        color: #0d6efd;
        background: rgba(13, 110, 253, 0.1);
        border: none;
        padding: 4px 8px; /* Padding sedikit lebih besar */
        border-radius: 4px;
        font-size: 0.8rem;
        margin-left: 10px; /* Jarak dari teks nilai */
        transition: all 0.2s;
    }
    .btn-copy:hover {
        background: rgba(13, 110, 253, 0.2);
    }

    /* KHUSUS PRINT / DOWNLOAD PDF */
    @media print {
        /* Sembunyikan elemen yang tidak perlu dicetak */
        .no-print, .btn, .navbar, footer, .card-footer, .alert-warning {
            display: none !important;
        }

        /* Reset container agar full width di kertas */
        .container, .col-md-8 {
            max-width: 100% !important;
            width: 100% !important;
            padding: 0 !important;
            margin: 0 !important;
        }

        /* Hilangkan shadow dan border card agar hemat tinta dan bersih */
        .card {
            border: none !important;
            box-shadow: none !important;
        }

        /* Tampilkan Header Kop Surat (hanya muncul saat print) */
        .print-header {
            display: block !important;
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 2px solid #000;
            padding-bottom: 10px;
        }

        /* Pastikan teks hitam pekat */
        body {
            color: #000 !important;
            background: #fff !important;
        }
    }

    /* Sembunyikan header print di layar biasa */
    .print-header {
        display: none;
    }
</style>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
@endsection

@section('container')

<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            
            @if($error_custom)
                <div class="alert alert-danger no-print">
                    {{ $error_custom }}
                </div>
            @elseif($tagihan)
                
                <div class="print-header">
                    <h3 style="margin:0;">STKIP PGRI BANGKALAN</h3>
                    <p style="margin:0; font-size: 0.9rem;">Pendaftaran Mahasiswa Baru</p>
                    <p style="margin:0; font-size: 0.8rem;">Website: pmb.stkippgri-bkl.ac.id</p>
                </div>

                <div class="card shadow invoice-card">
                    <div class="card-body p-4">
                        
                        <div class="text-center mb-4 no-print">
                            <h3 class="fw-bold">Detail Tagihan</h3>
                            <p class="text-muted">Silakan selesaikan pembayaran Anda sebelum tanggal jatuh tempo.</p>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-borderless align-middle" style="width: 100%;">
                                <tbody>
                                    <tr>
                                        <td class="data-label col-5">Nama Calon Mhs</td>
                                        <td class="col-7 data-value">: {{ $tagihan['nama'] }}</td>
                                    </tr>
                                    <tr>
                                        <td class="data-label col-5">Keterangan</td>
                                        <td class="col-7 data-value">: {{ $tagihan['keterangan'] }}</td>
                                    </tr>
                                    <tr>
                                        <td class="data-label col-5">Nomor Pembayaran</td>
                                        <td class="col-7">
                                            <div class="data-value-wrapper">
                                                <span class="data-value text-primary" style="font-size: 1.2rem;">
                                                    : {{ explode('/', $tagihan['nomor_invoice'])[1] }}
                                                </span>
                                                <button class="btn-copy no-print" data-target="nomorPembayaran" title="Copy Invoice">
                                                    <i class="bi bi-clipboard"></i> Copy
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr style="background-color: #f8f9fa;">
                                        <td class="data-label col-5">Kode VA (Virtual Account)</td>
                                        <td class="col-7">
                                            <div class="data-value-wrapper">
                                                <span class="d-none" id="nomorVA">5047{{ explode('/', $tagihan['nomor_invoice'])[1] }}</span>
                                                
                                                <span class="data-value text-primary" style="font-size: 1.2rem;">
                                                    : 5047 {{ explode('/', $tagihan['nomor_invoice'])[1] }}
                                                </span>
                                                
                                                <button class="btn-copy no-print" data-target="nomorVA" title="Copy VA">
                                                    <i class="bi bi-clipboard"></i> Copy
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="data-label col-5">Tanggal Tagihan</td>
                                        <td class="col-7 data-value">: {{ \Carbon\Carbon::parse($tagihan['tanggal_tagihan'])->format('d F Y') }}</td>
                                    </tr>
                                    <tr>
                                        <td class="data-label col-5">Total Tagihan</td>
                                        <td class="col-7">
                                            <div class="data-value-wrapper">
                                                <span class="d-none" id="nominalTagihan">{{ $tagihan['nominal_tagihan'] }}</span>
                                                <span class="data-value text-success fs-4 me-2">
                                                    : Rp {{ number_format($tagihan['nominal_tagihan'], 0, ',', '.') }}
                                                </span>
                                                <button class="btn-copy no-print" data-target="nominalTagihan" title="Copy Nominal">
                                                    <i class="bi bi-clipboard"></i> Copy
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <div class="alert alert-light border mt-3 no-print">
                            <small>
                                <i class="bi bi-info-circle-fill text-info"></i> 
                                <strong>Catatan:</strong> Harap simpan bukti pembayaran ini. Status pembayaran akan otomatis terupdate setelah Anda melakukan transfer.
                            </small>
                        </div>
                        <div class="mb-3">
                            <strong>Nominal:</strong>
                            <p class="mb-0">Rp{{ number_format($tagihan['nominal_tagihan'] + 3000, 0, ',', '.') }}</p>
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

                    <div class="card-footer bg-white text-center no-print">
                        <h6 class="text-muted mb-3">Panduan Pembayaran</h6>
                        <img src="{{ asset('assets/images/cara-pembayaran-bank.jpg') }}" alt="Cara Bayar" class="img-fluid rounded" style="max-height: 800px;">
                    </div>
                </div>

            @else
                <div class="alert alert-warning">
                    Sesi telah berakhir, Anda terlalu lama disini :). Silakan hubungi admin atau contact person mengenai informasi tagihan atau hal lainnya.
                </div>
            @endif
        </div>
    </div>
</div>

<script>
    // Pastikan script ini tetap ada di bagian bawah file blade
    document.querySelectorAll('.btn-copy').forEach(function(btn) {
        btn.addEventListener('click', function() {
            var targetId = btn.getAttribute('data-target');
            var targetElement = document.getElementById(targetId);
            var text = targetElement.innerText;
            
            // Hilangkan spasi, koma, dan Rp (untuk memastikan hanya angka yang tercopy)
            text = text.replace(/\s/g, '').replace(/Rp/g, '').replace(/\./g, '').replace(/,/g, ''); 
            
            navigator.clipboard.writeText(text).then(function() {
                var icon = btn.querySelector('i');
                
                // Feedback visual
                btn.innerHTML = '<i class="bi bi-check-lg"></i> Tersalin!';
                btn.classList.add('btn-success', 'text-white');
                btn.classList.remove('btn-copy', 'text-primary');

                setTimeout(function() {
                    btn.innerHTML = '<i class="bi bi-clipboard"></i> Copy';
                    btn.classList.remove('btn-success', 'text-white');
                    btn.classList.add('btn-copy', 'text-primary');
                }, 1500);
            });
        });
    });
</script>

@endsection