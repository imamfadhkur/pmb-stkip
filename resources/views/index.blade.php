@extends('layouts.main')

@section('container')
<div class="jumbotron my-4">
    <div class="container-fluid text-center text-white" style="background-image: url({{ asset('assets/images/stkippgri-bkl-gedung-depan-blackv.jpg') }}); background-size: cover; background-repeat: no-repeat; background-position: center center; height: 100vh; display: flex; justify-content: center; align-items: center;">
        <h1 style="display: flex; flex-direction: column;"> Penerimaan Mahasiswa Baru <br>STKIP PGRI Bangkalan <br>
            <center>
                @auth
                    {{-- Jika user sudah login, arahkan ke Dashboard --}}
                    <a class="btn btn-my-primary text-light btn-lg mt-4" href="{{ url('dashboard') }}" role="button" style="display: inline-block; max-width: max-content;">Dashboard</a>
                @else
                    {{-- Jika user belum login, Munculkan MODAL Validasi Dokumen --}}
                    <button type="button" class="btn btn-my-primary text-light btn-lg mt-4" data-bs-toggle="modal" data-bs-target="#modalPersiapan" style="display: inline-block; max-width: max-content;">
                        Daftar Sekarang
                    </button>
                @endauth
            </center>
        </h1>
    </div>
</div>

<div class="modal fade" id="modalPersiapan" tabindex="-1" aria-labelledby="modalPersiapanLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title fw-bold" id="modalPersiapanLabel">
                    <i class="fas fa-info-circle me-2"></i>Persiapan Berkas
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-start text-dark">
                <p class="mb-3">Sebelum melanjutkan proses pendaftaran, pastikan Anda telah menyiapkan file scan/foto dokumen berikut:</p>
                <ul class="list-group list-group-flush mb-3">
                    <li class="list-group-item"><i class="fas fa-check text-success me-2"></i> Dokumen Pendukung Jalur yang Dipilih</li>
                    <li class="list-group-item"><i class="fas fa-check text-success me-2"></i> Pas Foto 3x4 (Background Merah/Biru)</li>
                    <li class="list-group-item"><i class="fas fa-check text-success me-2"></i> Ijazah atau SKL (Surat Keterangan Lulus)</li>
                    <li class="list-group-item"><i class="fas fa-check text-success me-2"></i> Kartu Keluarga (KK)</li>
                    <li class="list-group-item"><i class="fas fa-check text-success me-2"></i> KTP (Kartu Tanda Penduduk)</li>
                    <li class="list-group-item"><i class="fas fa-check text-success me-2"></i> Akta Kelahiran</li>
                </ul>
                <div class="alert alert-warning py-2 small">
                    <i class="fas fa-exclamation-triangle me-1"></i> File harus dalam format <b>PDF, JPG, atau PNG</b>. <br>
                    <i class="fas fa-exclamation-triangle me-1"></i> Maksimal <b>2MB</b>.
                </div>
            </div>
            <div class="modal-footer justify-content-between">
                {{-- Tombol Batal --}}
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                    <i class="fas fa-arrow-left me-1"></i> Siapkan Dokumen Dulu
                </button>
                
                {{-- Tombol Lanjut --}}
                <a href="{{ url('pendaftaran-baru') }}" class="btn btn-primary">
                    Ya, Lanjut Pendaftaran <i class="fas fa-arrow-right ms-1"></i>
                </a>
            </div>
        </div>
    </div>
</div>
@endsection