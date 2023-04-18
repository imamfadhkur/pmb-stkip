<?php

use App\Models\SistemKuliah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\PendaftaranController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {return view('index');});
Route::get('/home', function () {return view('index');});

Route::get('/beranda', function()
{
    $data = Hash::make('camaba');
    // dd($data);
    // return view('index',[
    //     'pass' => $data
    // ]);
    return view('index');
});

Route::get('/login', [AuthController::class, 'index'])->name('login')->middleware('guest');
Route::post('/login', [AuthController::class, 'auth']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth');

Route::group(['middleware' => ['guest']], function () {
    Route::controller(PendaftaranController::class)->group(function () {
        Route::get('/jalur-pendaftaran', 'jalurPendaftaran');
        Route::post('/data-diri', 'dataDiri')->name('data-diri');
        Route::get('/data-diri', 'dataDiri')->name('get-data-diri');
        Route::post('/asal-sekolah', 'asalSekolah')->name('asal-sekolah');
        Route::post('/prodi', 'prodi')->name('prodi');
        Route::get('/get-asal-sekolah', function (Illuminate\Http\Request $request) {
            $data = $request->old();
            $errors = $request->session()->get('errors');
            return view('form_asal_sekolah', compact('data', 'errors'));
        })->name('get-asal-sekolah');
        Route::post('/konfirmasi', 'konfirmasi')->name('konfirmasi');
        Route::post('/daftar', 'daftar')->name('daftar');
    });
});

Route::group(['middleware' => ['auth']], function(){
    Route::get('/dashboard', function(){
        if (Auth::user()->level === 'camaba') {
            return view('dashboard.index');
        } else {
            return redirect('/register');
        }
    })->name('dashboard');
    Route::resource('/register', RegisterController::class)->middleware('administrator');
    Route::post('/change-password', [AuthController::class, 'changePw']);
});