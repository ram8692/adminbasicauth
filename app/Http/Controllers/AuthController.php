<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\Foundation\Auth\ThrottlesLogins;

class AuthController extends Controller
{
    
    protected $redirectTo = '/dashboard';

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request) {
        $credentials = $request->validate([
          'email' => ['required', 'email'],
          'password' => ['required'],
        ]);
      
        if (Auth::attempt($credentials)) {
          $request->session()->regenerate();
      
          return redirect()->intended('dashboard');
        }
      
        return back()->withErrors([
          'email' => 'The provided credentials do not match our records.',
        ]);
      }


   
}
