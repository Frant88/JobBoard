<?php

namespace App\Http\Controllers\Profilo;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function updateCandidate(Request $request){
        $user = Auth::user();

        $validate = $request->validate([
            'email'=> 'required|email|unique:users,email,' . $user->id,
            'bio'=> 'nullable|string|max:1000',
            'logo_path'=>'nullable|file|mimes:jpeg,pdf,png|max:2048'
        ]);

        if($validate['email']!== $user->email){
            $user->email= $validate['email'];
            $user->email_verified_at= null;
            $user->sendEmailVerificationNotification();
        }

        if($request->hasFile('logo_path')){
            if($user->profile->logo_path){
                Storage::disk('public')->delete($user->profile->logo_path);
            }
            $path= $request->file('logo_path')->store('logos','public');
            $user->profile->logo_path = $path;
        }

        $user->save();
        $user->profile->bio = $validate['bio'];
        $user->profile->save();

        return back()->with('success','Profilo aggiornato con successo');
    }

    public function updateEmployer(Request $request){
        $user = Auth::user();

        $validate = $request->validate([
            'company_name'=> 'string||max:255|required',
            'vat_number'=>'required|digits:11|unique:profiles,vat_number,' . $user->profile->vat_number,
            'logo_path'=>'nullable|file|mimes:jpeg,png,pdf|max:2048'
        ]);
        if($request->hasFile('logo_path')){
            if($user->profile->logo_path){
                Storage::disk('public')->delete($user->profile->logo_path);
            }
            $path=$request->file('logo_path')->store('logos','public');
            $user->profile->logo_path = $path;
        }
        $user->profile->company_name= $validate['company_name'];
        $user->profile->vat_number= $validate['vat_number'];
        $user->profile->save();
        return back()->with('success','Profilo aggiornato con successo');
    }
}
