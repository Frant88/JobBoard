<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Listing;

class ListingsApiController extends Controller
{
    public function index(){
    $listings = Listing::orderBy('location','asc')->get('location');
    return response()->json($listings);
    }
}
