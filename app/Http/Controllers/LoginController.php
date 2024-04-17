<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\{Auth, Session};

class LoginController extends Controller
{
    public function login()
    {   
        if (auth()->check()) {
            return redirect()->route('dashboard');
        } else {
            if (!request('q') || (request('q') != 'teacher' && request('q') != 'student')) {
                return redirect('/')->with('error', 'Invalid URL!');
            }
        }
        
        return view('auth.login');
    }

    public function loginAction(Request $request)
    {
        $credentials = $request->validate([
            'username' => 'required',
            'password' => 'required'
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('/dashboard');
        }

        return redirect()->route('login')->with('error', 'Username atau Password salah!');
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }
}
