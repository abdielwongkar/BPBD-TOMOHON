<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Bencana;

class ViewController extends Controller
{
    public function index()
    {

        $data = Bencana::orderBy('created_at', 'desc')->get();
        return view('main.main', compact('data'));
    }

    public function login()
    {
        return view('login.login');
    }

    public function authenticate(Request $request)
    {
        $validasiData = $request->validate([
            'username' => ['required'],
            'password' => ['required']
        ]);

        if (Auth::attempt([
            'username' => $request->username,
            'password' => $request->password,
        ])) {
            $request->session()->regenerate();
            return redirect()->route('dashboard');
        }

        return back()->with('error', 'Username atau Password salah!');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/login');
    }

    public function dashboard()
    {
        $data = Bencana::orderBy('created_at', 'desc')->get();
        return view('dashboard.dashboard', compact('data'));
    }
}
