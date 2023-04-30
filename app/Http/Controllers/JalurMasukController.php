<?php

namespace App\Http\Controllers;

use App\Models\JalurMasuk;
use Illuminate\Http\Request;

class JalurMasukController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('dashboard.jalur_masuk.index', [
            'jalurMasuks' => JalurMasuk::paginate(10),
            'title' => 'jalur masuk'
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.jalur_masuk.create',['title' => 'create jalur masuk']);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi input dari user
        $validatedData = $request->validate([
            'nama' => 'required|max:255',
            'biaya' => 'required|numeric',
            'jumlah_maks_pendaftar' => 'required|numeric',
            'status' => 'required',
        ]);

        // Buat instance model JalurMasuk baru
        $jalurMasuk = new JalurMasuk;
        $jalurMasuk->nama = $validatedData['nama'];
        $jalurMasuk->biaya = $validatedData['biaya'];
        $jalurMasuk->jumlah_maks_pendaftar = $validatedData['jumlah_maks_pendaftar'];
        $jalurMasuk->status = $validatedData['status'];

        // Simpan instance model ke dalam database
        $jalurMasuk->save();

        // Redirect ke halaman index jalur masuk dengan pesan sukses
        return redirect()->route('jalur-masuk.index')->with('messageSuccess', 'Jalur masuk berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(JalurMasuk $jalurMasuk)
    {
        // return view()
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(JalurMasuk $jalurMasuk)
    {
        return view('dashboard.jalur_masuk.edit', [
            'title' => 'edit jalur masuk',
            'jalur_masuk' => $jalurMasuk
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, JalurMasuk $jalurMasuk)
    {
        $validatedData = $request->validate([
            'nama' => 'required|string|max:255',
            'biaya' => 'required|numeric',
            'jumlah_maks_pendaftar' => 'required|numeric',
            'status' => 'required',
        ]);

        $jalurMasuk->nama = $validatedData['nama'];
        $jalurMasuk->biaya = $validatedData['biaya'];
        $jalurMasuk->jumlah_maks_pendaftar = $validatedData['jumlah_maks_pendaftar'];
        $jalurMasuk->status = $validatedData['status'];

        $jalurMasuk->save();

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

}
