<?php

namespace App\Http\Controllers;

use App\Models\JalurMasuk;
use App\Models\JenjangPendidikan;
use App\Models\Prodi;
use App\Models\Register;
use App\Models\SistemKuliah;
use App\Models\User;
use App\Rules\ThreeDiffVal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class PendaftaranController extends Controller
{
    public function jalurPendaftaran()
    {
        $jenjang_pendidikan = JenjangPendidikan::all();
        $sistem_kuliah = SistemKuliah::all();
        $jalur_masuk = JalurMasuk::aktif()->get();

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
        $jenjang_pendidikan = $request->jenjang_pendidikan;
        $sistem_kuliah = $request->sistem_kuliah;
        $jalur_masuk = $request->jalur_masuk;
        $nama = $request->nama;
        $jk = $request->jk;
        $hp = $request->hp;
        $email = $request->email;
        $tempat_lahir = $request->tempat_lahir;
        $tanggal_lahir = $request->tanggal_lahir;
        $alamat = $request->alamat;
        $kewarganegaraan = $request->kewarganegaraan;
        $identitas_kewarganegaraan = $request->identitas_kewarganegaraan;

        $validator = Validator::make($request->all(), [
            'nama' => 'required|max:255',
            'jk' => 'required',
            'hp' => 'required|numeric',
            'email' => 'required|email|unique:users,email',
            'tanggal_lahir' => 'required|date|before:today',
            'alamat' => 'required',
            'kewarganegaraan' => 'required',
            'identitas_kewarganegaraan' => 'required|numeric'
        ]);

        if ($validator->fails()) {
            return redirect()->route('get-data-diri')->withErrors($validator)->withInput();
        }

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
            'title' => 'Pendaftaran | asal sekolah'
        ]);
    }

    public function prodi(Request $request)
    {
        // dd($request);
        $jenjang_pendidikan = $request->jenjang_pendidikan;
        $sistem_kuliah = $request->sistem_kuliah;
        $jalur_masuk = $request->jalur_masuk;
        $nama = $request->nama;
        $jk = $request->jk;
        $hp = $request->hp;
        $email = $request->email;
        $tempat_lahir = $request->tempat_lahir;
        $tanggal_lahir = $request->tanggal_lahir;
        $alamat = $request->alamat;
        $kewarganegaraan = $request->kewarganegaraan;
        $identitas_kewarganegaraan = $request->identitas_kewarganegaraan;
        $nama_sekolah = $request->nama_sekolah;
        $jenis_sekolah = $request->jenis_sekolah;
        $jurusan_sekolah = $request->jurusan_sekolah;
        $tahun_lulus = $request->tahun_lulus;
        $alamat_sekolah = $request->alamat_sekolah;

        $validator = Validator::make($request->all(),[
            'nama_sekolah' => 'required|max:255',
            'jenis_sekolah' => 'required|max:255',
            'jurusan_sekolah' => 'required|max:255',
            'tahun_lulus' => 'required|date_format:Y|before_or_equal:now|after_or_equal:' . (date('Y')-100),
            'alamat_sekolah' => 'required'
        ]);

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
                'alamat_sekolah' => $alamat_sekolah,
                'title' => 'Pendaftaran | asal sekolah'
            ])->withErrors($validator);
        }
        

        $prodis = Prodi::all();

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
            'alamat_sekolah' => $alamat_sekolah,
            'prodis' => $prodis,
            'title' => 'Pendaftaran | prodi'
        ]);
    }

    public function konfirmasi(Request $request)
    {
        $jenjang_pendidikan = $request->jenjang_pendidikan;
        $sistem_kuliah = $request->sistem_kuliah;
        $jalur_masuk = $request->jalur_masuk;
        $nama = $request->nama;
        $jk = $request->jk;
        $hp = $request->hp;
        $email = $request->email;
        $tempat_lahir = $request->tempat_lahir;
        $tanggal_lahir = $request->tanggal_lahir;
        $alamat = $request->alamat;
        $kewarganegaraan = $request->kewarganegaraan;
        $identitas_kewarganegaraan = $request->identitas_kewarganegaraan;
        $nama_sekolah = $request->nama_sekolah;
        $jenis_sekolah = $request->jenis_sekolah;
        $jurusan_sekolah = $request->jurusan_sekolah;
        $tahun_lulus = $request->tahun_lulus;
        $alamat_sekolah = $request->alamat_sekolah;
        $pilihan1 = $request->pilihan1;
        $pilihan2 = $request->pilihan2;
        $pilihan3 = $request->pilihan3;

        $errorProdi = 'salah';
        if ($pilihan1 === $pilihan2 || $pilihan1 === $pilihan3 || $pilihan2 === $pilihan3) {
            $errorProdi = 'Pilihan prodi tidak boleh sama.';
        }

        if ($errorProdi !== 'salah') {
            $prodis = Prodi::all();
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
                'alamat_sekolah' => $alamat_sekolah,
                'prodis' => $prodis,
                'title' => 'Pendaftaran | prodi'
            ])->with('errorProdi', 'Pilihan prodi tidak boleh sama.');
        }

        return view('form_konfirmasi', [
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
            'alamat_sekolah' => $alamat_sekolah,
            'pilihan1' => $pilihan1,
            'pilihan2' => $pilihan2,
            'pilihan3' => $pilihan3,
            'title' => 'Pendaftaran | konfirmasi'
        ]);
    }

    public function daftar(Request $request)
    {
        $jenjang_pendidikan = $request->jenjang_pendidikan;
        $sistem_kuliah = $request->sistem_kuliah;
        $jalur_masuk = $request->jalur_masuk;
        $nama = $request->nama;
        $jk = $request->jk;
        $hp = $request->hp;
        $email = $request->email;
        $tempat_lahir = $request->tempat_lahir;
        $tanggal_lahir = $request->tanggal_lahir;
        $alamat = $request->alamat;
        $kewarganegaraan = $request->kewarganegaraan;
        $identitas_kewarganegaraan = $request->identitas_kewarganegaraan;
        $nama_sekolah = $request->nama_sekolah;
        $jenis_sekolah = $request->jenis_sekolah;
        $jurusan_sekolah = $request->jurusan_sekolah;
        $tahun_lulus = $request->tahun_lulus;
        $alamat_sekolah = $request->alamat_sekolah;
        $pilihan1 = $request->pilihan1;
        $pilihan2 = $request->pilihan2;
        $pilihan3 = $request->pilihan3;

        if ($request->type == 'edit') {
            return view('form_edit_konfirmasi', [
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
                'alamat_sekolah' => 'required',
                'pilihan1' => 'required|different:pilihan2,pilihan3',
                'pilihan2' => 'required|different:pilihan1,pilihan3',
                'pilihan3' => 'required|different:pilihan1,pilihan2',
            ]);

            if ($validator->fails()) {
                // if ($validator->fails()) {
                //     dd($validator->messages());
                // }
                return view('form_edit_konfirmasi', [
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
                    'alamat_sekolah' => $alamat_sekolah,
                    'pilihan1' => $pilihan1,
                    'pilihan2' => $pilihan2,
                    'pilihan3' => $pilihan3,
                    'title' => 'Pendaftaran | konfirmasi 3'
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
            $reg->alamat_sekolah = $alamat_sekolah;
            $reg->pilihan1 = $pilihan1;
            $reg->pilihan2 = $pilihan2;
            $reg->pilihan3 = $pilihan3;
            $reg->save();

            $data = array(
                'username' => $email,
                'password' => $randomString,
            );
            return view('auth.login', [
                'username' => $email,
                'password' => $randomString,
                'title' => 'Pendaftaran | daftar'
            ]);
        }
    }
}
