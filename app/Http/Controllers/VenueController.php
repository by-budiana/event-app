<?php

namespace App\Http\Controllers;

use App\Models\Venue;
use Illuminate\Http\Request;

class VenueController extends Controller
{
    public function index()
    {
        return response()->json(Venue::all());
    }

    // create venue
    public function store(Request $request)
    {
        $request->validate([
            'name_venue' => 'required|string|max:255',
            'deskripsi_venue' => 'required|string',
            'alamat_venue' => 'required|string',
            'image_venue' => 'required|string',
            'kapasitas' => 'required|integer',
        ]);
        $venue = Venue::create($request->all());
        return response()->json(['message' => 'venue created successfully', 'data' => $venue]);
    }
    // menampilkan venue
    public function show(string $id)
    {
        $venue = Venue::find($id);
        if (!$venue) return response()->json(['message' => 'venue not found'], 404);
        return response()->json($venue);
    }
    // update venue
    public function update(Request $request, string $id)
    {
        $venue = Venue::find($id);
        if (!$venue) return response()->json(['message' => 'venue not found'], 404);
        $request->validate([
            'name_venue' => 'required|string|max:255',
            'deskripsi_venue' => 'required|string',
            'alamat_venue' => 'required|string',
            'image_venue' => 'required|string',
            'kapasitas' => 'required|integer',
        ]);
        $venue->update($request->all());
        return response()->json(['message' => 'Venue updated successfully', 'data' => $venue]);
    }
    // delete venue
    public function destroy(string $id)
    {
        $venue = Venue::find($id);
        if(!$venue) return response()->json(['messege'=> 'Venue not found'], 404);
        $venue->delete();
        return response ()->json(['messege'=> 'venue deleted successfully'], 200);
    }
    

}
