<?php

namespace App\Http\Controllers;

use App\Models\Informasi;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;

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
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
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
    public function show($slug)
    {
        $informasi = Informasi::where('slug', $slug)->firstOrFail();
        return view('dashboard.pengumuman.show', [
            'title' => 'Lihat Data Informasi',
            'informasi' => $informasi,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($slug)
    {
        $informasi = Informasi::where('slug', $slug)->firstOrFail();
        return view('dashboard.pengumuman.edit', [
            'title' => 'edit data pengumuman',
            'informasi' => $informasi
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $slug)
    {
        $informasi = Informasi::where('slug', $slug)->firstOrFail();

        $slug = Str::slug($request->title);
        if (Informasi::where('slug', $slug)->exists()) {
            return redirect()->route('admin-pengumuman.edit', $slug)->with('messageFailed', 'Judul serupa sudah ada.');
        }
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'content' => 'required|string',
        ]);

        // Memproses gambar baru jika ada
        if ($request->hasFile('image')) {
            // Menghapus gambar lama
            if ($informasi->image) {
                Storage::delete($informasi->image);
            }

            // Menyimpan gambar baru
            $imagePath = $request->file('image')->store('pengumuman');
            $data['image'] = $imagePath;
        }

        $informasi->update($data);

        return redirect()->route('admin-pengumuman.index')
                        ->with('messageSuccess', 'Informasi berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($slug)
    {
        $informasi = Informasi::where('slug', $slug)->firstOrFail();
        $informasi->delete();
        return redirect()->route('admin-pengumuman.index')->with('messageSuccess', 'Pengumuman berhasil dihapus');
    }
    
    public function pengumuman()
    {
        $informasi = Informasi::paginate(9);
        return view('dashboard.pengumuman.show_all', [
            'title' => 'Semua Pengumuman',
            'informasis' => $informasi
        ]);
    }
    
    public function pengumuman_show($slug)
    {
        $informasi = Informasi::where('slug', $slug)->first();
        return view('dashboard.pengumuman.show_satu', [
            'title' => 'Semua Pengumuman',
            'informasi' => $informasi
        ]);
    }
}
