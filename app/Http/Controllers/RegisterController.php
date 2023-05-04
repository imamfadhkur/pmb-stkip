<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Prodi;
use App\Models\Register;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $registers = Register::paginate(10);
        return view('dashboard.admin.index', [
            'registers' => $registers,
            'title' => 'register'
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.admin.create',[
            'title' => 'create camaba',

        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request);
        $jenjang_pendidikan = $request->jenjang_pendidikan;
        $sistem_kuliah = $request->sistem_kuliah;
        $jalur_masuk = $request->jalur_masuk;
        $nama = $request->nama;
        $jk = $request->jk;
        $hp = $request->hp;
        $email = $request->email;
        $password = $request->password;
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
        
        $validator = $request->validate([
            'nama' => 'required|max:255',
            'jk' => 'required',
            'hp' => 'required|numeric',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:5',
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

        // $errorProdi = 'salah';
        // if ($request->pilihan1 === $request->pilihan2 || $request->pilihan1 === $request->pilihan3 || $request->pilihan2 === $request->pilihan3) {
        //     $errorProdi = 'Pilihan prodi tidak boleh sama.';
        // }

        // if ($errorProdi !== 'salah') {
        //     $prodis = Prodi::all();
        //     return view('form_edit_konfirmasi', [
        //         'jenjang_pendidikan' => $jenjang_pendidikan,
        //         'sistem_kuliah' => $sistem_kuliah,
        //         'jalur_masuk' => $jalur_masuk,
        //         'nama' => $nama,
        //         'jk' => $jk,
        //         'hp' => $hp,
        //         'email' => $email,
        //         'password' => $password,
        //         'tempat_lahir' => $tempat_lahir,
        //         'tanggal_lahir' => $tanggal_lahir,
        //         'alamat' => $alamat,
        //         'kewarganegaraan' => $kewarganegaraan,
        //         'identitas_kewarganegaraan' => $identitas_kewarganegaraan,
        //         'nama_sekolah' => $nama_sekolah,
        //         'jenis_sekolah' => $jenis_sekolah,
        //         'jurusan_sekolah' => $jurusan_sekolah,
        //         'tahun_lulus' => $tahun_lulus,
        //         'alamat_sekolah' => $alamat_sekolah,
        //         'pilihan1' => $request->pilihan1,
        //         'pilihan2' => $request->pilihan2,
        //         'pilihan3' => $request->pilihan3,
        //         'prodis' => $prodis,
        //         'title' => 'Pendaftaran | konfirmasi'
        //     ])->with('errorProdi', 'Pilihan prodi tidak boleh sama.');
        // }

        $user = new User;
        $reg = new Register;
        $length = 5; // jumlah karakter yang diinginkan
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randomString = substr(str_shuffle($characters), 0, $length);
        $user->name = $nama;
        $user->email = $email;
        // $user->password = Hash::make($randomString);
        $user->password = $password;
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
        return redirect()->route('register.index')->with('messageSuccess', 'Pendaftar berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(Register $register)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Register $register)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Register $register)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Register $register)
    {
        //
    }

    public function ubahPembayaran(Request $request)
    {
        // dd($request);
        $register_id = $request->regist_id;
        Register::where('id', '=', $register_id)->update(['pembayaran' => 'sudah']);

        return redirect('/register')->with('messageSuccess', 'Data berhasil dirubah');
    }

    public function uploadPembayaran(Request $request)
    {
        $validatedData = $request->validate([
            'bukti_pembayaran' => 'image|mimes:jpg,png|max:3024'
        ]);
        $validatedData['bukti_pembayaran'] = $request->file('bukti_pembayaran')->store('bukti-pembayaran');
        
        $register_user_id = Auth::user()->id;
        Register::where('user_id', '=', $register_user_id)->update(['bukti_pembayaran' => $validatedData['bukti_pembayaran']]);

        return redirect('/dashboard');
    }

    public function sort(Request $request)
    {
        // dd($request);
        $registers = Register::orderBy($request->sort, $request->ascdesc)->paginate(7);
        return view('dashboard.admin.index', [
            'registers' => $registers,
            'title' => 'register'
        ]);
    }

    public function hapus(Request $request, $id)
    {
        $register = Register::findOrFail($id);
        $register->delete();
        $user = User::findOrFail($id);
        $user->delete();
        
        return redirect('/register')->with('messageSuccess', 'Data berhasil dihapus');
    }
}
