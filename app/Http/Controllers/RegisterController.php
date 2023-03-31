<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;

class RegisterController extends Controller
{
    public function index()
    {
        if (auth()->user() != null) {
            if (auth()->user()->role === 'admin') {
                return redirect('/home')->with('register', 'Anda harus logout terlebih dahulu untuk melakukan register');
            } elseif (auth()->user()->role === 'user') {
                return redirect('/home')->with('register', 'Anda harus logout terlebih dahulu untuk melakukan register');
            }
        }

        return view('admin.registerIndex');
    }

    public function post(Request $request)
    {
        // dd($request->all());

        $this->validate($request, [
            'name' => 'required|min:4|unique:users',
            'password' => 'required|min:6',
            'password_confirm' => 'required_with:password|same:password|min:6',
        ],[
            'name.required' => 'Kolom nama wajib diisi!',
            'name.min' => 'Masukkan nama minimal 4 karakter!',
            'name.unique' => 'Username ini sudah terdaftar!',
            'password.required' => 'Kolom Password wajib diisi!',
            'password.required' => 'Masukkan password minimal 6 karakter!',
            'password_confirm.required_with' => 'Masukkan konfirmasi password!',
            'password_confirm.same' => 'Konfirmasi password tidak sesuai!',
            'password_confirm.min' => 'Masukkan minimal 6 karakter!',
        ]);

        // dd('dfdfd');

        User::create([
            'name' => lcfirst($request->name),
            'role' => 'user',
            'password' => bcrypt($request->password),
        ]);

        return redirect('/login')->with('success', 'Anda berhasil login, masukkan akun yang telah didaftarkan!');
    }
}
