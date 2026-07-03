@extends('layouts.main')

@section('container')
<div class="container my-3 my-md-5">
    <div class="card shadow-lg border-0 rounded-4 overflow-hidden">
        
        {{-- HEADER BIRU --}}
        <div class="card-header bg-primary text-white text-center py-4 position-relative">
            <div class="position-absolute top-0 start-0 w-100 h-100" style="background: linear-gradient(45deg, rgba(255,255,255,0.1) 0%, rgba(255,255,255,0) 100%);"></div>
            <h3 class="mb-1 fw-bold position-relative z-1">Pendaftaran Mahasiswa Baru</h3>
            <p class="mb-0 opacity-75 small position-relative z-1">Lengkapi data secara bertahap</p>
        </div>
        
        <div class="card-body p-3 p-md-5">
            
            {{-- TAMPILAN INDIKATOR LANGKAH (DESKTOP & MOBILE BEDA) --}}
            
            {{-- 1. Versi Desktop (Lingkaran) --}}
            <div class="d-none d-md-block position-relative mx-5 mb-5">
                <div class="progress" style="height: 4px; top: 15px; z-index: 0;">
                    <div class="progress-bar" role="progressbar" style="width: 0%;" id="desktopProgressBar"></div>
                </div>
                <div class="d-flex justify-content-between position-relative w-100" style="z-index: 1;">
                    <button class="step-circle btn btn-primary rounded-circle shadow-sm fw-bold" style="width: 40px; height: 40px;">1</button>
                    <button class="step-circle btn btn-secondary rounded-circle shadow-sm fw-bold" style="width: 40px; height: 40px;">2</button>
                    <button class="step-circle btn btn-secondary rounded-circle shadow-sm fw-bold" style="width: 40px; height: 40px;">3</button>
                    <button class="step-circle btn btn-secondary rounded-circle shadow-sm fw-bold" style="width: 40px; height: 40px;">4</button>
                    <button class="step-circle btn btn-secondary rounded-circle shadow-sm fw-bold" style="width: 40px; height: 40px;">5</button>
                </div>
                <div class="d-flex justify-content-between px-1 mt-2 small fw-bold text-muted">
                    <span>Jalur</span>
                    <span>Data Diri</span>
                    <span>Sekolah</span>
                    <span>Prodi</span>
                    <span>Berkas</span>
                </div>
            </div>

            {{-- 2. Versi Mobile (Progress Bar Simple) --}}
            <div class="d-block d-md-none mb-4">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <span class="fw-bold text-primary" id="mobileStepTitle">Langkah 1: Jalur Pendaftaran</span>
                    <span class="badge bg-primary bg-opacity-10 text-primary rounded-pill" id="mobileStepCount">1 / 5</span>
                </div>
                <div class="progress" style="height: 8px; border-radius: 4px;">
                    <div class="progress-bar bg-primary" role="progressbar" style="width: 20%;" id="mobileProgressBar"></div>
                </div>
            </div>

            <hr class="d-block d-md-none opacity-25">
            {{-- Letakkan ini di atas <form> --}}
            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <h4 class="alert-heading"><i class="bi bi-exclamation-triangle-fill"></i> Ada kesalahan input!</h4>
                    <hr>
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <form action="{{ route('pendaftaran.store') }}" method="POST" enctype="multipart/form-data" id="wizardForm">
                @csrf

                <div class="step-section" id="step1" data-title="Jalur Pendaftaran">
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label fw-semibold">Jenjang Pendidikan</label>
                            <select class="form-select form-select-lg" name="jenjang_pendidikan" required>
                                <option value="" selected disabled>Pilih Jenjang...</option>
                                @foreach($jenjang_pendidikan as $jp)
                                    <option value="{{ $jp->id }}">{{ $jp->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-semibold">Sistem Kuliah</label>
                            <select class="form-select form-select-lg" name="sistem_kuliah" required>
                                <option value="" selected disabled>Pilih Sistem...</option>
                                @foreach($sistem_kuliah as $sk)
                                    <option value="{{ $sk->id }}">{{ $sk->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-semibold">Jalur Masuk</label>
                            <div class="p-3 border rounded bg-light mb-2">
                                <select class="form-select form-select-lg" name="jalur_masuk" id="jalur_masuk" required>
                                    <option value="" selected disabled>Pilih Jalur Masuk...</option>
                                    @foreach($jalur_masuk as $jm)
                                        <option value="{{ $jm->id }}" data-biaya="{{ $jm->biaya }}">{{ $jm->nama }}</option>
                                    @endforeach
                                </select>
                                <div id="biaya_info" class="mt-2 text-primary fw-bold small">
                                    <i class="bi bi-info-circle me-1"></i> Pilih jalur untuk melihat biaya.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="step-section d-none" id="step2" data-title="Identitas Diri">
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label">Nama Lengkap</label>
                            <input type="text" class="form-control form-control-lg" name="nama" placeholder="Sesuai KTP/Ijazah" required value="{{ old('nama') }}">
                        </div>
                        <div class="col-6">
                            <label class="form-label">Jenis Kelamin</label>
                            <select class="form-select form-select-lg" name="jk" required>
                                <option value="L">Laki-laki</option>
                                <option value="P">Perempuan</option>
                            </select>
                        </div>
                        <div class="col-6">
                            <label class="form-label">No. HP (WA)</label>
                            <input type="number" class="form-control form-control-lg" name="hp" placeholder="08xxx" required value="{{ old('hp') }}">
                        </div>
                        <div class="col-12">
                            <label class="form-label">Email Aktif</label>
                            <input type="email" class="form-control form-control-lg" name="email" placeholder="contoh@gmail.com" required value="{{ old('email') }}">
                        </div>
                        <div class="col-12">
                            <label class="form-label">NIK (KTP/KK)</label>
                            <input type="number" class="form-control form-control-lg" name="identitas_kewarganegaraan" required value="{{ old('identitas_kewarganegaraan') }}">
                        </div>
                        <div class="col-6">
                            <label class="form-label">Tempat Lahir</label>
                            <input type="text" class="form-control" name="tempat_lahir" required value="{{ old('tempat_lahir') }}">
                        </div>
                        <div class="col-6">
                            <label class="form-label">Tanggal Lahir</label>
                            <input type="date" class="form-control" name="tanggal_lahir" required value="{{ old('tanggal_lahir') }}">
                        </div>
                        <div class="col-12">
                            <label class="form-label">Alamat Lengkap</label>
                            <textarea class="form-control" name="alamat" rows="2" placeholder="Jalan, RT/RW, Desa, Kec..." required>{{ old('alamat') }}</textarea>
                        </div>
                         <div class="col-12">
                            <label class="form-label">Nama Ibu Kandung</label>
                            <input type="text" class="form-control" name="nama_ibu" required value="{{ old('nama_ibu') }}">
                        </div>
                        <input type="hidden" name="kewarganegaraan" value="Indonesia">
                    </div>
                </div>

                <div class="step-section d-none" id="step3" data-title="Asal Sekolah">
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label">Nama Sekolah Asal</label>
                            <input type="text" class="form-control form-control-lg" name="nama_sekolah" placeholder="SMA/SMK..." required value="{{ old('nama_sekolah') }}">
                        </div>
                        <div class="col-6">
                            <label class="form-label">NISN</label>
                            <input type="number" class="form-control" name="nisn" required value="{{ old('nisn') }}">
                        </div>
                        <div class="col-6">
                            <label class="form-label">Tahun Lulus</label>
                            <input type="number" class="form-control" name="tahun_lulus" placeholder="202X" required value="{{ old('tahun_lulus') }}">
                        </div>
                        <div class="col-6">
                            <label class="form-label">Jenis Sekolah</label>
                            <select class="form-select" name="jenis_sekolah" required>
                                <option value="SMA">SMA</option>
                                <option value="SMK">SMK</option>
                                <option value="MA">MA</option>
                                <option value="Lainnya">Lainnya</option>
                            </select>
                        </div>
                        <div class="col-6">
                            <label class="form-label">Jurusan</label>
                            <input type="text" class="form-control" name="jurusan_sekolah" placeholder="IPA/IPS/TKJ" required value="{{ old('jurusan_sekolah') }}">
                        </div>
                        <div class="col-12">
                            <label class="form-label">Alamat Sekolah</label>
                            <input type="text" class="form-control" name="alamat_sekolah" required value="{{ old('alamat_sekolah') }}">
                        </div>
                    </div>
                </div>

                <div class="step-section d-none" id="step4" data-title="Pilih Program Studi">
                    <div class="alert alert-info border-0 shadow-sm d-flex align-items-center">
                        <i class="bi bi-info-circle-fill fs-4 me-3"></i>
                        <div>Wajib memilih 4 Prodi berbeda sebagai urutan prioritas.</div>
                    </div>
                    <div class="row g-3">
                        @for ($i = 1; $i <= 4; $i++)
                        <div class="col-12">
                            <div class="card bg-light border-0">
                                <div class="card-body p-3">
                                    <label class="form-label fw-bold mb-1">Pilihan {{ $i }}</label>
                                    <select class="form-select" name="pilihan{{ $i }}" required>
                                        <option value="" selected disabled>Pilih Prodi...</option>
                                        @foreach($prodis as $prodi)
                                            <option value="{{ $prodi->id }}">{{ $prodi->nama }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        @endfor
                    </div>
                </div>

                <div class="step-section d-none" id="step5" data-title="Upload Berkas">
                    <div class="alert alert-warning border-0 d-flex align-items-center">
                        <i class="bi bi-file-earmark-pdf-fill fs-4 me-3"></i>
                        <small>Format: PDF/JPG/PNG. Maks 2MB per file.</small>
                    </div>
                    
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label">Pas Foto</label>
                            <input type="file" class="form-control" name="pas_foto" required>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Ijazah / SKL</label>
                            <input type="file" class="form-control" name="ijazah_skl" required>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Kartu Keluarga (KK)</label>
                            <input type="file" class="form-control" name="kk" required>
                        </div>
                        <div class="col-12">
                            <label class="form-label">KTP</label>
                            <input type="file" class="form-control" name="ktp" required>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Akta Kelahiran</label>
                            <input type="file" class="form-control" name="akta" required>
                        </div>
                        <div class="col-12">
                            {{-- LABEL DINAMIS DITAMBAHKAN ID DISINI --}}
                            <label class="form-label" id="label_doc_pend">Dokumen Pendukung (Opsional, tidak wajib)</label>
                            <input type="file" class="form-control" name="doc_pend_jalur_masuk">
                        </div>
                    </div>
                </div>

                {{-- NAVIGASI TOMBOL (Responsive Stack) --}}
                <div class="mt-4 pt-3 border-top">
                    <div class="row g-2 flex-row-reverse">
                        <div class="col-12 col-md-auto">
                            <button type="button" class="btn btn-primary btn-lg w-100 btn-next shadow-sm">
                                Lanjut <i class="bi bi-arrow-right ms-2"></i>
                            </button>
                            <button type="submit" class="btn btn-success btn-lg w-100 btn-submit d-none shadow-sm" onclick="return confirm('Data sudah benar?')">
                                Daftar Sekarang <i class="bi bi-check-lg ms-2"></i>
                            </button>
                        </div>
                        <div class="col-12 col-md-auto">
                            <button type="button" class="btn btn-light btn-lg w-100 border btn-prev text-muted" style="display: none;">
                                <i class="bi bi-arrow-left me-2"></i> Kembali
                            </button>
                        </div>
                    </div>
                </div>

            </form>
        </div>
    </div>
</div>

{{-- SCRIPT PENGATUR WIZARD --}}
<script>
    document.addEventListener("DOMContentLoaded", function() {
        let currentStep = 1;
        const totalSteps = 5;
        
        // Element Selectors
        const desktopProgressBar = document.getElementById('desktopProgressBar');
        const mobileProgressBar = document.getElementById('mobileProgressBar');
        const mobileStepTitle = document.getElementById('mobileStepTitle');
        const mobileStepCount = document.getElementById('mobileStepCount');
        const btnNext = document.querySelector('.btn-next');
        const btnPrev = document.querySelector('.btn-prev');
        const btnSubmit = document.querySelector('.btn-submit');
        
        const updateUI = () => {
            // 1. Show/Hide Section
            document.querySelectorAll('.step-section').forEach(el => el.classList.add('d-none'));
            const currentSection = document.querySelector(`#step${currentStep}`);
            currentSection.classList.remove('d-none');
            
            // 2. Update Data Title Mobile
            const stepTitle = currentSection.getAttribute('data-title');
            mobileStepTitle.innerText = `Langkah ${currentStep}: ${stepTitle}`;
            mobileStepCount.innerText = `${currentStep} / ${totalSteps}`;

            // 3. Update Progress Bars
            const percent = ((currentStep - 1) / (totalSteps - 1)) * 100;
            if(desktopProgressBar) desktopProgressBar.style.width = `${percent}%`;
            if(mobileProgressBar) mobileProgressBar.style.width = `${currentStep * 20}%`; 
            
            // 4. Update Desktop Circles
            document.querySelectorAll('.step-circle').forEach((el, index) => {
                if (index + 1 <= currentStep) {
                    el.classList.remove('btn-secondary');
                    el.classList.add('btn-primary');
                } else {
                    el.classList.remove('btn-primary');
                    el.classList.add('btn-secondary');
                }
            });

            // 5. Button Visibility
            if (currentStep === 1) {
                btnPrev.style.display = 'none';
            } else {
                btnPrev.style.display = 'block';
            }

            if (currentStep === totalSteps) {
                btnNext.classList.add('d-none');
                btnSubmit.classList.remove('d-none');
            } else {
                btnNext.classList.remove('d-none');
                btnSubmit.classList.add('d-none');
            }
        };

        // Initialize
        updateUI();

        // Next Logic
        btnNext.addEventListener('click', () => {
            const currentSection = document.querySelector(`#step${currentStep}`);
            const inputs = currentSection.querySelectorAll('input, select, textarea');
            let isValid = true;
            
            // Simple Validation
            inputs.forEach(input => {
                if (input.hasAttribute('required') && !input.value) {
                    isValid = false;
                    input.classList.add('is-invalid');
                } else {
                    input.classList.remove('is-invalid');
                }
            });

            if (isValid) {
                if (currentStep < totalSteps) {
                    currentStep++;
                    updateUI();
                    window.scrollTo({ top: 0, behavior: 'smooth' });
                }
            } else {
                alert('Mohon lengkapi data wajib pada langkah ini.');
                const firstInvalid = currentSection.querySelector('.is-invalid');
                if(firstInvalid) firstInvalid.focus();
            }
        });

        // Prev Logic
        btnPrev.addEventListener('click', () => {
            if (currentStep > 1) {
                currentStep--;
                updateUI();
                window.scrollTo({ top: 0, behavior: 'smooth' });
            }
        });

        // LOGIKA UPDATE JALUR MASUK (BIAYA & LABEL DOKUMEN)
        const jalurSelect = document.getElementById('jalur_masuk');
        const biayaInfo = document.getElementById('biaya_info');
        const labelDoc = document.getElementById('label_doc_pend'); // Selector Label
        
        if(jalurSelect){
            jalurSelect.addEventListener('change', function() {
                const selectedOption = this.options[this.selectedIndex];
                const biaya = selectedOption.getAttribute('data-biaya');
                const namaJalur = selectedOption.text; // Ambil Teks Jalur

                // Update Biaya
                if(biaya) {
                    const rupiah = new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR' }).format(biaya);
                    biayaInfo.innerHTML = `<i class="bi bi-check-circle-fill me-1"></i> Biaya Pendaftaran: <span class="fw-bold">${rupiah}</span>`;
                    biayaInfo.classList.remove('text-primary');
                    biayaInfo.classList.add('text-success');
                }

                // Update Label Dokumen Pendukung
                if(labelDoc) {
                    labelDoc.innerText = `Dokumen Pendukung ${namaJalur} (opsional, tidak wajib)`;
                }
            });
        }
    });
</script>
@endsection