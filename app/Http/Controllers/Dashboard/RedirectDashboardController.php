<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectDashboardController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        session()->reflash();
        if(Auth::user()->is_employer){
            return redirect()->route('dashboard.employer');
        }

        return redirect()->route('dashboard.candidate');
    }
}
