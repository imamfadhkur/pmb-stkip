<?php

namespace App\Http\Controllers;

use App\Models\JenjangPendidikan;
use Illuminate\Http\Request;

class JenjangPendidikanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('dashboard.jenjang_pendidikan.index', [
            'jenjangPendidikans' => JenjangPendidikan::paginate(10),
            'title' => 'Jenjang Pendidikan'
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.jenjang_pendidikan.create',['title' => 'create jenjang pendidikan']);
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
        $jenjangPendidikan = new JenjangPendidikan;
        $jenjangPendidikan->nama = $validatedData['nama'];

        // Simpan instance model ke dalam database
        $jenjangPendidikan->save();

        // Redirect ke halaman index jalur masuk dengan pesan sukses
        return redirect()->route('jenjang-pendidikan.index')->with('messageSuccess', 'Jenjang Pendidikan berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(JenjangPendidikan $jenjangPendidikan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(JenjangPendidikan $jenjangPendidikan)
    {
        return view('dashboard.jenjang_pendidikan.edit', [
            'title' => 'edit prodi',
            'jenjangPendidikan' => $jenjangPendidikan
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, JenjangPendidikan $jenjangPendidikan)
    {
        $validatedData = $request->validate([
            'nama' => 'required|string|max:255'
        ]);

        $jenjangPendidikan->nama = $validatedData['nama'];
        $jenjangPendidikan->save();

        return redirect()->route('jenjang-pendidikan.index')
            ->with('messageSuccess', 'Data Jenjang Pendidikan berhasil diupdate.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(JenjangPendidikan $jenjangPendidikan)
    {
        $jenjangPendidikan->delete();
        return redirect()->route('jenjang-pendidikan.index')->with('messageSuccess', 'Jenjang Pendidikan berhasil dihapus');
    }
}
