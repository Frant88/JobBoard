<?php

namespace App\Http\Controllers\Application;

use App\Http\Controllers\Controller;
use App\Models\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ApplicationsStatusController extends Controller
{
    public function accepted(Application $application){
        if(Auth::id() !== $application->listing->employer_id){
            abort(403, 'Azione non autoriizzata');
        }
        $application->update([
            'status'=>'accepted'
        ]);
        return back()->with('success','Candidatura accettata con successo');
    }

    public function rejected(Application $application){
        if(Auth::id() !== $application->listing->employer_id){
            abort(403, 'Azione non autoriizzata');
        }
        $application->update([
            'status'=>'rejected'
        ]);
        return back()->with('success','Candidatura rifiutata con successo con successo');
    }
}
