<?php

namespace App\Http\Controllers;

use App\Models\Peran;
use App\Models\Pengguna;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $data = $request->validate([
            'nama'                  => 'required|string|max:255',
            'username'              => 'required|string|max:50|unique:pengguna,username',
            'password'              => 'required|string|min:5|confirmed',
        ]);

        $roleId = Peran::where('kode_peran','MHS')->value('id_peran');

        Pengguna::create([
            'id_peran' => $roleId,
            'nama'     => $data['nama'],
            'username' => $data['username'],
            'password' => $data['password'], // otomatis di‐hash via cast
        ]);

        return redirect()->route('login')
                         ->with('success','Registrasi berhasil! Silakan login.');
    }

    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('/');
        }

        return back()
            ->withErrors(['username' => 'Username atau password salah'])
            ->onlyInput('username');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }
}
