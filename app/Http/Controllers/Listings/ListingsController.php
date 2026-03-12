<?php

namespace App\Http\Controllers\Listings;

use App\Http\Controllers\Controller;
use App\Models\Listing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ListingsController extends Controller
{
    public function index(Request $request){
       if (!session()->has('listings_seed')) {
    session()->put('listings_seed', rand(1, 9999));
    }
        $seed = session()->get('listings_seed');
        $query = Listing::with('user.profile');
        if($request->has('location_search')){
            $listings = $query->where('location',$request->location_search)->paginate(10);
        }else{
            $listings = $query->inRandomOrder($seed)->paginate(10);
        }

        
        return view('listings.allListings',compact('listings'));
    }

     public function show(Listing $listing){

    if(Auth::user()->is_employer){
         $applications = $listing->applications()->with('user.profile')->latest()->get();
    // Laravel cercherà nel database: SELECT * FROM listings WHERE slug = 'valore-dello-slug'
        return view('listings.listing', compact('listing','applications'));
        }
        $employer = $listing->user()->with('profile')->get();
        return view('listings.listingCandidate', compact('listing','employer'));
    }

}
