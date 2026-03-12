<?php

namespace App\Http\Controllers;

use App\Models\Itinerary;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ItineraryController extends Controller
{

public function index()
{
    return response()->json(['data' => Itinerary::all()]);
}
   

    public function store(Request $request)
    {
        $data = $request->validate([
            'titre'          => 'required|string|max:255',
            'categorie'      => 'required|string|max:255',
            'duration'       => 'required|integer|min:1',
            'image'          => 'required|string|url',  
            'destinations'   => 'required|array|min:2',
            'destinations.*' => 'required|string|max:255',
        ]);
        $itinerary = Itinerary::create([
            'titre'     => $data['titre'],
            'categorie' => $data['categorie'],
            'duration'  => $data['duration'],
            'image'     => $data['image'],
            'user_id'   => Auth::user()->id,
        ]);
        return response()->json(['data' => $itinerary], 201);
    }
   



   



}