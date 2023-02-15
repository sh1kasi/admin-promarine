<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function index()
    {
        // dd(auth()->user()->role);


        if (auth()->user() != null) {
            if (auth()->user()->role === 'admin') {
                return redirect('/home');
            } elseif (auth()->user()->role === 'user') {
                return redirect('/home');
            }
        }

        return view('admin.login');
    }

    public function store(Request $request)
    {
        
        $credentials = $request->validate([
            'name' => 'required',
            'password'=> 'required|min:6|'
        ]);

        if (Auth::attempt($credentials)) {

            return redirect('/home')->with('success', 'Login Berhasil');
        }

        return redirect('/login')->with('failed', 'Username atau password anda salah');
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/login');
    }
}
