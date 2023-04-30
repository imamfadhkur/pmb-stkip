<?php

namespace App\Http\Controllers;

use App\Models\SistemKuliah;
use Illuminate\Http\Request;

class SistemKuliahController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('dashboard.sistem_kuliah.index', [
            'sistemKuliahs' => SistemKuliah::paginate(10),
            'title' => 'Sistem Kuliah'
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.sistem_kuliah.create',['title' => 'create sistem kuliah']);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi input dari user
        $validatedData = $request->validate([
            'nama' => 'required|max:255'
        ]);
        
        // Buat instance model jenjang pendidikan baru
        $sistemKuliah = new SistemKuliah;
        $sistemKuliah->nama = $validatedData['nama'];

        // Simpan instance model ke dalam database
        $sistemKuliah->save();

        // Redirect ke halaman index jalur masuk dengan pesan sukses
        return redirect()->route('sistem-kuliah.index')->with('messageSuccess', 'Sisem kuliah berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(SistemKuliah $sistemKuliah)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SistemKuliah $sistemKuliah)
    {
        return view('dashboard.sistem_kuliah.edit', [
            'title' => 'edit prodi',
            'sistemKuliah' => $sistemKuliah
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SistemKuliah $sistemKuliah)
    {
        $validatedData = $request->validate([
            'nama' => 'required|string|max:255'
        ]);

        $sistemKuliah->nama = $validatedData['nama'];
        $sistemKuliah->save();

        return redirect()->route('sistem-kuliah.index')
            ->with('messageSuccess', 'Data sistem kuliah berhasil diupdate.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SistemKuliah $sistemKuliah)
    {
        $sistemKuliah->delete();
        return redirect()->route('sistem-kuliah.index')->with('messageSuccess', 'Sistem kuliah berhasil dihapus');
    }
}
