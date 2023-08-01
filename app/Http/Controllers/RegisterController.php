<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Prodi;
use App\Models\Register;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $registers = Register::paginate(10);
        return view('dashboard.pendaftar.index', [
            'registers' => $registers,
            'title' => 'register'
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.pendaftar.create',[
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
        $password = bcrypt($request->password);
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

        $user = new User;
        $reg = new Register;
        $length = 5; // jumlah karakter yang diinginkan
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randomString = substr(str_shuffle($characters), 0, $length);
        $user->name = $nama;
        $user->email = $email;
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
    public function show($register)
    {
        $reg = Register::where('email', $register)->firstOrFail();
        return view('dashboard.pendaftar.show', [
            'title' => 'Lihat Data'.$reg->nama,
            'register' => $reg,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($register)
    {
        $reg = Register::where('email', $register)->firstOrFail();
        return view('dashboard.pendaftar.edit', [
            'title' => 'Lihat Data'.$reg->nama,
            'register' => $reg,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Register $register)
    {
        $register->update($request->validate([
            'nama' => 'required|max:255',
            'jk' => 'required',
            'hp' => 'required|numeric',
            'email' => 'required|email|unique:users,email,'.$register->user_id,
            'tanggal_lahir' => 'required|date|before:today',
            'alamat' => 'required',
            'kewarganegaraan' => 'required',
            'identitas_kewarganegaraan' => 'required|numeric',
            'jenjang_pendidikan_id' => 'required',
            'sistem_kuliah_id' => 'required',
            'jalur_masuk_id' => 'required',
            'nama_sekolah' => 'required|max:255',
            'jenis_sekolah' => 'required|max:255',
            'jurusan_sekolah' => 'required|max:255',
            'tahun_lulus' => 'required|date_format:Y|before_or_equal:now|after_or_equal:' . (date('Y')-100),
            'alamat_sekolah' => 'required',
            'pilihan1' => 'required|different:pilihan2,pilihan3',
            'pilihan2' => 'required|different:pilihan1,pilihan3',
            'pilihan3' => 'required|different:pilihan1,pilihan2',
            'pembayaran' => ['required', Rule::in(['sudah', 'belum'])],
            'status_diterima' => ['required', Rule::in(['diterima', 'tidak diterima'])],
        ]));
        
        if ($request->hasFile('bukti_pembayaran')) {
            // Menghapus gambar lama
            if ($register->bukti_pembayaran) {
                Storage::delete($register->bukti_pembayaran);
            }
            // Menyimpan gambar baru
            $va = $request->file('bukti_pembayaran')->store('bukti-pembayaran');
            $register->update(['bukti_pembayaran' => $va]);
        }

        return redirect()->route('register.index')->with('messageSuccess', 'Pendaftar berhasil diedit');
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
    
    public function ubahPenerimaan(Request $request)
    {
        // dd($request);
        $register_id = $request->regist_id;
        Register::where('id', '=', $register_id)->update(['status_diterima' => 'diterima']);

        return redirect('/register')->with('messageSuccess', 'Data berhasil dirubah');
    }

    public function uploadPembayaran(Request $request)
    {
        $validatedData = $request->validate([
            'bukti_pembayaran' => 'image|mimes:jpg,png|max:5024'
        ]);
        $validatedData['bukti_pembayaran'] = $request->file('bukti_pembayaran')->store('bukti-pembayaran');
        
        $register_user_id = Auth::user()->id;
        Register::where('user_id', '=', $register_user_id)->update(['bukti_pembayaran' => $validatedData['bukti_pembayaran']]);

        return redirect('/dashboard');
    }

    public function sort(Request $request)
    {
        $registers = Register::orderBy($request->query('sort'), $request->query('ascdesc'))->paginate(17);
        $registers->appends($request->query());
        return view('dashboard.pendaftar.index', [
            'registers' => $registers,
            'title' => 'register'
        ]);
    }

    public function hapus($id)
    {
        $register = Register::findOrFail($id);
        $register->delete();
        
        return redirect('/register')->with('messageSuccess', 'Data berhasil dihapus');
    }
}
