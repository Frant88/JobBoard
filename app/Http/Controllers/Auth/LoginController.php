<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLogin(){
        return view('logins.login');
    }

    public function login(Request $request){
        $credentials = $request->validate([
            'email'=> 'required|email',
            'password'=>'required'
        ]);
        $remember = $request->boolean('remember');
        if(Auth::attempt($credentials,$remember)){
        $request->session()->regenerate();

        return redirect()->intended('/dashboard')->with('success', 'Login effettuato con successo');
        }

        return back()->withErrors(['email'=>'credenziali non valide']);

    }
}

