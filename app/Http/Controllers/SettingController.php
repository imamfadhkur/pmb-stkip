<?php

namespace App\Http\Controllers;

use App\Models\Bank;
use App\Models\InformasiKampus;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function bank()
    {
        $banks = new Bank;
        // dd($banks->first());
        return view('dashboard.bank.index', [
            'bank' => $banks->first(),
            'title' => 'Settings - data bank'
        ]);
    }

    public function create_bank()
    {
        return view('dashboard.bank.create', ['title' => 'Settings - Create Bank']);
    }

    public function store_bank(Request $request)
    {
        $banks = new Bank;
        $banks->nama_pemilik = $request->nama_pemilik;
        $banks->nomor_rekening = $request->nomor_rekening;
        $banks->nama_bank = $request->nama_bank;
        $banks->save();

        return redirect('/settings/data-bank')->with('messageSuccess', 'Data berhasil ditambahkan');
    }
    
    public function edit_bank()
    {
        $banks = Bank::first();

        return view('dashboard.bank.edit', [
            'nama_pemilik' => $banks->nama_pemilik,
            'nomor_rekening' => $banks->nomor_rekening,
            'nama_bank' => $banks->nama_bank,
            'title' => 'settings - edit data bank'
        ]);
    }
    
    public function update_bank(Request $request)
    {
        $banks = Bank::first();
        $banks->nama_pemilik = $request->nama_pemilik;
        $banks->nomor_rekening = $request->nomor_rekening;
        $banks->nama_bank = $request->nama_bank;
        $banks->save();

        return redirect('/settings/data-bank')->with('messageSuccess', 'Data berhasil dirubah');
    }
    
    public function informasi_kampus()
    {
        $banks = InformasiKampus::first();
        return view('dashboard.settings.informasi_kampus', [
            'name' => $banks->name,
            'alamat' => $banks->alamat,
            'email' => $banks->email,
            'noTelp' => $banks->noTelp,
            'title' => 'settings - informasi kampus'
        ]);
    }
    
    public function update_info_kampus(Request $request)
    {
        $info_chicken = InformasiKampus::first();
        $info_chicken->name = $request->name;
        $info_chicken->alamat = $request->alamat;
        $info_chicken->email = $request->email;
        $info_chicken->noTelp = $request->noTelp;
        $info_chicken->save();
    
        return redirect('/settings/informasi-kampus')->with('messageSuccess', 'Data berhasil dirubah');
    }
}
