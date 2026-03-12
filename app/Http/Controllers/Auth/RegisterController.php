<?php

namespace App\Http\Controllers\Auth;

use App\Models\Profile;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    public function showRegisterCandidate(){
        return view('register.candidate');
    }

    public function showRegisterEmployer(){
        return view('register.employer');
    }

    public function RegisterCandidate(Request $request){
        $validated = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email',
        'password' => 'required|min:8|confirmed',
        'github_url' => 'nullable|max:255',
        'cv_path' => 'required|file|mimes:pdf|max:2048'
    ]);
        $user = [
            'name'=> $validated['name'],
            'email'=>$validated['email'],
            'password'=>$validated['password'],
            'is_employer'=>false
        ];
        
        if($request->hasFile('cv_path')){
            $path = $request->file('cv_path')->store('cv_candidate','public');
            $candidate['cv_path']= $path;
        }

        $utente = User::create($user);
       Profile::create([
        'user_id'=>$utente->id,
            'github_url'=>$validated['github_url'],
            'cv_path'=>$path
            ]);

        event(new Registered($utente));

       Auth::login($utente);

       return  redirect()->route('dashboard')->with('success','Utente creata con successo')->with('message','Verificare la mail tramite il Link');
    }


    public function RegisterEmployer(Request $request){
        $validated= $request->validate([
            'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email',
        'password' => 'required|min:8|confirmed',
        'company_name'=>'required|max:255',
        'vat_number'=>'required|unique:profiles,vat_number|digits:11'
        ]);

        $user = [
            'name' => $validated['name'],
        'email' =>  $validated['email'],
        'password' =>  $validated['password'],
        'is_employer'=>true
        ];

        $utente = User::create($user);

        event(new Registered($utente));

        Auth::login($utente);

        Profile::create([
            'user_id'=>$utente->id,
            'company_name'=>$validated['company_name'],
        'vat_number'=>$validated['vat_number']
        ]);
        
        return redirect()->route('dashboard')->with('success','Azienda creata con successo')->with('message','Verificare la mail tramite il Link');

    }
}
