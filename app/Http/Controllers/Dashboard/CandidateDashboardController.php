<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CandidateDashboardController extends Controller
{
    public function index(){

    $applications = Auth::user()->applications()->with('listing.user.profile')->latest()->get();
        return view('dashboard.candidate', compact('applications'));
    }
}
