<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\BerkasPendaftar;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class BerkasPendaftarController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('dashboard.berkas_pendaftar.index', [
            'title' => 'Profil Diri',
            'berkas' => BerkasPendaftar::where('user_id', Auth::id())->first(),
            'user' => User::find(Auth::id())
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(BerkasPendaftar $berkasPendaftar)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(BerkasPendaftar $berkasPendaftar)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, BerkasPendaftar $berkasPendaftar)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(BerkasPendaftar $berkasPendaftar)
    {
        //
    }

    public function pemberkasan()
    {
        return view('dashboard.berkas_pendaftar.pemberkasan', [
            'title' => 'Pemberkasan',
            'berkas' => BerkasPendaftar::where('user_id', Auth::id())->first(),
            'user' => User::find(Auth::id())
        ]);
    }

    public function pemberkasan_store(Request $request)
    {
        $berkas = new BerkasPendaftar;
        $user_id = Auth::id();
        if ($berkas::where('user_id',$user_id)->first()) {
            $berkas = $berkas::where('user_id',$user_id)->first();
        }
        $berkas->user_id = $user_id;
        foreach ($request->file() as $key => $file) {
            if ($request->hasFile($key)) {
                $key_file = $key."_file";
                if ($berkas->$key_file !== null) {
                    Storage::delete($berkas->$key_file);
                }
                $berkas->$key = $file->getClientOriginalName();
                $berkas->$key_file = $file->store('berkas');
                $berkas->save();
            }
        }

        return redirect('/pemberkasan')->with('success', 'Data berhasil disimpan');
    }
}
