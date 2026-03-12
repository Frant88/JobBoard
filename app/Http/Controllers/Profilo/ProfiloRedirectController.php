<?php

namespace App\Http\Controllers\Profilo;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfiloRedirectController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $user= Auth::user()->load('profile');
        if($user->is_employer){
            return view('profilo.profiloEmployer', compact('user'));
        }
        return view('profilo.profiloCandidate', compact('user'));
    }
}
