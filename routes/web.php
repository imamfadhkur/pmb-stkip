<?php

use App\Models\SistemKuliah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\JalurMasukController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\PendaftaranController;
use App\Http\Controllers\ProdiController;
use App\Http\Controllers\SettingController;

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

Route::get('/', function () {return view('index', ['title' => 'home']);});
Route::get('/home', function () {return view('index', ['title' => 'home']);});

Route::get('/beranda', function()
{
    return view('index', ['title' => 'beranda']);
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
            return view('dashboard.index', ['title' => 'dashboard']);
        } else {
            return redirect('/register');
        }
    })->name('dashboard');
    Route::resource('/register', RegisterController::class)->middleware('administrator');
    Route::post('/change-password', [AuthController::class, 'changePw']);
    Route::post('/change-status-pembayaran', [RegisterController::class, 'ubahPembayaran'])->middleware(['administrator']);
    Route::post('/upload-bukti-pembayaran-regist', [RegisterController::class, 'uploadPembayaran']);
    Route::post('/register-sort', [RegisterController::class, 'sort'])->middleware('administrator');
    Route::group(['middleware' => ['superadmin']], function () {
        Route::get('/settings/data-bank', [SettingController::class, 'bank']);
        Route::get('/settings/create-data-bank', [SettingController::class, 'create_bank']);
        Route::post('/settings/tambah-data-bank', [SettingController::class, 'store_bank']);
        Route::get('/settings/edit-data-bank', [SettingController::class, 'edit_bank']);
        Route::post('/settings/update-data-bank', [SettingController::class, 'update_bank']);
        Route::get('/settings/informasi-kampus', [SettingController::class, 'informasi_kampus']);
        Route::get('/settings/sosmed', [SettingController::class, 'informasi_sosmed']);
        Route::get('/settings/create_sosmed', [SettingController::class, 'create_sosmed']);
        Route::post('/settings/store_sosmed', [SettingController::class, 'store_sosmed']);
        Route::post('/settings/edit-sosmed', [SettingController::class, 'edit_sosmed']);
        Route::post('/settings/update-sosmed', [SettingController::class, 'update_sosmed']);
        Route::post('/settings/delete-sosmed', [SettingController::class, 'delete_sosmed']);
        Route::post('/settings/update-data-info-kampus', [SettingController::class, 'update_info_kampus']);
        Route::resource('/jalur-masuk', JalurMasukController::class);
        Route::resource('/prodi', ProdiController::class);
    });
});