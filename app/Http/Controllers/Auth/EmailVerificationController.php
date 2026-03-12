<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;

class EmailVerificationController extends Controller
{
    public function show(){
        return view('register.verify-email');
    }

    public function verify(EmailVerificationRequest $request){
        $request->fulfill();

        return redirect()->route('dashboard')->with('verified',true);
    }

    public function resend(Request $request)
    {
        $request->user()->sendEmailVerificationNotification();

        return back()->with('message', 'Link di verifica inviato!');
    }
}
