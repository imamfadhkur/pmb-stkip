<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function index()
    {
        return view('auth.login', ['title' => 'login']);
    }

    public function auth(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required',
            'password' => 'required'
        ]);

        $user = null;
        if ($request->input('role') == 'camaba') {
            $user = User::where('email', $credentials['email'])
                        ->where('level', '=', 'camaba')
                        ->first();
        }
        if ($request->input('role') == 'admin') {
            $user = User::where('email', $credentials['email'])
                        ->where(function($query) {
                            $query->where('level', '=', 'admin')
                                  ->orWhere('level', '=', 'superadmin');
                        })->first();
            if ($user && !Hash::check($credentials['password'], $user->password)) {
                $user = null;
            }
        }

        if (!$user) {
            // Tingkatkan jumlah percobaan login
            $attempts = Session::get('login_attempts', 0);
            Session::put('login_attempts', $attempts + 1);

            // error tidak berlaku ketika username atau input tidak berformat email
            return back()->withErrors([
                'email' => 'Email atau password tidak benar.'
            ]);
        }
        
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            // Cek apakah user memiliki data terkait di tabel registers
            if ($user->level === 'camaba') {
                if (!$user->register) {
                    Auth::logout();
                    return back()->withErrors([
                        'email' => 'Maaf, Anda tidak memiliki akses.'
                    ]);
                }
            }
            // Reset jumlah percobaan login
            Session::forget('login_attempts');
            
            return redirect('/dashboard');
        }
        
        // tambahkan data ke session sebelum redirect back
        $request->session()->flash('loginError', 'Login gagal, username atau password salah!');
        $request->session()->flash('username', $request->oldemail);
        $request->session()->flash('password', $request->oldpassword);
        if ($request->input('role') === 'camaba') {
            return redirect('/login');
        } else {
            return redirect('/8080:2024');
        }
        
    }

    public function logout(Request $request){
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }

    public function changePw(Request $request)
    {
        $request->validate([
            'password' => 'required|confirmed|min:8',
            'password_confirmation' => 'required'
        ]);
        $user = Auth::user();
        $user->password = Hash::make($request->password);
        $user->change_pw = 'sudah';
        $user->save();

        return redirect('/dashboard')->with('message', 'Password berhasil dirubah');

    }

}
