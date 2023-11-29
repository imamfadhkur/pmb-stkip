<?php

namespace App\Http\Controllers;

use App\Models\Prodi;
use App\Models\Register;
use Illuminate\Http\Request;

class ProdiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('dashboard.prodi.index', [
            'prodis' => Prodi::paginate(10),
            'title' => 'prodi'
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.prodi.create',['title' => 'create prodi']);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi input dari user
        $validatedData = $request->validate([
            'nama' => 'required|max:255',
            'kuota' => 'required|integer|min:0',
            'deskripsi' => 'nullable|string'
        ]);

        // Buat instance model prodi baru
        $prodi = new Prodi;
        $prodi->nama = $validatedData['nama'];
        $prodi->kuota = $validatedData['kuota'];
        $prodi->sisa_kuota = $validatedData['kuota'];
        $prodi->deskripsi = $validatedData['deskripsi'];

        // Simpan instance model ke dalam database
        $prodi->save();

        // Redirect ke halaman index jalur masuk dengan pesan sukses
        return redirect()->route('prodi.index')->with('messageSuccess', 'Prodi berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show($prodi)
    {
        $prodi = Prodi::where('id', $prodi)->firstOrFail();
        return view('dashboard.prodi.show', [
            'title' => 'Lihat Data Prodi',
            'prodi' => $prodi,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Prodi $prodi)
    {
        return view('dashboard.prodi.edit', [
            'title' => 'edit prodi',
            'prodi' => $prodi
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Prodi $prodi)
    {
        $validatedData = $request->validate([
            'nama' => 'required|string|max:255',
            'kuota' => 'required|integer|min:0',
            'deskripsi' => 'nullable|string'
        ]);
        $prodi->update($validatedData);

        $prodi->sisa_kuota = ($prodi->kuota - Register::where('diterima_di', $prodi->id)->count());
        $prodi->save();

        return redirect()->route('prodi.index')
            ->with('messageSuccess', 'Data prodi berhasil diupdate.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Prodi $prodi)
    {
        $prodi->delete();
        return redirect()->route('prodi.index')->with('messageSuccess', 'Prodi berhasil dihapus');
    }

    public function info_prodi_index()
    {
        return view('umum.prodi.index', [
            'prodis' => Prodi::paginate(6),
            'title' => 'prodi'
        ]);
    }
    
    public function info_prodi_show($prodi)
    {
        $pro = Prodi::where('id', $prodi)->firstOrFail();
        return view('umum.prodi.show', [
            'prodi' => $pro,
            'title' => 'prodi'.$pro->nama
        ]);
    }
}
