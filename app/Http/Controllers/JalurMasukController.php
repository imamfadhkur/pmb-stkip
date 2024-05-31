<?php

namespace App\Http\Controllers;

use App\Models\JalurMasukProdi;
use App\Models\Prodi;
use App\Models\JalurMasuk;
use Illuminate\Http\Request;

class JalurMasukController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $jalurMasuks = JalurMasuk::select(
            'jalur_masuks.id',
            'jalur_masuks.nama',
            'jalur_masuks.deskripsi',
            'jalur_masuks.biaya',
            'jalur_masuks.jumlah_pendaftar',
            'jalur_masuks.status',
            \DB::raw('COUNT(CASE WHEN jalur_masuk_prodis.kuota > 0 THEN 1 END) as available'),
            \DB::raw('COUNT(CASE WHEN jalur_masuk_prodis.kuota <= 0 THEN 1 END) as unavailable')
        )
        ->leftJoin('jalur_masuk_prodis', 'jalur_masuks.id', '=', 'jalur_masuk_prodis.jalur_masuk_id')
        ->groupBy(
            'jalur_masuks.id',
            'jalur_masuks.nama',
            'jalur_masuks.deskripsi',
            'jalur_masuks.biaya',
            'jalur_masuks.jumlah_pendaftar',
            'jalur_masuks.status'
        )
        ->paginate(10);

        return view('dashboard.jalur_masuk.index', [
            'jalurMasuks' => $jalurMasuks,
            'title' => 'jalur masuk'
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.jalur_masuk.create',['title' => 'create jalur masuk', 'prodis' => Prodi::all()]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = request()->all();
        // Aturan validasi dasar
        $rules = [
            'nama' => 'required|max:255',
            'deskripsi' => 'nullable|string',
            'biaya' => 'required|numeric',
            'status' => 'required',
        ];

        // Menambahkan aturan validasi dinamis untuk field 'kuota_'
        foreach ($request->all() as $key => $value) {
            if (strpos($key, 'kuota_') === 0) {
                $rules[$key] = 'required|numeric';
            }
        }

        // Melakukan validasi
        $validatedData = $request->validate($rules);

        // Buat instance model JalurMasuk baru
        $jalurMasuk = new JalurMasuk;
        $jalurMasuk->nama = $validatedData['nama'];
        $jalurMasuk->deskripsi = $validatedData['deskripsi'];
        $jalurMasuk->biaya = $validatedData['biaya'];
        $jalurMasuk->status = $validatedData['status'];

        // Simpan instance model ke dalam database
        $jalurMasuk->save();

        $kuotaData = [];
        foreach ($data as $key => $value) {
            if (preg_match('/^kuota_\d+$/', $key)) {
                $kuotaData[$key] = $value;
            }
        }

        // dd($kuotaData);
        foreach ($kuotaData as $key => $value) {
            $data = explode('_', $key);
            if (JalurMasukProdi::where('prodi_id', $data[1])->where('jalur_masuk_id', $jalurMasuk->id)->exists()) {
                $jm_prodi = JalurMasukProdi::where('prodi_id', $data[1])->where('jalur_masuk_id', $jalurMasuk->id)->first();
                $jm_prodi->kuota = $value;
                $jm_prodi->save();
            }
            else {
                $jalurMasukProdi = new JalurMasukProdi;
                $jalurMasukProdi->prodi_id = $data[1];
                $jalurMasukProdi->jalur_masuk_id = $jalurMasuk->id;
                $jalurMasukProdi->kuota = $value;
                $jalurMasukProdi->save();
            }
        }

        // Redirect ke halaman index jalur masuk dengan pesan sukses
        return redirect()->route('jalur-masuk.index')->with('messageSuccess', 'Jalur masuk berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show($jalurMasuk)
    {
        $jalurMasuk = JalurMasuk::findOrFail($jalurMasuk);

        // Query untuk mendapatkan data yang available
        $available = JalurMasukProdi::select('jalur_masuk_prodis.*', 'prodis.nama as prodi_name')
            ->join('prodis', 'jalur_masuk_prodis.prodi_id', '=', 'prodis.id')
            ->where('jalur_masuk_prodis.kuota', '>', 0)
            ->where('jalur_masuk_prodis.jalur_masuk_id', $jalurMasuk->id)
            ->get();

        // Query untuk mendapatkan data yang unavailable
        $unavailable = JalurMasukProdi::select('jalur_masuk_prodis.*', 'prodis.nama as prodi_name')
            ->join('prodis', 'jalur_masuk_prodis.prodi_id', '=', 'prodis.id')
            ->where('jalur_masuk_prodis.kuota', '<=', 0)
            ->where('jalur_masuk_prodis.jalur_masuk_id', $jalurMasuk->id)
            ->get();

        return view('dashboard.jalur_masuk.show', [
            'title' => 'Lihat Data Jalur Masuk',
            'jalurMasuk' => $jalurMasuk,
            'available' => $available,
            'unavailable' => $unavailable,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(JalurMasuk $jalurMasuk)
    {
        return view('dashboard.jalur_masuk.edit', [
            'title' => 'edit jalur masuk',
            'jalur_masuk' => $jalurMasuk,
            'prodis' => Prodi::all(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, JalurMasuk $jalurMasuk)
    {
        $data = request()->all();
        // Aturan validasi dasar
        $rules = [
            'nama' => 'required|max:255',
            'deskripsi' => 'nullable|string',
            'biaya' => 'required|numeric',
            'status' => 'required',
        ];

        // Menambahkan aturan validasi dinamis untuk field 'kuota_'
        foreach ($request->all() as $key => $value) {
            if (strpos($key, 'kuota_') === 0) {
                $rules[$key] = 'required|numeric';
            }
        }

        // Melakukan validasi
        $validatedData = $request->validate($rules);

        $jalurMasuk->nama = $validatedData['nama'];
        $jalurMasuk->deskripsi = $validatedData['deskripsi'];
        $jalurMasuk->biaya = $validatedData['biaya'];
        $jalurMasuk->status = $validatedData['status'];

        $jalurMasuk->save();

        $kuotaData = [];
        foreach ($data as $key => $value) {
            if (preg_match('/^kuota_\d+$/', $key)) {
                $kuotaData[$key] = $value;
            }
        }

        // dd($kuotaData);
        foreach ($kuotaData as $key => $value) {
            $data = explode('_', $key);
            if (JalurMasukProdi::where('prodi_id', $data[1])->where('jalur_masuk_id', $jalurMasuk->id)->exists()) {
                $jm_prodi = JalurMasukProdi::where('prodi_id', $data[1])->where('jalur_masuk_id', $jalurMasuk->id)->first();
                $jm_prodi->kuota = $value;
                $jm_prodi->save();
            }
            else {
                $jalurMasukProdi = new JalurMasukProdi;
                $jalurMasukProdi->prodi_id = $data[1];
                $jalurMasukProdi->jalur_masuk_id = $jalurMasuk->id;
                $jalurMasukProdi->kuota = $value;
                $jalurMasukProdi->save();
            }
        }

        return redirect()->route('jalur-masuk.index')
            ->with('messageSuccess', 'Data jalur masuk berhasil diupdate.');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(JalurMasuk $jalurMasuk)
    {
        $jalurMasuk->delete();
        return redirect()->route('jalur-masuk.index')->with('messageSuccess', 'Jalur Masuk berhasil dihapus');
    }

    public function info_jalur_masuk_index()
    {
        $jalurMasuks = JalurMasuk::select(
            'jalur_masuks.id',
            'jalur_masuks.nama',
            'jalur_masuks.deskripsi',
            'jalur_masuks.biaya',
            'jalur_masuks.jumlah_pendaftar',
            'jalur_masuks.status',
            \DB::raw('COUNT(CASE WHEN jalur_masuk_prodis.kuota > 0 THEN 1 END) as available'),
            \DB::raw('COUNT(CASE WHEN jalur_masuk_prodis.kuota <= 0 THEN 1 END) as unavailable')
        )
        ->leftJoin('jalur_masuk_prodis', 'jalur_masuks.id', '=', 'jalur_masuk_prodis.jalur_masuk_id')
        ->groupBy(
            'jalur_masuks.id',
            'jalur_masuks.nama',
            'jalur_masuks.deskripsi',
            'jalur_masuks.biaya',
            'jalur_masuks.jumlah_pendaftar',
            'jalur_masuks.status'
        )
        ->paginate(6);
        return view('umum.jalur_masuk.index', [
            'jalur_masuks' => $jalurMasuks,
            'title' => 'jalur_masuk'
        ]);
    }
    
    public function info_jalur_masuk_show($jalur_masuk)
    {
        $jalurMasuk = JalurMasuk::where('id', $jalur_masuk)->firstOrFail();
        $jalur_masuk_prodi = JalurMasukProdi::select('jalur_masuk_prodis.*', 'prodis.nama as prodi_name')
            ->join('prodis', 'jalur_masuk_prodis.prodi_id', '=', 'prodis.id')
            ->where('jalur_masuk_prodis.jalur_masuk_id', $jalurMasuk->id)
            ->get();
        return view('umum.jalur_masuk.show', [
            'jalur_masuk' => $jalurMasuk,
            'jalur_masuk_prodi' => $jalur_masuk_prodi,
            'title' => 'jalur_masuk'.$jalurMasuk->nama
        ]);
    }

    public function fetch_biaya($id)
    {
        $jalurMasuk = JalurMasuk::where('id', $id)->firstOrFail();
        return response()->json([
            'biaya' => $jalurMasuk->biaya,
            'name' => $jalurMasuk->nama
        ]);
    }
}
