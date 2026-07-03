<div class="container my-5">
    
    {{-- CSS KHUSUS UNTUK MEMPERBAIKI TAMPILAN PRINT --}}
    <style>
        /* Tampilan Layar (Normal) */
        .op-8 { opacity: 0.8; }
        .object-fit-cover { object-fit: cover; }
        .hover-shadow:hover { box-shadow: 0 .5rem 1rem rgba(0,0,0,.15)!important; transform: translateY(-2px); }
        .transition { transition: all 0.3s ease; }
        .letter-spacing-2 { letter-spacing: 2px; }
        .nav-pills .nav-link.active { background-color: #0d6efd; }
        .nav-pills .nav-link { color: #555; background-color: #f8f9fa; margin: 0 5px; border-radius: 5px; }

        /* Tampilan Cetak (Print) - PERBAIKAN DI SINI */
        @media print {
            /* 1. Reset Halaman */
            @page {
                margin: 0.5cm; /* Margin kertas kecil agar muat banyak */
                size: auto; 
            }
            body {
                margin: 0;
                padding: 0;
                background-color: white !important;
            }

            /* 2. Sembunyikan Elemen Tidak Penting */
            body * {
                visibility: hidden; /* Sembunyikan semua */
            }
            .no-print, .btn, footer, nav, header {
                display: none !important; /* Hapus dari layout */
            }

            /* 3. Fokus ke Area Invoice */
            #printableArea, #printableArea * {
                visibility: visible; /* Tampilkan invoice */
            }
            
            #printableArea {
                position: absolute;
                left: 0;
                top: 0;
                width: 100% !important;
                max-width: 100% !important;
                margin: 0 !important;
                padding: 0 !important;
                border: none !important;
                box-shadow: none !important;
            }

            /* 4. Paksa Warna Background Muncul (PENTING) */
            .alert, .badge, .bg-primary, .bg-warning, .card-header {
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
                color-adjust: exact !important;
            }

            /* 5. Perbaikan Tata Letak */
            .col-md-8 {
                width: 100% !important; /* Paksa lebar penuh saat print */
                flex: 0 0 100% !important;
                max-width: 100% !important;
            }
            
            /* 6. Accordion & Gambar */
            .accordion-collapse {
                display: block !important; /* Paksa accordion terbuka */
                height: auto !important;
                visibility: visible !important;
                opacity: 1 !important;
            }
            img {
                max-width: 100% !important;
                height: auto !important;
                page-break-inside: avoid; /* Jangan potong gambar di tengah halaman */
            }
            
            /* 7. Font Size */
            h1.display-4 { font-size: 2.5rem !important; } /* Kecilkan sedikit font judul besar */
            .card-body { padding: 1rem !important; }
        }
    </style>

    {{-- HEADER SAMBUTAN (Hanya Tampil di Layar) --}}
    <div class="row mb-4 no-print">
        <div class="col-md-12">
            <div class="p-4 bg-primary text-white rounded shadow-sm">
                <h2 class="fw-bold">Selamat Datang, {{ Auth::user()->name }} 👋</h2>
                <p class="mb-0 op-8">Dashboard Calon Mahasiswa Baru</p>
            </div>
            
            @if (session('message'))
                <div class="alert alert-success mt-3 alert-dismissible fade show" role="alert">
                    <i class="bi bi-check-circle-fill me-2"></i> {{ session('message') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
        </div>
    </div>

    {{-- LOGIC UTAMA DASHBOARD --}}
    
    {{-- KONDISI 2: Belum Bayar DAN Masih Ada Session Tagihan (Tampilkan Invoice Full) --}}
    @if (Auth::user()->register->pembayaran === 'belum' && session()->has('tagihan'))
        
        @php
            $pendaftar = Auth::user()->register;
            $jalur = \App\Models\JalurMasuk::find($pendaftar->jalur_masuk_id);
            $tagihanResponse = session('tagihan');
            $tagihan = $tagihanResponse['tagihan'] ?? [];
            
            // Data Tagihan
            $idsPendaftarStrs = str_pad($pendaftar->id, 6, '0', STR_PAD_LEFT);
            $nomorVA = substr($tagihan['nomor_virtual_account'], 4);
            $nomorInvoice = $tagihan['nomor_invoice'] ?? '-';
            // Logic 24 Jam
            $jatuhTempo = $tagihan['tanggal_jatuh_tempo'] ?? null;
            $nominalTagihan = $tagihan['nominal_tagihan'] ?? $jalur->biaya;
        @endphp

        <div class="row justify-content-center">
            {{-- ID printableArea diletakkan di sini untuk menangkap lebar penuh kolom saat print --}}
            <div class="col-md-8" id="printableArea">
                
                {{-- KARTU INVOICE --}}
                <div class="card shadow-lg border-0" style="border-top: 5px solid #dc3545;">
                    <div class="card-body p-4 p-lg-5 text-center">
                        
                        {{-- KOP SURAT SEDERHANA (HANYA MUNCUL SAAT PRINT) --}}
                        <div class="d-none d-print-block mb-4 border-bottom pb-3">
                            <h3 class="fw-bold m-0">STKIP PGRI BANGKALAN</h3>
                            <p class="m-0">Panitia Penerimaan Mahasiswa Baru</p>
                        </div>

                        {{-- WARNING 24 JAM --}}
                        <div class="alert alert-danger border-danger fw-bold mb-4 shadow-sm">
                            <i class="bi bi-exclamation-triangle-fill me-2"></i> PERHATIAN: Segera lakukan pembayaran! Tagihan ini akan hangus dalam 1x24 jam.
                        </div>

                        <span class="badge bg-warning text-dark px-3 py-2 rounded-pill mb-3">Menunggu Pembayaran</span>
                        <h4 class="text-muted mb-2">Total Tagihan Pendaftaran</h4>
                        <h1 class="fw-bold text-danger display-4 mb-4">
                            Rp {{ number_format($nominalTagihan, 0, ',', '.') }}
                        </h1>

                        <div class="alert alert-light border border-dashed text-start d-inline-block w-100 mb-4 p-4 rounded-3">
                            <div class="row mb-2">
                                <div class="col-6 text-muted">Nama Pendaftar</div>
                                <div class="col-6 text-end fw-bold">{{ Auth::user()->name }}</div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-6 text-muted">Nomor Invoice</div>
                                <div class="col-6 text-end fw-bold">{{ $nomorInvoice }}</div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-6 text-muted">Jalur Masuk</div>
                                <div class="col-6 text-end fw-bold">{{ $jalur->nama }}</div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-6 text-muted">Batas Pembayaran</div>
                                <div class="col-6 text-end fw-bold text-danger">{{ \Carbon\Carbon::parse($jatuhTempo)->translatedFormat('d F Y') }}</div>
                            </div>
                            <hr>
                            <div class="text-center mt-3">
                                <p class="mb-1 text-muted small">Nomor Virtual Account (VA) / Kode Pembayaran</p>
                                <h2 class="fw-bold letter-spacing-2 text-primary" id="vaNumber">{{ $nomorVA }}</h2>
                                <button class="btn btn-sm btn-outline-primary rounded-pill mt-2 px-3 no-print" onclick="navigator.clipboard.writeText('{{ $nomorVA }}'); alert('Tersalin!');">
                                    <i class="bi bi-clipboard"></i> Salin VA
                                </button>
                            </div>
                        </div>

                        {{-- Accordion Cara Bayar --}}
                        <div class="accordion accordion-flush text-start border rounded" id="accordionPayment">
                            <div class="accordion-item">
                                <h2 class="accordion-header no-print">
                                    <button class="accordion-button fw-bold" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne">
                                        <i class="bi bi-info-circle me-2 text-primary"></i> Tata Cara Pembayaran (BSI)
                                    </button>
                                </h2>
                                {{-- Class 'show' memastikan accordion terbuka default --}}
                                <div id="flush-collapseOne" class="accordion-collapse collapse show" data-bs-parent="#accordionPayment">
                                    <div class="accordion-body p-0">
                                        
                                        {{-- Gambar Panduan --}}
                                        <div class="text-center p-3 border-bottom bg-light">
                                            <img src="{{ asset('assets/images/cara-pembayaran-bank.jpg') }}" class="img-fluid rounded shadow-sm" alt="Panduan Pembayaran BSI" style="max-height: 800px; width: auto;">
                                        </div>

                                        {{-- Tab Navigasi --}}
                                        <div class="p-3">
                                            <h6 class="fw-bold mb-3 border-bottom pb-2">Panduan Teknis:</h6>
                                            <ul class="nav nav-pills nav-fill mb-3 no-print" id="pills-tab" role="tablist">
                                                <li class="nav-item"><button class="nav-link active small fw-bold" id="pills-byond-tab" data-bs-toggle="pill" data-bs-target="#pills-byond">Byond BSI</button></li>
                                                <li class="nav-item"><button class="nav-link small fw-bold" id="pills-atm-tab" data-bs-toggle="pill" data-bs-target="#pills-atm">ATM BSI</button></li>
                                                <li class="nav-item"><button class="nav-link small fw-bold" id="pills-teller-tab" data-bs-toggle="pill" data-bs-target="#pills-teller">Teller</button></li>
                                                <li class="nav-item"><button class="nav-link small fw-bold" id="pills-lain-tab" data-bs-toggle="pill" data-bs-target="#pills-lain">Bank Lain</button></li>
                                            </ul>

                                            <div class="tab-content" id="pills-tabContent">
                                                <div class="tab-pane fade show active" id="pills-byond">
                                                    <ol class="small mb-0 ps-3">
                                                        <li>Pilih Menu <strong>Pembayaran/Tagihan</strong> > <strong>Akademik</strong>.</li>
                                                        <li>Masukkan Kode <strong>5047</strong> (STKIP PGRI Bangkalan).</li>
                                                        <li>Masukkan Nomor Pembayaran: <strong>{{ $nomorVA }}</strong>.</li>
                                                        <li>Masukkan PIN dan selesaikan pembayaran.</li>
                                                    </ol>
                                                </div>
                                                <div class="tab-pane fade" id="pills-atm">
                                                    <ol class="small mb-0 ps-3">
                                                        <li>Pilih <strong>Transfer</strong> > <strong>BSI lainnya</strong>.</li>
                                                        <li>Masukkan Kode: 9005047{{ $nomorVA }}.</li>
                                                        <li>Cek data dan pilih YA.</li>
                                                    </ol>
                                                </div>
                                                <div class="tab-pane fade" id="pills-teller">
                                                    <ol class="small mb-0 ps-3">
                                                        <li>Tulis di slip: Kode <strong>5047</strong> + Nomor Pembayaran <strong>{{ $nomorVA }}</strong>.</li>
                                                        <li>Serahkan ke Teller.</li>
                                                    </ol>
                                                </div>
                                                <div class="tab-pane fade" id="pills-lain">
                                                    <ol class="small mb-0 ps-3">
                                                        <li>Transfer Antar Bank Online > Bank BSI (451).</li>
                                                        <li>Rekening Tujuan: <strong>9005047{{ $nomorVA }}</strong>.</li>
                                                    </ol>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    
                    {{-- TOMBOL PRINT --}}
                    <div class="card-footer bg-white p-4 text-center no-print">
                        <button onclick="window.print()" class="btn btn-dark btn-lg shadow-sm">
                            <i class="bi bi-printer-fill me-2"></i> Cetak / Simpan PDF
                        </button>
                        <p class="text-muted mt-2 small">Klik tombol di atas lalu pilih "Save as PDF" pada pengaturan printer.</p>
                    </div>
                </div>

            </div>
        </div>


    {{-- KONDISI 3: Default Dashboard (Session Hilang / Sudah Bayar) --}}
    @else
        
        @php
            $pendaftar = Auth::user()->register;
        @endphp

        {{-- STATUS KELULUSAN / PEMBAYARAN --}}
        <div class="row mb-4 no-print">
            <div class="col-12">
                <div class="card shadow-sm border-0">
                    <div class="card-body p-4">
                        <h5 class="card-title fw-bold border-bottom pb-2 mb-3">Status Pendaftaran</h5>
                        
                        <!-- <div class="row align-items-center">
                            <div class="col-md-3 text-center mb-3 mb-md-0">
                                @if($pendaftar->status_diterima == 'diterima')
                                    <img src="https://cdn-icons-png.flaticon.com/512/190/190411.png" width="100" alt="Success">
                                @elseif($pendaftar->status_diterima == 'tidak diterima')
                                    <img src="https://cdn-icons-png.flaticon.com/512/1828/1828843.png" width="100" alt="Failed">
                                @else
                                    @if($pendaftar->pembayaran == 'belum')
                                         <div class="text-warning">
                                            <i class="bi bi-exclamation-circle-fill" style="font-size: 4rem;"></i>
                                            <p class="fw-bold mt-2">Belum Lunas</p>
                                         </div>
                                    @else
                                        <img src="https://cdn-icons-png.flaticon.com/512/2972/2972531.png" width="100" alt="Verifikasi">
                                    @endif
                                @endif
                            </div>
                            <div class="col-md-9">
                                @if ($pendaftar->status_diterima == 'diterima')
                                    <div class="alert alert-success border-0 bg-success bg-opacity-10">
                                        <h4 class="alert-heading fw-bold text-success"><i class="bi bi-award-fill"></i> SELAMAT! ANDA DITERIMA</h4>
                                        <p class="mb-0">Anda dinyatakan lulus seleksi masuk pada Program Studi:</p>
                                        <h3 class="fw-bold mt-2 text-dark">{{ $pendaftar->diterimadi->nama ?? 'Program Studi Pilihan' }}</h3>
                                    </div>
                                @elseif($pendaftar->status_diterima == 'tidak diterima')
                                    <div class="alert alert-danger border-0">
                                        <h4 class="alert-heading fw-bold">Mohon Maaf</h4>
                                        <p>Anda dinyatakan belum lulus seleksi pada periode ini.</p>
                                    </div>
                                @elseif($pendaftar->pembayaran == 'belum')
                                    <div class="alert alert-warning border-0">
                                        <h4 class="alert-heading fw-bold">Menunggu Pembayaran</h4>
                                        <p>Status pendaftaran Anda saat ini <strong>Belum Lunas</strong>. Jika session tagihan Anda berakhir, silakan hubungi admin atau login ulang untuk mengecek status.</p>
                                    </div>
                                @else
                                    <div class="alert alert-info border-0">
                                        <h4 class="alert-heading fw-bold">Berkas Sedang Diverifikasi</h4>
                                        <p>Terima kasih telah melakukan pembayaran (LUNAS). Data sedang diseleksi oleh panitia.</p>
                                    </div>
                                @endif
                            </div>
                        </div> -->
                    </div>
                </div>
            </div>
        </div>

        {{-- INFO TERBARU (PENGUMUMAN) --}}
        <div class="row no-print">
            <div class="col-12 mb-3">
                <div class="d-flex justify-content-between align-items-center">
                    <h4 class="fw-bold"><i class="bi bi-megaphone-fill text-primary"></i> Informasi Terbaru</h4>
                    <a href="{{ url('pengumuman/index') }}" class="btn btn-sm btn-outline-primary">Lihat Semua</a>
                </div>
            </div>

            @php
                $informasis = App\Models\Informasi::latest()->take(3)->get();
            @endphp
        
            @if ($informasis->isNotEmpty())
                @foreach ($informasis as $informasi)
                <div class="col-md-4 mb-4">
                    <div class="card h-100 shadow-sm hover-shadow transition">
                        <div class="card-img-wrapper" style="height: 160px; overflow: hidden;">
                             @if ($informasi->image)
                                <img src="{{ asset('storage/'.$informasi->image) }}" class="w-100 h-100 object-fit-cover" alt="{{ $informasi->title }}">
                            @else
                                <img src="https://source.unsplash.com/random/400x300?campus,university&sig={{ $loop->index }}" class="w-100 h-100 object-fit-cover" alt="Random Image">
                            @endif
                        </div>
                        <div class="card-body">
                            <h5 class="card-title fw-bold text-truncate">{{ $informasi->title }}</h5>
                            <p class="card-text text-muted small">{!! Str::limit(strip_tags($informasi->content), 80) !!}</p>
                        </div>
                        <div class="card-footer bg-white border-top-0 pt-0">
                            <a href="{{ url('pengumuman/'. $informasi->slug) }}" class="btn btn-primary w-100 btn-sm">Baca Selengkapnya</a>
                        </div>
                    </div>
                </div>
                @endforeach
            @else
                <div class="col-12">
                    <div class="alert alert-light text-center border">Belum ada pengumuman terbaru.</div>
                </div>
            @endif
        </div>

    @endif

</div>