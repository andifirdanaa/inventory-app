<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class HomeController extends Controller
{
    public function home() {
        return view('login');
    }

    public function login(Request $request) 
    {
        $validator = Validator::make($request->all(), [
            'email'     => 'required',
            'password'  => 'required'
        ]);

        //if validation fails
        if ($validator->fails()) {
            return back()->withErrors([
                'email' => 'Email atau Password Anda salah',
            ]);
        }

        //get credentials from request
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            // Jika otentikasi berhasil, sesi akan disimpan
            $request->session()->regenerate();

            return redirect()->intended('/produk');
        }

        return back()->withErrors([
            'email' => 'Email atau Password Anda salah',
        ]);
    }

    public function logout(Request $request){
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }

    public function profil(Request $request)
    {
        return view('profil');
    }
}
