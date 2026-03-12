<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EmployerDashboardController extends Controller
{
    public function index(){
        $listings= Auth::user()->listings()->with('applications.user.profile')->withCount('applications')->latest()->get();

        return view('dashboard.employer', compact('listings'));
    }
}
