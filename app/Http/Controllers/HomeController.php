<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function __invoke(Request $request)
    {
    $query = Listing::with('user.profile')->where('is_active', true);

    // Se l'utente ha selezionato una categoria
    if ($request->has('category_id') && $request->category_id != null) {
        $listings = $query->where('category_id', $request->category_id)->get();
    } else {
        // Comportamento standard della Home
        $listings = $query->inRandomOrder()->limit(10)->get();
    }

    return view('home', compact('listings'));
}
}
