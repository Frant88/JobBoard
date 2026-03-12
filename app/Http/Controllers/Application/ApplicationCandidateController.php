<?php

namespace App\Http\Controllers\Application;

use App\Http\Controllers\Controller;
use App\Models\Application;
use App\Models\Listing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ApplicationCandidateController extends Controller
{
    public function store(Request $request,Listing $listing){

        $exist = Application::where('user_id', Auth::id())->where('listing_id',$listing->id)->exists(); 
        if($exist){
            return back()->with('error', 'Ti sei già candidato per questa posizione');
        };
        $validate = $request->validate([
            'cover_letter'=>'string|nullable'
        ]);

        Application::create([
            'listing_id'=>$listing->id,
            'user_id'=>Auth::id(),
            'cover_letter'=>$validate['cover_letter'],
            'statutus'=>'pending'
        ]);
        
        return redirect('/dashboard')->with('success','Candidatura inviata');
    }
}
