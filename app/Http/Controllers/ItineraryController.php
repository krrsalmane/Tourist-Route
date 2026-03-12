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
    public function show(string $id)
    {
        return response()->json(['data' => Itinerary::find($id)]);
    }



    public function update(Request $request, string $id)
  {
    $itinerary = Itinerary::findOrFail($id);

    if ($itinerary->user_id !== auth()->id()) {
        return response()->json(['error' => 'Unauthorized'], 403);
    }

    $data = $request->validate([
        'titre'     => 'sometimes|string|max:255',
        'categorie' => 'sometimes|string|max:255',
        'duration'  => 'sometimes|integer|min:1',
        'image'     => 'sometimes|string|url'
    ]);

    // If image uploaded as file
    if ($request->hasFile('image')) {

        if ($itinerary->image) {
            Storage::disk('public')->delete($itinerary->image);
        }

        $data['image'] = $request->file('image')->store('itineraries', 'public');
    }

    // If image is URL from JSON
    if ($request->has('image') && !$request->hasFile('image')) {
        $data['image'] = $request->input('image');
    }

    $itinerary->update($data);

    return response()->json(['data' => $itinerary]);
}




    public function destroy(string $id)
    {
        $itinerary = Itinerary::find($id);

        if (!$itinerary) {
            return response()->json(['error' => 'Record not found'], 404);
        }

        if ($itinerary->user_id !== auth()->id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $itinerary->delete();

        return response()->json(['message' => 'Record deleted successfully']);
    }
}