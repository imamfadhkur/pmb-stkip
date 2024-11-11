<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Bank;
use App\Models\User;
use App\Models\Prodi;
use App\Models\Register;
use App\Models\JalurMasuk;
use App\Rules\ThreeDiffVal;
use App\Models\SistemKuliah;
use Illuminate\Http\Request;
use App\Models\BerkasPendaftar;
use App\Models\JalurMasukProdi;
use App\Models\JenjangPendidikan;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class PendaftaranController extends Controller
{
    public function jalurPendaftaran()
    {
        $jenjang_pendidikan = JenjangPendidikan::all();
        $sistem_kuliah = SistemKuliah::all();
        
        $jalur_masuk = JalurMasukProdi::select(
            'jalur_masuk_prodis.jalur_masuk_id',
            'jalur_masuks.id',
            'jalur_masuks.nama',
            'jalur_masuks.deskripsi',
            'jalur_masuks.biaya',
            'jalur_masuks.status'
        )
        ->join('jalur_masuks', 'jalur_masuk_prodis.jalur_masuk_id', '=', 'jalur_masuks.id')
        ->where('jalur_masuk_prodis.kuota', '>', 0)
        ->groupBy(
            'jalur_masuk_prodis.jalur_masuk_id',
            'jalur_masuks.id',
            'jalur_masuks.nama',
            'jalur_masuks.deskripsi',
            'jalur_masuks.biaya',
            'jalur_masuks.status'
        )
        ->get();

        return view('form_jalur_pendaftaran', [
            'jenjang_pendidikan' => $jenjang_pendidikan,
            'sistem_kuliah' => $sistem_kuliah,
            'jalur_masuk' => $jalur_masuk,
            'title' => 'Pendaftaran | jalur pendaftaran'
        ]);
    }

    public function dataDiri(Request $request)
    {
        $jenjang_pendidikan = $request->jenjang_pendidikan;
        $sistem_kuliah = $request->sistem_kuliah;
        $jalur_masuk = $request->jalur_masuk;

        return view('form_data_diri', [
            'jenjang_pendidikan' => $jenjang_pendidikan,
            'sistem_kuliah' => $sistem_kuliah,
            'jalur_masuk' => $jalur_masuk,
            'title' => 'Pendaftaran | data diri'
        ]);
    }

    public function asalSekolah(Request $request)
    {
        $jenjang_pendidikan = strip_tags($request->jenjang_pendidikan);
        $sistem_kuliah = strip_tags($request->sistem_kuliah);
        $jalur_masuk = strip_tags($request->jalur_masuk);
        $nama = strip_tags($request->nama);
        $jk = strip_tags($request->jk);
        $hp = strip_tags($request->hp);
        $email = strip_tags($request->email);
        $tempat_lahir = strip_tags($request->tempat_lahir);
        $tanggal_lahir = strip_tags($request->tanggal_lahir);
        $alamat = strip_tags($request->alamat);
        $kewarganegaraan = strip_tags($request->kewarganegaraan);
        $identitas_kewarganegaraan = strip_tags($request->identitas_kewarganegaraan);
        $nisn = strip_tags($request->nisn);
        $nama_ibu = strip_tags($request->nama_ibu);

        $validator = Validator::make($request->all(), [
            'nama' => 'required|max:255',
            'jk' => 'required',
            'hp' => 'required|numeric',
            'email' => 'required|email|unique:users,email',
            'tanggal_lahir' => 'required|date|before:today',
            'tempat_lahir' => 'required|max:64',
            'alamat' => 'required',
            'kewarganegaraan' => 'required',
            'identitas_kewarganegaraan' => 'required|numeric',
            'nisn' => 'required|numeric',
            'nama_ibu' => 'required'
        ]);

        if ($validator->fails()) {
            return redirect()->route('get-data-diri')->withErrors($validator)->withInput();
        }

        // Mengambil data yang telah divalidasi
        $validatedData = $validator->validated();

        $jenjang_pendidikan = strip_tags($request->jenjang_pendidikan);
        $sistem_kuliah = strip_tags($request->sistem_kuliah);
        $jalur_masuk = strip_tags($request->jalur_masuk);
        $nama = strip_tags($validatedData['nama']);
        $jk = strip_tags($validatedData['jk']);
        $hp = strip_tags($validatedData['hp']);
        $email = strip_tags($validatedData['email']);
        $tanggal_lahir = strip_tags($validatedData['tanggal_lahir']);
        $tempat_lahir = strip_tags($validatedData['tempat_lahir']);
        $alamat = strip_tags($validatedData['alamat']);
        $kewarganegaraan = strip_tags($validatedData['kewarganegaraan']);
        $identitas_kewarganegaraan = strip_tags($validatedData['identitas_kewarganegaraan']);
        $nisn = strip_tags($validatedData['nisn']);
        $nama_ibu = strip_tags($validatedData['nama_ibu']);

        return view('form_asal_sekolah', [
            'jenjang_pendidikan' => $jenjang_pendidikan,
            'sistem_kuliah' => $sistem_kuliah,
            'jalur_masuk' => $jalur_masuk,
            'nama' => $nama,
            'jk' => $jk,
            'hp' => $hp,
            'email' => $email,
            'tempat_lahir' => $tempat_lahir,
            'tanggal_lahir' => $tanggal_lahir,
            'alamat' => $alamat,
            'kewarganegaraan' => $kewarganegaraan,
            'identitas_kewarganegaraan' => $identitas_kewarganegaraan,
            'nisn' => $nisn,
            'nama_ibu' => $nama_ibu,
            'title' => 'Pendaftaran | asal sekolah'
        ]);
    }

    public function prodi(Request $request)
    {
        // dd($request);
        $validator = Validator::make($request->all(),[
            'nama_sekolah' => 'required|max:255',
            'jenis_sekolah' => 'required|max:255',
            'jurusan_sekolah' => 'required|max:255',
            'tahun_lulus' => 'required|date_format:Y|before_or_equal:now|after_or_equal:' . (date('Y')-100),
            'alamat_sekolah' => 'required'
        ]);

        $validatedData = $validator->validated();

        $jenjang_pendidikan = strip_tags($request->jenjang_pendidikan);
        $sistem_kuliah = strip_tags($request->sistem_kuliah);
        $jalur_masuk = strip_tags($request->jalur_masuk);
        $nama = strip_tags($request->nama);
        $jk = strip_tags($request->jk);
        $hp = strip_tags($request->hp);
        $email = strip_tags($request->email);
        $tempat_lahir = strip_tags($request->tempat_lahir);
        $tanggal_lahir = strip_tags($request->tanggal_lahir);
        $alamat = strip_tags($request->alamat);
        $kewarganegaraan = strip_tags($request->kewarganegaraan);
        $identitas_kewarganegaraan = strip_tags($request->identitas_kewarganegaraan);
        $nama_sekolah = strip_tags($validatedData['nama_sekolah']);
        $jenis_sekolah = strip_tags($validatedData['jenis_sekolah']);
        $jurusan_sekolah = strip_tags($validatedData['jurusan_sekolah']);
        $tahun_lulus = strip_tags($validatedData['tahun_lulus']);
        $alamat_sekolah = strip_tags($validatedData['alamat_sekolah']);
        $nisn = strip_tags($request->nisn);
        $nama_ibu = strip_tags($request->nama_ibu);

        if ($validator->fails()) {
            return view('form_asal_sekolah', [
                'jenjang_pendidikan' => $jenjang_pendidikan,
                'sistem_kuliah' => $sistem_kuliah,
                'jalur_masuk' => $jalur_masuk,
                'nama' => $nama,
                'jk' => $jk,
                'hp' => $hp,
                'email' => $email,
                'tempat_lahir' => $tempat_lahir,
                'tanggal_lahir' => $tanggal_lahir,
                'alamat' => $alamat,
                'kewarganegaraan' => $kewarganegaraan,
                'identitas_kewarganegaraan' => $identitas_kewarganegaraan,
                'nama_sekolah' => $nama_sekolah,
                'jenis_sekolah' => $jenis_sekolah,
                'jurusan_sekolah' => $jurusan_sekolah,
                'tahun_lulus' => $tahun_lulus,
                'nisn' => $nisn,
                'nama_ibu' => $nama_ibu,
                'alamat_sekolah' => $alamat_sekolah,
                'title' => 'Pendaftaran | asal sekolah'
            ])->withErrors($validator);
        }
        

        // $prodis = Prodi::where('sisa_kuota', '>', 0)->get();
        // $available = JalurMasukProdi::select('jalur_masuk_prodis.*', 'prodis.nama as prodi_name')
        //     ->join('prodis', 'jalur_masuk_prodis.prodi_id', '=', 'prodis.id')
        //     ->where('jalur_masuk_prodis.kuota', '>', 0)
        //     ->where('jalur_masuk_prodis.jalur_masuk_id', $jalurMasuk->id)
        //     ->get();
        
        $prodis = Prodi::select('prodis.*')
            ->join('jalur_masuk_prodis', 'prodis.id', '=', 'jalur_masuk_prodis.prodi_id')
            ->where('prodis.sisa_kuota', '>', 0)
            ->where('jalur_masuk_prodis.jalur_masuk_id', $jalur_masuk)
            ->where('jalur_masuk_prodis.kuota', '>', 0)
            ->get();

        return view('form_prodi', [
            'jenjang_pendidikan' => $jenjang_pendidikan,
            'sistem_kuliah' => $sistem_kuliah,
            'jalur_masuk' => $jalur_masuk,
            'nama' => $nama,
            'jk' => $jk,
            'hp' => $hp,
            'email' => $email,
            'tempat_lahir' => $tempat_lahir,
            'tanggal_lahir' => $tanggal_lahir,
            'alamat' => $alamat,
            'kewarganegaraan' => $kewarganegaraan,
            'identitas_kewarganegaraan' => $identitas_kewarganegaraan,
            'nama_sekolah' => $nama_sekolah,
            'jenis_sekolah' => $jenis_sekolah,
            'jurusan_sekolah' => $jurusan_sekolah,
            'tahun_lulus' => $tahun_lulus,
            'nisn' => $nisn,
            'nama_ibu' => $nama_ibu,
            'alamat_sekolah' => $alamat_sekolah,
            'prodis' => $prodis,
            'title' => 'Pendaftaran | prodi'
        ]);
    }

    public function berkas(Request $request)
    {
        $jenjang_pendidikan = strip_tags($request->jenjang_pendidikan);
        $sistem_kuliah = strip_tags($request->sistem_kuliah);
        $jalur_masuk = strip_tags($request->jalur_masuk);
        $nama = strip_tags($request->nama);
        $jk = strip_tags($request->jk);
        $hp = strip_tags($request->hp);
        $email = strip_tags($request->email);
        $tempat_lahir = strip_tags($request->tempat_lahir);
        $tanggal_lahir = strip_tags($request->tanggal_lahir);
        $alamat = strip_tags($request->alamat);
        $kewarganegaraan = strip_tags($request->kewarganegaraan);
        $identitas_kewarganegaraan = strip_tags($request->identitas_kewarganegaraan);
        $nama_sekolah = strip_tags($request->nama_sekolah);
        $jenis_sekolah = strip_tags($request->jenis_sekolah);
        $jurusan_sekolah = strip_tags($request->jurusan_sekolah);
        $tahun_lulus = strip_tags($request->tahun_lulus);
        $nisn = strip_tags($request->nisn);
        $nama_ibu = strip_tags($request->nama_ibu);
        $alamat_sekolah = strip_tags($request->alamat_sekolah);
        $pilihan1 = strip_tags($request->pilihan1);
        $pilihan2 = strip_tags($request->pilihan2);
        $pilihan3 = strip_tags($request->pilihan3);

        $errorProdi = 'salah';
        // if ($pilihan1 === $pilihan2 || $pilihan1 === $pilihan3 || $pilihan2 === $pilihan3) {
        //     $errorProdi = 'Pilihan prodi tidak boleh sama.';
        // }

        if ($errorProdi !== 'salah') {
            $prodis = Prodi::select('prodis.*')
            ->join('jalur_masuk_prodis', 'prodis.id', '=', 'jalur_masuk_prodis.prodi_id')
            ->where('prodis.sisa_kuota', '>', 0)
            ->where('jalur_masuk_prodis.jalur_masuk_id', $jalur_masuk)
            ->where('jalur_masuk_prodis.kuota', '>', 0)
            ->get();
            return view('form_prodi', [
                'jenjang_pendidikan' => $jenjang_pendidikan,
                'sistem_kuliah' => $sistem_kuliah,
                'jalur_masuk' => $jalur_masuk,
                'nama' => $nama,
                'jk' => $jk,
                'hp' => $hp,
                'email' => $email,
                'tempat_lahir' => $tempat_lahir,
                'tanggal_lahir' => $tanggal_lahir,
                'alamat' => $alamat,
                'kewarganegaraan' => $kewarganegaraan,
                'identitas_kewarganegaraan' => $identitas_kewarganegaraan,
                'nama_sekolah' => $nama_sekolah,
                'jenis_sekolah' => $jenis_sekolah,
                'jurusan_sekolah' => $jurusan_sekolah,
                'tahun_lulus' => $tahun_lulus,
                'nisn' => $nisn,
                'nama_ibu' => $nama_ibu,
                'alamat_sekolah' => $alamat_sekolah,
                'prodis' => $prodis,
                'title' => 'Pendaftaran | prodi'
            ])->with('errorProdi', 'Pilihan prodi tidak boleh sama.');
        }

        return view('form_berkas', [
            'jenjang_pendidikan' => $jenjang_pendidikan,
            'sistem_kuliah' => $sistem_kuliah,
            'jalur_masuk' => $jalur_masuk,
            'jalur_masuk_name' => JalurMasuk::where('id', $jalur_masuk)->first()->nama,
            'banks' => Bank::all(),
            'nama' => $nama,
            'jk' => $jk,
            'hp' => $hp,
            'email' => $email,
            'tempat_lahir' => $tempat_lahir,
            'tanggal_lahir' => $tanggal_lahir,
            'alamat' => $alamat,
            'kewarganegaraan' => $kewarganegaraan,
            'identitas_kewarganegaraan' => $identitas_kewarganegaraan,
            'nama_sekolah' => $nama_sekolah,
            'jenis_sekolah' => $jenis_sekolah,
            'jurusan_sekolah' => $jurusan_sekolah,
            'tahun_lulus' => $tahun_lulus,
            'nisn' => $nisn,
            'nama_ibu' => $nama_ibu,
            'alamat_sekolah' => $alamat_sekolah,
            'pilihan1' => $pilihan1,
            'pilihan2' => $pilihan2,
            'pilihan3' => $pilihan3,
            'title' => 'Pendaftaran | Pemberkasan'
        ]);
    }

    public function konfirmasi(Request $request)
    {
        $jenjang_pendidikan = strip_tags($request->jenjang_pendidikan);
        $sistem_kuliah = strip_tags($request->sistem_kuliah);
        $jalur_masuk = strip_tags($request->jalur_masuk);
        $nama = strip_tags($request->nama);
        $jk = strip_tags($request->jk);
        $hp = strip_tags($request->hp);
        $email = strip_tags($request->email);
        $tempat_lahir = strip_tags($request->tempat_lahir);
        $tanggal_lahir = strip_tags($request->tanggal_lahir);
        $alamat = strip_tags($request->alamat);
        $kewarganegaraan = strip_tags($request->kewarganegaraan);
        $identitas_kewarganegaraan = strip_tags($request->identitas_kewarganegaraan);
        $nama_sekolah = strip_tags($request->nama_sekolah);
        $jenis_sekolah = strip_tags($request->jenis_sekolah);
        $jurusan_sekolah = strip_tags($request->jurusan_sekolah);
        $tahun_lulus = strip_tags($request->tahun_lulus);
        $nisn = strip_tags($request->nisn);
        $nama_ibu = strip_tags($request->nama_ibu);
        $alamat_sekolah = strip_tags($request->alamat_sekolah);
        $pilihan1 = strip_tags($request->pilihan1);
        $pilihan2 = strip_tags($request->pilihan2);
        $pilihan3 = strip_tags($request->pilihan3);

        $errorProdi = 'salah';
        // if ($pilihan1 === $pilihan2 || $pilihan1 === $pilihan3 || $pilihan2 === $pilihan3) {
        //     $errorProdi = 'Pilihan prodi tidak boleh sama.';
        // }

        if ($errorProdi !== 'salah') {
            $prodis = Prodi::where('sisa_kuota', '>', 0)->get();
            return view('form_prodi', [
                'jenjang_pendidikan' => $jenjang_pendidikan,
                'sistem_kuliah' => $sistem_kuliah,
                'jalur_masuk' => $jalur_masuk,
                'banks' => Bank::all(),
                'nama' => $nama,
                'jk' => $jk,
                'hp' => $hp,
                'email' => $email,
                'tempat_lahir' => $tempat_lahir,
                'tanggal_lahir' => $tanggal_lahir,
                'alamat' => $alamat,
                'kewarganegaraan' => $kewarganegaraan,
                'identitas_kewarganegaraan' => $identitas_kewarganegaraan,
                'nama_sekolah' => $nama_sekolah,
                'jenis_sekolah' => $jenis_sekolah,
                'jurusan_sekolah' => $jurusan_sekolah,
                'tahun_lulus' => $tahun_lulus,
                'nisn' => $nisn,
                'nama_ibu' => $nama_ibu,
                'alamat_sekolah' => $alamat_sekolah,
                'prodis' => $prodis,
                'title' => 'Pendaftaran | prodi'
            ])->with('errorProdi', 'Pilihan prodi tidak boleh sama.');
        }

        return view('form_konfirmasi', [
            'jenjang_pendidikan' => $jenjang_pendidikan,
            'sistem_kuliah' => $sistem_kuliah,
            'jalur_masuk' => $jalur_masuk,
            'banks' => Bank::all(),
            'nama' => $nama,
            'jk' => $jk,
            'hp' => $hp,
            'email' => $email,
            'tempat_lahir' => $tempat_lahir,
            'tanggal_lahir' => $tanggal_lahir,
            'alamat' => $alamat,
            'kewarganegaraan' => $kewarganegaraan,
            'identitas_kewarganegaraan' => $identitas_kewarganegaraan,
            'nama_sekolah' => $nama_sekolah,
            'jenis_sekolah' => $jenis_sekolah,
            'jurusan_sekolah' => $jurusan_sekolah,
            'tahun_lulus' => $tahun_lulus,
            'nisn' => $nisn,
            'nama_ibu' => $nama_ibu,
            'alamat_sekolah' => $alamat_sekolah,
            'pilihan1' => $pilihan1,
            'pilihan2' => $pilihan2,
            'pilihan3' => $pilihan3,
            'title' => 'Pendaftaran | konfirmasi'
        ]);
    }

    public function daftar(Request $request)
    {
        $jenjang_pendidikan = strip_tags($request->jenjang_pendidikan);
        $sistem_kuliah = strip_tags($request->sistem_kuliah);
        $jalur_masuk = strip_tags($request->jalur_masuk);
        $nama = strip_tags($request->nama);
        $jk = strip_tags($request->jk);
        $hp = strip_tags($request->hp);
        $email = strip_tags($request->email);
        $tempat_lahir = strip_tags($request->tempat_lahir);
        $tanggal_lahir = strip_tags($request->tanggal_lahir);
        $alamat = strip_tags($request->alamat);
        $kewarganegaraan = strip_tags($request->kewarganegaraan);
        $identitas_kewarganegaraan = strip_tags($request->identitas_kewarganegaraan);
        $nama_sekolah = strip_tags($request->nama_sekolah);
        $jenis_sekolah = strip_tags($request->jenis_sekolah);
        $jurusan_sekolah = strip_tags($request->jurusan_sekolah);
        $tahun_lulus = strip_tags($request->tahun_lulus);
        $nisn = strip_tags($request->nisn);
        $nama_ibu = strip_tags($request->nama_ibu);
        $alamat_sekolah = strip_tags($request->alamat_sekolah);
        $pilihan1 = strip_tags($request->pilihan1);
        $pilihan2 = strip_tags($request->pilihan2);
        $pilihan3 = strip_tags($request->pilihan3);

        if ($request->type == 'edit') {
            return view('form_edit_konfirmasi', [
                'jenjang_pendidikan' => $jenjang_pendidikan,
                'sistem_kuliah' => $sistem_kuliah,
                'jalur_masuk' => $jalur_masuk,
                'banks' => Bank::all(),
                'nama' => $nama,
                'jk' => $jk,
                'hp' => $hp,
                'email' => $email,
                'tempat_lahir' => $tempat_lahir,
                'tanggal_lahir' => $tanggal_lahir,
                'alamat' => $alamat,
                'kewarganegaraan' => $kewarganegaraan,
                'identitas_kewarganegaraan' => $identitas_kewarganegaraan,
                'nama_sekolah' => $nama_sekolah,
                'jenis_sekolah' => $jenis_sekolah,
                'jurusan_sekolah' => $jurusan_sekolah,
                'tahun_lulus' => $tahun_lulus,
                'nisn' => $nisn,
                'nama_ibu' => $nama_ibu,
                'alamat_sekolah' => $alamat_sekolah,
                'pilihan1' => $pilihan1,
                'pilihan2' => $pilihan2,
                'pilihan3' => $pilihan3,
                'title' => 'Pendaftaran | konfirmasi 2'
            ]);
        }
        else {
            $validator = Validator::make($request->all(), [
                'nama' => 'required|max:255',
                'jk' => 'required',
                'hp' => 'required|numeric',
                'email' => 'required|email|unique:users,email',
                'tanggal_lahir' => 'required|date|before:today',
                'alamat' => 'required',
                'kewarganegaraan' => 'required',
                'identitas_kewarganegaraan' => 'required|numeric',
                'nama_sekolah' => 'required|max:255',
                'jenis_sekolah' => 'required|max:255',
                'jurusan_sekolah' => 'required|max:255',
                'tahun_lulus' => 'required|date_format:Y|before_or_equal:now|after_or_equal:' . (date('Y')-100),
                'nisn' => 'required|numeric',
                'nama_ibu' => 'required',
                'alamat_sekolah' => 'required',
                'pilihan1' => 'required|different:pilihan2,pilihan3',
                'pilihan2' => 'required|different:pilihan1,pilihan3',
                'pilihan3' => 'required|different:pilihan1,pilihan2',
                'pas_foto' => 'required|mimes:pdf,jpg,png|extensions:jpeg,png,jpg,pdf|max:1024', 
                'ijazah_skl' => 'required|mimes:pdf,jpg,png|extensions:jpeg,png,jpg,pdf|max:1024',
                // 'skhun' => 'required|mimes:pdf,jpg,png|extensions:jpeg,png,jpg,pdf|max:1024',
                'kk' => 'required|mimes:pdf,jpg,png|extensions:jpeg,png,jpg,pdf|max:1024',
                'ktp' => 'required|mimes:pdf,jpg,png|extensions:jpeg,png,jpg,pdf|max:1024',
                'akta' => 'required|mimes:pdf,jpg,png|extensions:jpeg,png,jpg,pdf|max:1024',
                'bukti_pembayaran' => 'required|image|mimes:pdf,jpg,png|extensions:jpeg,png,jpg,pdf|max:1024',
            ]);

            if ($validator->fails()) {
                // if ($validator->fails()) {
                //     dd($validator->messages());
                // }
                return view('form_berkas', [
                    'jenjang_pendidikan' => $jenjang_pendidikan,
                    'sistem_kuliah' => $sistem_kuliah,
                    'jalur_masuk' => $jalur_masuk,
                    'jalur_masuk_name' => JalurMasuk::where('id', $jalur_masuk)->first()->nama,
                    'banks' => Bank::all(),
                    'nama' => $nama,
                    'jk' => $jk,
                    'hp' => $hp,
                    'email' => $email,
                    'tempat_lahir' => $tempat_lahir,
                    'tanggal_lahir' => $tanggal_lahir,
                    'alamat' => $alamat,
                    'kewarganegaraan' => $kewarganegaraan,
                    'identitas_kewarganegaraan' => $identitas_kewarganegaraan,
                    'nama_sekolah' => $nama_sekolah,
                    'jenis_sekolah' => $jenis_sekolah,
                    'jurusan_sekolah' => $jurusan_sekolah,
                    'tahun_lulus' => $tahun_lulus,
                    'nisn' => $nisn,
                    'nama_ibu' => $nama_ibu,
                    'alamat_sekolah' => $alamat_sekolah,
                    'pilihan1' => $pilihan1,
                    'pilihan2' => $pilihan2,
                    'pilihan3' => $pilihan3,
                    'title' => 'Pendaftaran | konfirmasi berkas'
                ])->withErrors($validator);
            }
    
            $user = new User;
            $reg = new Register;
            $length = 5; // jumlah karakter yang diinginkan
            $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $randomString = substr(str_shuffle($characters), 0, $length);
            $user->name = $nama;
            $user->email = $email;
            $user->password = Hash::make($randomString);
            $user->level = 'camaba';
            $user->save();

            $user = User::where('email', $email)->first();
            $reg->user_id = $user->id;
            $reg->nama = $nama;
            $reg->jk = $jk;
            $reg->hp = $hp;
            $reg->email = $email;
            $reg->tempat_lahir = $tempat_lahir;
            $reg->tanggal_lahir = $tanggal_lahir;
            $reg->alamat = $alamat;
            $reg->kewarganegaraan = $kewarganegaraan;
            $reg->identitas_kewarganegaraan = $identitas_kewarganegaraan;
            $reg->jenjang_pendidikan_id = $jenjang_pendidikan;
            $reg->sistem_kuliah_id = $sistem_kuliah;
            $reg->jalur_masuk_id = $jalur_masuk;
            $reg->nama_sekolah = $nama_sekolah;
            $reg->jenis_sekolah = $jenis_sekolah;
            $reg->jurusan_sekolah = $jurusan_sekolah;
            $reg->tahun_lulus = $tahun_lulus;
            $reg->nisn = $nisn;
            $reg->nama_ibu = $nama_ibu;
            $reg->alamat_sekolah = $alamat_sekolah;
            $reg->pilihan1 = $pilihan1;
            $reg->pilihan2 = $pilihan2;
            $reg->pilihan3 = $pilihan3;
            $reg->bukti_pembayaran = $request->file('bukti_pembayaran')->store('bukti-pembayaran');
            $reg->save();

            $berkas = new BerkasPendaftar;
            $user_id = $user->id;
            if ($berkas::where('user_id',$user_id)->first()) {
                $berkas = $berkas::where('user_id',$user_id)->first();
            }
            $berkas->user_id = $user_id;
            foreach ($request->file() as $key => $file) {
                if ($request->hasFile($key) && $key !== 'bukti_pembayaran') {
                    $key_file = $key."_file";
                    if ($berkas->$key_file !== null) {
                        Storage::delete($berkas->$key_file);
                    }
                    $naming = $key."_".$nama."_".Carbon::now()->format('Ymd_His').".".$file->getClientOriginalExtension();
                    $berkas->$key = $naming;
                    $berkas->$key_file = $file->store('berkas');
                    $berkas->save();
                }
            }

            return view('auth.login', [
                'username' => $email,
                'password' => $randomString,
                'title' => 'Pendaftaran | daftar'
            ]);
        }
    }
}
