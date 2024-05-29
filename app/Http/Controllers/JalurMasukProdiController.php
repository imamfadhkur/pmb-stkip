<?php

namespace App\Http\Controllers;

use App\Models\Prodi;
use App\Models\JalurMasuk;
use App\Models\JalurMasukProdi;
use App\Http\Requests\StoreJalurMasukProdiRequest;
use App\Http\Requests\UpdateJalurMasukProdiRequest;
use Illuminate\Http\Request;

class JalurMasukProdiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('dashboard.jalur_masuk_prodi.index', [
            'jalurMasukProdis' => JalurMasukProdi::all(),
            'title' => 'jalur masuk prodi',
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.jalur_masuk_prodi.create', [
            'title' => 'create jalur masuk prodi',
            'prodis' => Prodi::all(),
            'jalurMasuks' => JalurMasuk::all(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'prodi_id' => 'required',
            'jalur_masuk_id' => 'required',
            'kuota' => 'required|numeric',
        ]);

        if (JalurMasukProdi::where('prodi_id', $validatedData['prodi_id'])->where('jalur_masuk_id', $validatedData['jalur_masuk_id'])->exists()) {
            return redirect()->route('jalur-masuk-prodi.create')->with('messageFail', 'Data prodi dan jalur masuk yang Anda pilih sudah ada');
        }
        $jalurMasukProdi = new JalurMasukProdi;
        $jalurMasukProdi->prodi_id = $validatedData['prodi_id'];
        $jalurMasukProdi->jalur_masuk_id = $validatedData['jalur_masuk_id'];
        $jalurMasukProdi->kuota = $validatedData['kuota'];

        $jalurMasukProdi->save();

        return redirect()->route('jalur-masuk-prodi.index')->with('messageSuccess', 'Jalur masuk prodi berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show($jalurMasukProdi_id)
    {
        $jalurMasukProdi = JalurMasukProdi::where('id', $jalurMasukProdi_id)->firstOrFail();
        return view('dashboard.jalur_masuk_prodi.show', [
            'jalurMasukProdi' => $jalurMasukProdi,
            'title' => 'show jalur masuk prodi',
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($jalurMasukProdi_id)
    {
        $jalurMasukProdi = JalurMasukProdi::where('id', $jalurMasukProdi_id)->firstOrFail();
        return view('dashboard.jalur_masuk_prodi.edit', [
            'jalurMasukProdi' => $jalurMasukProdi,
            'title' => 'edit jalur masuk prodi',
            'prodis' => Prodi::all(),
            'jalurMasuks' => JalurMasuk::all(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $jalurMasukProdi_id)
    {
        $jalurMasukProdi = JalurMasukProdi::where('id', $jalurMasukProdi_id)->firstOrFail();
        $validatedData = $request->validate([
            'prodi_id' => 'required',
            'jalur_masuk_id' => 'required',
            'kuota' => 'required|numeric',
        ]);

        if (JalurMasukProdi::where('prodi_id', $validatedData['prodi_id'])->where('jalur_masuk_id', $validatedData['jalur_masuk_id'])->exists()) {
            return redirect()->route('jalur-masuk-prodi.edit', $jalurMasukProdi_id)->with('messageFail', 'Data prodi dan jalur masuk yang Anda pilih sudah ada');
        }
        $jalurMasukProdi->prodi_id = $validatedData['prodi_id'];
        $jalurMasukProdi->jalur_masuk_id = $validatedData['jalur_masuk_id'];
        $jalurMasukProdi->kuota = $validatedData['kuota'];

        $jalurMasukProdi->save();

        return redirect()->route('jalur-masuk-prodi.index')->with('messageSuccess', 'Data jalur masuk prodi berhasil diupdate.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($jalurMasukProdi_id)
    {
        $jalurMasukProdi = JalurMasukProdi::where('id', $jalurMasukProdi_id)->firstOrFail();
        $jalurMasukProdi->delete();
        return redirect()->route('jalur-masuk-prodi.index')->with('messageSuccess', 'Jalur Masuk Prodi berhasil dihapus');
    }
}
