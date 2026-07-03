<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Register;
use App\Models\BerkasPendaftar;
use App\Models\JenjangPendidikan;
use App\Models\SistemKuliah;
use App\Models\JalurMasukProdi;
use App\Models\Prodi;
use App\Models\JalurMasuk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class NewPendaftaranController extends Controller
{
    public function index()
    {
        // Mengambil semua data master yang dibutuhkan untuk dropdown
        $data = [
            'title' => 'Pendaftaran Mahasiswa Baru',
            'jenjang_pendidikan' => JenjangPendidikan::all(),
            'sistem_kuliah' => SistemKuliah::all(),
            // Ambil Jalur Masuk yang aktif dan memiliki kuota
            'jalur_masuk' => JalurMasukProdi::join('jalur_masuks', 'jalur_masuk_prodis.jalur_masuk_id', '=', 'jalur_masuks.id')
                ->where('jalur_masuk_prodis.kuota', '>', 0)
                ->where('jalur_masuks.status', 'aktif')
                ->select('jalur_masuks.*')
                ->distinct()
                ->get(),
            // Ambil Prodi yang masih ada kuota
            'prodis' => Prodi::where('sisa_kuota', '>', 0)->get()
        ];

        return view('pendaftaran_wizard.index', $data);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            // --- 1. ATURAN (RULES) ---
            'nama' => 'required|max:255',
            'jk' => 'required',
            'hp' => 'required|numeric',
            'email' => 'required|email|unique:users,email',
            'tempat_lahir' => 'required|max:64',
            'tanggal_lahir' => 'required|date|before:today',
            'alamat' => 'required',
            'kewarganegaraan' => 'required',
            'identitas_kewarganegaraan' => 'required|numeric',
            'nama_ibu' => 'required',
            
            'nama_sekolah' => 'required|max:255',
            'jenis_sekolah' => 'required',
            'jurusan_sekolah' => 'required',
            'tahun_lulus' => 'required|numeric|digits:4',
            'nisn' => 'required|numeric',
            'alamat_sekolah' => 'required',

            'jenjang_pendidikan' => 'required',
            'sistem_kuliah' => 'required',
            'jalur_masuk' => 'required',
            'pilihan1' => 'required',
            'pilihan2' => 'required|different:pilihan1',
            'pilihan3' => 'required|different:pilihan1,pilihan2',
            'pilihan4' => 'required|different:pilihan1,pilihan2,pilihan3',

            'pas_foto' => 'required|mimes:pdf,jpg,png|max:2048',
            'ijazah_skl' => 'required|mimes:pdf,jpg,png|max:2048',
            'kk' => 'required|mimes:pdf,jpg,png|max:2048',
            'ktp' => 'required|mimes:pdf,jpg,png|max:2048',
            'akta' => 'required|mimes:pdf,jpg,png|max:2048',
            'doc_pend_jalur_masuk' => 'nullable|mimes:pdf,jpg,png|max:2048',
            
        ], [
            // --- 2. KUSTOMISASI PESAN (MESSAGES) ---
            // Gunakan :attribute agar namanya dinamis
            'required' => ':attribute wajib diisi.',
            'numeric'  => ':attribute harus berupa angka.',
            'email'    => 'Format :attribute tidak valid.',
            'unique'   => ':attribute sudah terdaftar, silakan gunakan yang lain.',
            'max'      => [
                'string' => ':attribute maksimal :max karakter.',
                'file'   => 'Ukuran :attribute maksimal :max KB.', // File max dalam satuan KB
            ],
            'date'     => ':attribute bukan format tanggal yang valid.',
            'before'   => ':attribute harus sebelum hari ini.',
            'digits'   => ':attribute harus berjumlah tepat :digits angka.',
            'mimes'    => ':attribute hanya boleh menggunakan file: :values.',
            
            // Override khusus untuk prodi karena rule different bawaan sedikit kaku
            'pilihan2.different' => 'Pilihan 2 tidak boleh sama dengan Pilihan 1.',
            'pilihan3.different' => 'Pilihan 3 tidak boleh sama dengan Pilihan 1 dan 2.',
            'pilihan4.different' => 'Pilihan 4 tidak boleh sama dengan pilihan sebelumnya.',
            
        ], [
            // --- 3. ALIAS NAMA FIELD (ATTRIBUTES) ---
            // Ubah nama field database menjadi nama yang enak dibaca (berpengaruh ke :attribute di atas)
            'nama' => 'Nama Lengkap',
            'jk' => 'Jenis Kelamin',
            'hp' => 'Nomor HP',
            'email' => 'Alamat Email',
            'tempat_lahir' => 'Tempat Lahir',
            'tanggal_lahir' => 'Tanggal Lahir',
            'alamat' => 'Alamat Lengkap',
            'kewarganegaraan' => 'Kewarganegaraan',
            'identitas_kewarganegaraan' => 'NIK (Nomor Induk Kependudukan)',
            'nama_ibu' => 'Nama Ibu Kandung',
            
            'nama_sekolah' => 'Nama Sekolah Asal',
            'jenis_sekolah' => 'Jenis Sekolah',
            'jurusan_sekolah' => 'Jurusan Sekolah',
            'tahun_lulus' => 'Tahun Lulus',
            'nisn' => 'NISN',
            'alamat_sekolah' => 'Alamat Sekolah',
            
            'jenjang_pendidikan' => 'Jenjang Pendidikan',
            'sistem_kuliah' => 'Sistem Kuliah',
            'jalur_masuk' => 'Jalur Pendaftaran',
            'pilihan1' => 'Prodi Pilihan 1',
            'pilihan2' => 'Prodi Pilihan 2',
            'pilihan3' => 'Prodi Pilihan 3',
            'pilihan4' => 'Prodi Pilihan 4',
            
            'pas_foto' => 'Pas Foto',
            'ijazah_skl' => 'Ijazah / SKL',
            'kk' => 'Kartu Keluarga',
            'ktp' => 'KTP',
            'akta' => 'Akta Kelahiran',
            'doc_pend_jalur_masuk' => 'Dokumen Pendukung',
        ]);

        DB::beginTransaction();

        try {
            // 2. Buat User Baru dengan Password "password" (Hardcode)
            // Default 'change_pw' di database biasanya 'belum', jadi nanti dashboard akan meminta ganti password setelah bayar
            $user = User::create([
                'name' => $request->nama,
                'email' => $request->email,
                'password' => Hash::make('password'), // Password Default
                'level' => 'camaba'
            ]);

            // 3. Simpan Data Register
            $register = Register::create([
                'user_id' => $user->id,
                'nama' => $request->nama,
                'jk' => $request->jk,
                'hp' => $request->hp,
                'email' => $request->email,
                'tempat_lahir' => $request->tempat_lahir,
                'tanggal_lahir' => $request->tanggal_lahir,
                'alamat' => $request->alamat,
                'kewarganegaraan' => $request->kewarganegaraan,
                'identitas_kewarganegaraan' => $request->identitas_kewarganegaraan,
                'jenjang_pendidikan_id' => $request->jenjang_pendidikan,
                'sistem_kuliah_id' => $request->sistem_kuliah,
                'jalur_masuk_id' => $request->jalur_masuk,
                'nama_sekolah' => $request->nama_sekolah,
                'jenis_sekolah' => $request->jenis_sekolah,
                'jurusan_sekolah' => $request->jurusan_sekolah,
                'tahun_lulus' => $request->tahun_lulus,
                'nisn' => $request->nisn,
                'nama_ibu' => $request->nama_ibu,
                'alamat_sekolah' => $request->alamat_sekolah,
                'pilihan1' => $request->pilihan1,
                'pilihan2' => $request->pilihan2,
                'pilihan3' => $request->pilihan3,
                'pilihan4' => $request->pilihan4,
                'pembayaran' => 'belum',
                'status_diterima' => 'belum ditentukan'
            ]);

            // 4. Upload Berkas
            $berkas = new BerkasPendaftar();
            $berkas->user_id = $user->id;
            $files = ['pas_foto', 'ijazah_skl', 'kk', 'ktp', 'akta', 'doc_pend_jalur_masuk'];
            
            foreach ($files as $field) {
                if ($request->hasFile($field)) {
                    $file = $request->file($field);
                    $filename = $field . "_" . str_replace(' ', '_', $request->nama) . "_" . time() . "." . $file->getClientOriginalExtension();
                    $berkas->{$field} = $filename;
                    $berkas->{$field . '_file'} = $file->storeAs('berkas', $filename);
                }
            }
            $berkas->save();

            // 5. Integrasi Tagihan
            $jalurMasuk = JalurMasuk::find($request->jalur_masuk);
            $tagihanData = [
                'jenis_tagihan' => 'Pendaftaran',
                'user' => $request->nama,
                'no_telp' => $request->hp,
                'email' => $request->email,
                'tanggal_tagihan' => Carbon::now()->format('Y-m-d'),
                'tanggal_jatuh_tempo' => Carbon::now()->addDays(3)->format('Y-m-d'),
                'nominal' => $jalurMasuk->biaya,
                'status' => 'PENDING',
                'penagih' => 'pmb',
                'keterangan' => 'Tagihan biaya pendaftaran ' . $jalurMasuk->nama,
            ];

            $tagihanResponse = null;
            $error_custom = null;

            try {
                $response = Http::withToken(env('API_TOKEN'))->post(env('API_ENDPOINT') . '/store-tagihan', $tagihanData);
                $responseBody = $response->json();
                
                if (isset($responseBody['success']) && $responseBody['success'] === true) {
                    $tagihanResponse = $responseBody;
                } else {
                    $error_custom = 'Gagal membuat tagihan otomatis. Silakan hubungi admin.';
                }
            } catch (\Exception $e) {
                $error_custom = 'Koneksi ke server pembayaran gagal.';
            }

            DB::commit();

            // 6. LOGIN OTOMATIS
            \Illuminate\Support\Facades\Auth::login($user);

            // 7. Simpan session tagihan & Redirect ke Dashboard
            session([
                'tagihan' => $tagihanResponse,
                'error_custom' => $error_custom,
                'message' => 'Pendaftaran Berhasil! Akun Anda telah aktif.'
            ]);

            return redirect()->route('dashboard');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['msg' => 'Terjadi kesalahan: ' . $e->getMessage()])->withInput();
        }
    }
}