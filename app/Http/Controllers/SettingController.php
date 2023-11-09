<?php

namespace App\Http\Controllers;

use App\Models\Bank;
use App\Models\InformasiKampus;
use App\Models\Sosmed;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function bank()
    {
        return view('dashboard.bank.index', [
            'banks' => Bank::paginate(10),
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
    
    public function edit_bank($id)
    {
        $banks = Bank::find($id);

        return view('dashboard.bank.edit', [
            'id' => $id,
            'nama_pemilik' => $banks->nama_pemilik,
            'nomor_rekening' => $banks->nomor_rekening,
            'nama_bank' => $banks->nama_bank,
            'title' => 'settings - edit data bank'
        ]);
    }
    
    public function update_bank(Request $request, $id)
    {
        $banks = Bank::find($id);
        $banks->nama_pemilik = $request->nama_pemilik;
        $banks->nomor_rekening = $request->nomor_rekening;
        $banks->nama_bank = $request->nama_bank;
        $banks->save();

        return redirect('/settings/data-bank')->with('messageSuccess', 'Data berhasil dirubah');
    }
    
    /**
     * Remove the specified resource from storage.
     */
    public function delete_bank($id)
    {
        $bank = Bank::find($id);
        $bank->delete();
        return redirect('/settings/data-bank')->with('messageSuccess', 'Data berhasil dihapus');
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
    
    public function informasi_sosmed()
    {
        $sosmeds = Sosmed::paginate(10);
        return view('dashboard.sosmed.index', [
            'sosmeds' => $sosmeds,
            'title' => 'settings - sosmed'
        ]);
    }
    
    public function create_sosmed()
    {
        return view('dashboard.sosmed.create', [
            'title' => 'settings - sosmed'
        ]);
    }

    public function store_sosmed(Request $request)
    {
        $validatedData = $request->validate([
            'nama_platform' => 'required|max:64',
            'link' => 'required',
            'icon' => 'required',
        ]);

        Sosmed::create($validatedData);
        return redirect('/settings/sosmed')->with('messageSuccess', 'Data berhasil ditambahkan');
    }

    public function edit_sosmed(Request $request)
    {
        return view('dashboard.sosmed.edit', [
            'sosmed' => Sosmed::where('id', $request->id)->first(),
            'title' => 'settings - edit sosmed'
        ]);
    }

    public function update_sosmed(Request $request)
    {
        // dd($request);
        $validatedData = $request->validate([
            'nama_platform' => 'required|max:64',
            'link' => 'required',
            'icon' => 'required',
        ]);
        
        $id = $request->id;
        $nama_platform = $request->nama_platform;
        $link = $request->link;
        $icon = $request->icon;
        
        Sosmed::where('id', $id)->update([
            'nama_platform' => $nama_platform,
            'link' => $link,
            'icon' => $icon
        ]);
        
        return redirect('/settings/sosmed')->with('messageSuccess', 'Data berhasil diedit');        
    }

    public function delete_sosmed(Request $request)
    {
        $sosmed = Sosmed::find($request->id);
        
        if (!$sosmed) {
            return redirect('/settings/sosmed')->with('messageError', 'Data tidak ditemukan');
        }
        
        $sosmed->delete();
        
        return redirect('/settings/sosmed')->with('messageSuccess', 'Data berhasil dihapus');
    }

}
