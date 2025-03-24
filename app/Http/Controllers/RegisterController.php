<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Prodi;
use App\Models\Register;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Models\BerkasPendaftar;
use App\Models\JalurMasukProdi;
use Illuminate\Validation\Rule;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Http;

class RegisterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $request->validate([
            'search' => 'nullable|string|max:255',
            'sort' => 'nullable|in:created_at,nama,nama_sekolah,pembayaran',
            'ascdesc' => 'nullable|in:ASC,DESC',
        ]);
        
        $query = Register::query();
    
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', '%' . $search . '%')
                  ->orWhere('nama_sekolah', 'like', '%' . $search . '%');
            });
        }
    
        $registers = $query->orderBy($request->get('sort', 'created_at'), $request->get('ascdesc', 'DESC'))
                           ->paginate(50);
    
        try {
            $response = Http::withToken(env('API_TOKEN'))->get(env('API_ENDPOINT').'/tahun_ajaran');
            if(!$response->ok() || is_null($response->json())){
            throw new \Exception('Gagal mengambil data tahun angkatan: ' . strip_tags($response->body()));
            }
            $tahunAjarans = $response->json();
        } catch (\Exception $e) {
            session()->flash('error_custom', $e->getMessage());
            $tahunAjarans = null;
        }

        return view('dashboard.pendaftar.index', [
            'registers' => $registers,
            'title' => 'register',
            'tahun_ajarans' => $tahunAjarans,
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
        $nama_ibu = $request->nama_ibu;
        $nisn = $request->nisn;
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
            'nama_ibu' => 'required',
            'nisn' => 'required|numeric',
            'pilihan1' => 'required',
            'pilihan2' => 'required',
            'pilihan3' => 'required',
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
        $reg->nama_ibu = $nama_ibu;
        $reg->nisn = $nisn;
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
            'berkas' => BerkasPendaftar::where('user_id', $reg->user_id)->first(),
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
            'berkas' => BerkasPendaftar::where('user_id', $reg->user_id)->first(),
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
            'nama_ibu' => 'required',
            'nisn' => 'required|numeric',
            'alamat_sekolah' => 'required',
            'pilihan1' => 'required',
            'pilihan2' => 'required',
            'pilihan3' => 'required',
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

        $berkas = new BerkasPendaftar;
        if ($berkas::where('user_id',$register->user_id)->first()) {
            $berkas = $berkas::where('user_id',$register->user_id)->first();
        }
        $berkas->user_id = $register->user_id;
        foreach ($request->file() as $key => $file) {
            if ($request->hasFile('bukti_pembayaran')) {
                # code...
            } else {
                $key_file = $key."_file";
                if ($berkas->$key_file !== null) {
                    Storage::delete($berkas->$key_file);
                }
                $berkas->$key = $file->getClientOriginalName();
                $berkas->$key_file = $file->store('berkas');
                $berkas->save();
            }
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
        
        // $response = Http::withToken($this->apiToken)->post($this->url.'/insert-mahasiswa', $request->all());

        $register = Register::where('id', '=', $request->regist_id)->first();
        $validatedData = $request->validate(['diterima_di' => 'required']);
        $register->diterima_di = $request->input('diterima_di');
        $register->status_diterima = "diterima";
        $register->save();
        $registers = Register::paginate(10);

        // buat update ke tabel jalur_masuk_prodis untuk mengurangi jumlah kuota berdasar prodi yang diterima
        $jmp = JalurMasukProdi::where('jalur_masuk_id', $register->jalur_masuk_id)->where('prodi_id', $register->diterima_di)->first();
        $jmp->update(['kuota' => $jmp->kuota - 1]);
        $jmp->save();

        return redirect()->route('register.index')->with([
        'registers' => $registers,
        'title' => 'register',
        'success_data_diterima' => 'Update berhasil, '.$register->nama.' diterima di prodi '.$register->diterimadi->nama,
        ]);
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
        if ($register->diterima_di !== null)
        {
            $jmp = JalurMasukProdi::where('jalur_masuk_id', $register->jalur_masuk_id)->where('prodi_id', $register->diterima_di)->first();
            $kuo = $jmp->kuota;
            $jmp->kuota = $kuo + 1;
            $jmp->save();
        }
        if ($register->bukti_pembayaran) {
            Storage::delete($register->bukti_pembayaran);
        }
        if (BerkasPendaftar::where('user_id', $register->user_id)->first()) {
            $berkas = BerkasPendaftar::where('user_id', $register->user_id)->first();
            if ($berkas->ijazah_skl_file) {
                Storage::delete($berkas->ijazah_skl_file);
            }
            if ($berkas->skhun_file) {
                Storage::delete($berkas->skhun_file);
            }
            if ($berkas->akta_file) {
                Storage::delete($berkas->akta_file);
            }
            if ($berkas->kk_file) {
                Storage::delete($berkas->kk_file);
            }
            if ($berkas->ktp_file) {
                Storage::delete($berkas->ktp_file);
            }
            if ($berkas->pas_foto_file) {
                Storage::delete($berkas->pas_foto_file);
            }
            if ($berkas->doc_pend_jalur_masuk_file) {
                Storage::delete($berkas->doc_pend_jalur_masuk_file);
            }
            $berkas->delete();
        }
        $register->delete();
        
        return redirect('/register')->with('messageSuccess', 'Data berhasil dihapus');
    }

    public function export()
    {
        // dd('here');
        $collections = Register::all();
        $filename = 'data_camaba.csv';

        // Menyiapkan header respons
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="'.$filename.'"',
        ];

        // Menggunakan callback untuk menulis data ke output
        $callback = function() use ($collections) {
            $output = fopen('php://output', 'w');
            
            // Menulis header CSV
            fputcsv($output, ['no', 'nama', 'jenis kelamin', 'hp', 'email', 'tempat tanggal lahir', 'alamat', 'kewarganegaraan',  'nik', 'nama ibu', 'jenjang pendidikan', 'sistem kuliah', 'jalur masuk', 'asal sekolah', 'jenis sekolah', 'jurusan', 'tahun lulus', 'nisn', 'alamat sekolah', 'pilihan 1', 'pilihan 2', 'pilihan 3', 'pembayaran', 'status di terima', 'periode pendaftaran'], ';');
            
            // Menulis data ke CSV
            foreach ($collections as $index => $item) {
                fputcsv($output, [
                    $index + 1,
                    $item->nama,
                    $item->jk,
                    $item->hp."\t",
                    $item->email,
                    $item->tempat_lahir.', '.Carbon::parse($item->tanggal_lahir)->format('d-m-Y'),
                    $item->alamat,
                    $item->kewarganegaraan,
                    $item->identitas_kewarganegaraan."\t",
                    $item->nama_ibu,
                    $item->jenjangPendidikan->nama,
                    $item->sistemKuliah->nama,
                    $item->jalurMasuk->nama,
                    $item->nama_sekolah,
                    $item->jenis_sekolah,
                    $item->jurusan_sekolah,
                    $item->tahun_lulus,
                    $item->nisn."\t",
                    $item->alamat_sekolah,
                    $item->pilihan1Prodi->nama,
                    $item->pilihan2Prodi->nama,
                    $item->pilihan3Prodi->nama,
                    $item->pembayaran,
                    ($item->status_diterima == 'diterima') ? 'diterima di '.$item->diterimadi->nama : $item->status_diterima,
                    $item->created_at->format('Y'),
                ], ';');
            }

            fclose($output);
        };

        // Mengirimkan response dengan headers yang benar dan output CSV
        return Response::stream($callback, 200, $headers);
    }

    public function search(Request $request)
    {
        $search = trim($request->search);

        if (empty($search)) {
            $registers = Register::take(5)->get();
        } else {
            $registers = Register::where('nama', 'like', "%{$search}%")
                ->orWhere('alamat', 'like', "%{$search}%")
                ->orWhere('nama_sekolah', 'like', "%{$search}%")
                ->orWhereHas('diterimadi', function ($query) use ($search) {
                    $query->where('nama', 'like', "%{$search}%");
                })
                ->get();
        }

        $output = '';

        $output .= '
        <thead class="table-dark">
            <tr>
            <th>No.</th>
            <th>Nama</th>
            <th>Alamat</th>
            <th>Asal Sekolah</th>
            <th>Jalur Masuk</th>
            <th>Bukti Pembayaran</th>
            <th>Status Pembayaran</th>
            <th>Status Diterima</th>
            <th>Action</th>
            </tr>
        </thead>
        <tbody>';
        
        if ($registers->isNotEmpty()) {
            foreach ($registers as $key => $register) {
            $output .= '
            <tr>
            <td>' . ($key + 1) . '.</td>
            <td>' . $register->nama . ' (' . $register->jk . ')</td>
            <td>' . $register->alamat . '</td>
            <td>' . $register->nama_sekolah . '</td>
            <td>' . $register->jalurMasuk->nama . '</td>
            <td>';
            if ($register->bukti_pembayaran) {
            $output .= '<a class="test-popup-link" href="' . asset('storage/' . $register->bukti_pembayaran) . '">
                <img src="' . asset('storage/' . $register->bukti_pembayaran) . '" class="rounded w-50" style="max-height: 50px;">
                </a>';
            } else {
            $output .= '<p class="text-danger"><b>belum upload</b></p>';
            }
            $output .= '</td>
            <td>' . ($register->pembayaran === "belum" ? 'Belum Terverifikasi' : 'Sudah') . '</td>
            <td>';
            if ($register->status_diterima === "diterima") {
            $output .= '<p><b class="text-success">' . $register->status_diterima . '</b> - ' . ($register->diterima_di !== null ? $register->diterimadi->nama : '(prodi belum ditentukan)') . '</p>';
            } else {
            $output .= '<p class="text-danger"><b>' . $register->status_diterima . '</b></p>';
            }
            $output .= '</td>
            <td>
                <a class="btn btn-warning btn-sm" href="' . route('register.show', $register->email) . '"><i class="bi bi-eye"></i></a>
            </td>
            </tr>';
            }
        } else {
            $output .= '<tr><td colspan="9" class="text-center text-muted">Tidak ada data ditemukan.</td></tr>';
        }
        $output .= '</tbody>';
        $output .= '<tfoot>
            <tr>
            <td colspan="9" class="text-center">
                <button class="btn btn-primary" onclick="location.reload();">Refresh</button>
            </td>
            </tr>
        </tfoot>';

        return response($output);
    }

    public function insert_mahasiswa(Request $request)
    {
        $request->validate([
            'tahun_ajaran_id' => 'required|integer',
        ]);

        $tahunAjaranId = $request->input('tahun_ajaran_id');
        $registers = Register::where('status_diterima', 'diterima')->get();
        
        if ($registers->isNotEmpty()) {
            $mhs_success = 0;
            foreach ($registers as $register) 
            {
                $data = [
                    'name' => $register->nama,
                    'role' => 'mahasiswa',
                    'tahun_ajaran_id' => $tahunAjaranId,
                    'jenis_kelamin' => $register->jk,
                    'tempat_lahir' => $register->tempat_lahir,
                    'tanggal_lahir' => $register->tanggal_lahir,
                    'alamat' => $register->alamat,
                    'kewarganegaraan' => $register->kewarganegaraan,
                    'nik' => $register->identitas_kewarganegaraan,
                    'nisn' => $register->nisn,
                    'nama_ibu' => $register->nama_ibu,
                    'prodi_name' => $register->diterimadi->nama,
                    'tanggal_daftar' => $register->created_at->toDateString(),
                    'nama_jalur_masuk' => $register->jalurMasuk->nama,
                ];
            
                $response = Http::withToken(env('API_TOKEN'))->post(env('API_ENDPOINT').'/insert-mahasiswa', $data);
            
                if ($response->json()['message'] === 'Validasi gagal') {
                    $errors = $response->json('errors'); // Ambil bagian 'errors' dari response
                    $message = $response->json('message'); // Ambil bagian 'message' dari response
                    return redirect()->back()->withErrors($errors)->with('success', $mhs_success.' mahasiswa berhasil ditambahkan. Hapus '.$mhs_success.' data ini apabila ingin menambahkan ulang.')->with('error_custom', 'Data maba '.$register->nama.' tidak bisa ditambahkan, error: '.$message);
                }
                $mhs_success++;
            }
            return redirect()->route('register.index')->with('messageSuccess', 'Data mahasiswa baru berhasil ditambahkan ke SIAKAD');
        } else {
            return redirect()->route('register.index')->with('error_custom', 'Tidak ada data yang dikirim.');
        }
    }

    public function delete_all()
    {
        $registers = Register::all();
        foreach ($registers as $register) {
            if ($register->diterima_di !== null) {
            $jmp = JalurMasukProdi::where('jalur_masuk_id', $register->jalur_masuk_id)->where('prodi_id', $register->diterima_di)->first();
            $kuo = $jmp->kuota;
            $jmp->kuota = $kuo + 1;
            $jmp->save();
            }
            if ($register->bukti_pembayaran) {
            Storage::delete($register->bukti_pembayaran);
            }
            if (BerkasPendaftar::where('user_id', $register->user_id)->first()) {
            $berkas = BerkasPendaftar::where('user_id', $register->user_id)->first();
            if ($berkas->ijazah_skl_file) {
                Storage::delete($berkas->ijazah_skl_file);
            }
            if ($berkas->skhun_file) {
                Storage::delete($berkas->skhun_file);
            }
            if ($berkas->akta_file) {
                Storage::delete($berkas->akta_file);
            }
            if ($berkas->kk_file) {
                Storage::delete($berkas->kk_file);
            }
            if ($berkas->ktp_file) {
                Storage::delete($berkas->ktp_file);
            }
            if ($berkas->pas_foto_file) {
                Storage::delete($berkas->pas_foto_file);
            }
            if ($berkas->doc_pend_jalur_masuk_file) {
                Storage::delete($berkas->doc_pend_jalur_masuk_file);
            }
            $berkas->delete();
            }
            $user_id = $register->user_id;
            $register->delete();
            User::where('id', $user_id)->delete();
        }
        return redirect()->route('register.index')->with('messageSuccess', 'Data pendaftar berhasil dihapus');
    }
}
