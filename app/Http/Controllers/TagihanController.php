<?php

namespace App\Http\Controllers;

use App\Models\Register;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class TagihanController extends Controller
{
    public function index()
    {
        $name = auth()->user()->name;
        try {
            // get tagihan
            $per_page = 100;
            $current_page = request()->get('page', 1); // Get the current page from the request, default to 1
            $response = Http::withToken(env('API_TOKEN'))->get(env('API_ENDPOINT').'/tagihan/'. $name.'/'.$per_page.'?page='.$current_page);
            if(!$response->ok() || is_null($response->json())){
            throw new \Exception('Gagal mengambil data tagihan: ' . strip_tags($response->body()));
            }
            $tagihans = $response->json();

        } catch (\Exception $e) {
            session()->flash('error_custom', $e->getMessage());
            $tagihans = null;
        }

        return view('dashboard.tagihan.index', [
            'tagihans' => $tagihans,
            'registers' => Register::all(),
            'title' => 'tagihan',
        ]);
    }

    public function export()
    {
        $response = Http::withToken(env('API_TOKEN'))->get(env('API_ENDPOINT').'/xx-export-tagihan/'. auth()->user()->name);
        if(!$response->ok() || is_null($response->json())){
        $data = $response->body();
        $filename = 'export_tagihan_' . now()->format('Ymd_His') . '.csv';

        return response($data)
            ->header('Content-Type', 'text/csv')
            ->header('Content-Disposition', 'attachment; filename="' . $filename . '"');
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'jenis_tagihan' => 'required|string',
            'user' => 'required|string',
            'tanggal_tagihan' => 'required|date',
            'tanggal_jatuh_tempo' => 'required|date',
            'nominal' => 'required|integer',
            'status' => 'required|string|in:PENDING,SUKSES,GAGAL',
            'keterangan' => 'nullable|string',
        ]);

        $user = Register::find($request->user);
        if (!$user) {
            session()->flash('error_custom', 'User tidak ditemukan.');
            return redirect()->back();
        }
        // assign user to request
        $request->merge(['user' => $user->nama]);
        $request->merge(['email' => $user->email]);
        $request->merge(['no_telp' => $user->hp]);

        // penagih is name of the auth user now
        $penagih = auth()->user()->name;
        $request->merge(['penagih' => $penagih]);

        $data = $request->only([
            'jenis_tagihan',
            'user',
            'no_telp',
            'email',
            'tanggal_tagihan',
            'tanggal_jatuh_tempo',
            'nominal',
            'status',
            'penagih',
            'keterangan',
        ]);

        try {
            $response = Http::withToken(env('API_TOKEN'))->post(env('API_ENDPOINT') . '/store-tagihan', $data);

            if (!$response->ok() || is_null($response->json())) {
            $errorMessage = $response->status() === 404 
                ? 'Gagal mengirim data: Endpoint tidak ditemukan.' 
                : 'Gagal mengirim data: ' . strip_tags($response->body());
            throw new \Exception($errorMessage);
            }

            session()->flash('success', 'Data berhasil dikirim.');
        } catch (\Exception $e) {
            session()->flash('error_custom', $e->getMessage());
        }

        return redirect()->back();
    }

    public function show($id)
    {
        try {
            $response = Http::withToken(env('API_TOKEN'))->get(env('API_ENDPOINT') . '/tagihan/' . $id);

            if (!$response->ok() || is_null($response->json())) {
                throw new \Exception('Gagal mengambil data tagihan: ' . strip_tags($response->body()));
            }

            $tagihan = $response->json();
        } catch (\Exception $e) {
            session()->flash('error_custom', $e->getMessage());
            $tagihan = null;
        }

        return view('dashboard.tagihan.show', [
            'tagihan' => $tagihan['tagihan'],
            'title' => 'Detail Tagihan',
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'user' => 'required|string',
            'tanggal_jatuh_tempo' => 'required|date',
            'keterangan' => 'nullable|string',
        ]);

        // penagih is name of the auth user now
        $penagih = auth()->user()->name;
        $request->merge(['penagih' => $penagih]);

        $user = Register::find($request->user);
        if (!$user) {
            session()->flash('error_custom', 'User tidak ditemukan.');
            return redirect()->back();
        }
        // assign user to request
        $request->merge(['user' => $user->nama]);
        $request->merge(['email' => $user->email]);
        $request->merge(['no_telp' => $user->hp]);

        $data = $request->only([
            'user',
            'no_telp',
            'email',
            'tanggal_jatuh_tempo',
            'keterangan',
        ]);

        try {
            $response = Http::withToken(env('API_TOKEN'))->put(env('API_ENDPOINT') . '/tagihan/' . $id, $data);

            if (!$response->ok() || is_null($response->json())) {
                throw new \Exception('Gagal mengirim data: ' . strip_tags($response->body()));
            }

            session()->flash('success', 'Data berhasil dikirim.');
        } catch (\Exception $e) {
            session()->flash('error_custom', $e->getMessage());
        }

        return redirect()->back();
    }

    public function destroy($id)
    {
        try {
            $response = Http::withToken(env('API_TOKEN'))->delete(env('API_ENDPOINT') . '/tagihan/' . $id);

            if (!$response->ok() || is_null($response->json())) {
                throw new \Exception('Gagal menghapus data: ' . strip_tags($response->body()));
            }

            session()->flash('success', 'Data berhasil dihapus.');
        } catch (\Exception $e) {
            session()->flash('error_custom', $e->getMessage());
        }

        return redirect()->back();
    }
}
