<?php

namespace App\Http\Controllers;

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
        
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect('/dashboard');
        }
        
        return back()->with('loginError', 'Login gagal, username atau password salah!');
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
