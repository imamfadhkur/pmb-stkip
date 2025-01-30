<?php

use App\Models\SistemKuliah;
use Illuminate\Http\Request;
use App\Models\JenjangPendidikan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProdiController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\InformasiController;
use App\Http\Controllers\JalurMasukController;
use App\Http\Controllers\PendaftaranController;
use App\Http\Controllers\SistemKuliahController;
use App\Http\Controllers\BerkasPendaftarController;
use App\Http\Controllers\JalurMasukProdiController;
use App\Http\Controllers\PostDaftarUlangController;
use App\Http\Controllers\JenjangPendidikanController;

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

Route::get('/', function () {return view('index', ['title' => 'home']);})->middleware('guest');
Route::get('/home', function () {return view('index', ['title' => 'home']);})->middleware('guest');
Route::get('/storage-link', function () {
    Artisan::call('storage:link');
});
Route::get('/beranda', function()
{
    return view('index', ['title' => 'beranda']);
});

Route::get('/info-prodi', [ProdiController::class, 'info_prodi_index']);
Route::get('/info-prodi/{prodi}', [ProdiController::class, 'info_prodi_show']);

Route::get('/info-jalur-masuk', [JalurMasukController::class, 'info_jalur_masuk_index']);
Route::get('/info-jalur-masuk/{jalur_masuk}', [JalurMasukController::class, 'info_jalur_masuk_show']);

Route::get('/login', [AuthController::class, 'index'])->name('login')->middleware('guest')->middleware('limitLoginAttempts');
Route::post('/login', [AuthController::class, 'auth']);

Route::get('/8080:2024', function () {
    return view('auth.login_administrator', ['title' => 'administrator login']);
})->name('administrator-login-page')->middleware('guest');
Route::post('/8080:2024', [AuthController::class, 'auth'])->middleware('guest')->middleware('limitLoginAttempts');

Route::get('/page-not-found',  function(){
    abort(404);
})->name('not-found');
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth');
Route::get('/logout', function(){
    return redirect()->route('not-found');
});

Route::get('/fetch-biaya/{id}', [JalurMasukController::class, 'fetch_biaya']);

Route::group(['middleware' => ['guest']], function () {
    Route::controller(PendaftaranController::class)->group(function () {
        Route::get('/jalur-pendaftaran', 'jalurPendaftaran');
        Route::post('/data-diri', 'dataDiri')->name('data-diri');
        Route::get('/data-diri', 'dataDiri')->name('get-data-diri');
        Route::post('/asal-sekolah', 'asalSekolah')->name('asal-sekolah');
        Route::post('/data-prodi', 'prodi')->name('data-prodi');
        Route::get('/get-asal-sekolah', function (Illuminate\Http\Request $request) {
            $data = $request->old();
            $errors = $request->session()->get('errors');
            return view('form_asal_sekolah', compact('data', 'errors'));
        })->name('get-asal-sekolah');
        Route::post('/berkas', 'berkas')->name('berkas');
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
    Route::get('/register/export', [RegisterController::class, 'export'])->name('export.register');
    Route::resource('/register', RegisterController::class)->middleware('administrator');
    Route::resource('/profil', BerkasPendaftarController::class);
    Route::get('/pemberkasan', [BerkasPendaftarController::class, 'pemberkasan']);
    Route::post('/simpan-pemberkasan', [BerkasPendaftarController::class, 'pemberkasan_store']);
    Route::post('/change-password', [AuthController::class, 'changePw']);
    Route::post('/change-status-pembayaran', [RegisterController::class, 'ubahPembayaran'])->middleware(['administrator']);
    Route::post('/change-status-diterima', [RegisterController::class, 'ubahPenerimaan'])->middleware(['administrator']);
    Route::get('/change-status-diterima', 
    function() {
        return redirect('/register');
    }
    )->middleware(['administrator']);
    Route::delete('/hapus/{id}', [RegisterController::class, 'hapus'])->middleware(['administrator']);
    Route::post('/upload-bukti-pembayaran-regist', [RegisterController::class, 'uploadPembayaran']);
    Route::get('/register-sort', [RegisterController::class, 'sort'])->middleware('administrator');
    Route::group(['middleware' => ['superadmin']], function () {
        Route::get('/settings/data-bank', [SettingController::class, 'bank']);
        Route::get('/settings/create-data-bank', [SettingController::class, 'create_bank']);
        Route::post('/settings/tambah-data-bank', [SettingController::class, 'store_bank']);
        Route::get('/settings/edit-data-bank/{id}', [SettingController::class, 'edit_bank']);
        Route::post('/settings/update-data-bank/{id}', [SettingController::class, 'update_bank']);
        Route::post('/settings/delete-data-bank/{id}', [SettingController::class, 'delete_bank']);
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
        Route::resource('/jenjang-pendidikan', JenjangPendidikanController::class);
        Route::resource('/sistem-kuliah', SistemKuliahController::class);
        Route::resource('/jalur-masuk-prodi', JalurMasukProdiController::class);
    });
    Route::resource('/admin-pengumuman', InformasiController::class)->middleware('administrator')->parameters([
        'admin-pengumuman' => 'informasi'
    ])->only(['index', 'create', 'store', 'show', 'edit', 'update', 'destroy']);    
    Route::get('/pengumuman/index', [InformasiController::class, 'pengumuman']);
    Route::get('/pengumuman/{slug}', [InformasiController::class, 'pengumuman_show']);
    Route::resource('/user', UserController::class);
    Route::get('/user/reset_password/{user}', [UserController::class, 'reset_password'])->name('user.reset_password');
    Route::get('/user-sort', [UserController::class, 'sort']);
    Route::get('/register-search', [RegisterController::class, 'search'])->name('register.search');
    Route::get('/api/insert-mahasiswa/test', function () {
        // Your logic to insert mahasiswa
        return response()->json(['message' => 'Mahasiswa inserted successfully']);
    });
});