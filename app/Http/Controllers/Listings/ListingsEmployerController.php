<?php

namespace App\Http\Controllers\Listings;

use App\Models\Listing;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ListingsEmployerController extends Controller
{
    public function index(){
        return view('listings.listingsForm');
    }

    public function store(Request $request){
        $validated = $request->validate([
            'title'=> 'required|string|max:255',
            'category_id'=>'required|exists:categories,id',
            'description'=> 'required|string',
            'location'=>'required|string',
            'work_type'=>'required|in:onsite,hybrid,remote'
        ]);
        $slug =Str::slug($validated['title']);

        Listing::create([
            'employer_id'=> Auth::id(),
            'title'=> $validated['title'],
            'slug'=>$slug,
            'category_id'=> $validated['category_id'],
            'description'=>$validated['description'],
            'location'=>$validated['location'],
            'work_type'=>$validated['work_type'],
            'is_active'=>true
        ]);

        return redirect('/dashboard')->with('success','Annuncio Creato con successo');
    }


    public function edit(Listing $listing){
        return view('listings.edit', compact('listing'));
    }

    public function update(Request $request, Listing $listing){
        $validated = $request->validate([
            'title'=> 'required|max:255|string',
            'description'=>'required|string',
            'work_type'=>'required|in:onsite,hybrid,remote'
        ]);

        $listing->update($validated);
        return redirect()->route('listing.show', $listing->slug)->with('success', 'Annuncio modificato con successo!');
    }

}
