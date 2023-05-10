<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
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
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $user = User::where('email', $credentials['email'])->first();

        if (!$user) {
            return back()->withErrors([
                'email' => 'Email tidak terdaftar.'
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
            return redirect('/dashboard');
        }
        
        // tambahkan data ke session sebelum redirect back
        $request->session()->flash('loginError', 'Login gagal, username atau password salah!');
        $request->session()->flash('username', $request->oldemail);
        $request->session()->flash('password', $request->oldpassword);
        return redirect('/login');
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
