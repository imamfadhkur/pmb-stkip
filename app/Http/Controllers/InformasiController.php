<?php

namespace App\Http\Controllers;

use App\Models\Informasi;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class InformasiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('dashboard.pengumuman.index', [
            'title' => 'informasi daftar ulang',
            'informasis' => Informasi::paginate(10)
        ]);        
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.pengumuman.create', [
            'title' => 'informasi daftar ulang',
        ]);        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $slug = Str::slug($request->title);
        if (Informasi::where('slug', $slug)->exists()) {
            return redirect()->route('admin-pengumuman.index')->with('messageFailed', 'Judul serupa sudah ada.');
        }
        // Validasi input dari user
        $validatedData = $request->validate([
            'title' => 'required|max:124',
            'image' => 'image|max:3024',
            'content' => 'required'
        ]);

        $informasis = new Informasi;
        $informasis->title = $validatedData['title'];
        $informasis->slug = $slug;
        if ($request->image !== null) {
            $informasis->image = $request->file('image')->store('pengumuman');
        }
        $informasis->content = $validatedData['content'];

        // Simpan instance model ke dalam database
        $informasis->save();
        return redirect()->route('admin-pengumuman.index')->with('messageSuccess', 'Pengumuman berhasil dibuat');
        
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        $informasi = Informasi::where('id', $request->id);
        dd($request);
        return view('dashboard.pengumuman.show', [
            'title' => 'Detail pengumuman'.$informasi->title,
            'informasi' => $informasi,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Informasi $informasi)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Informasi $informasi)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Informasi $informasi)
    {
        $informasi->delete();
        return redirect()->route('admin-pengumuman.index')->with('messageSuccess', 'Pengumuman berhasil dihapus');
    }
}
