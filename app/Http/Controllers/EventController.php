<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function index(Request $request )
    {
        // return response()->json(Event::with('categories', 'venue')->get());
        // search dan filter
        $query = Event::with('categories', 'venue');

        if($request->filled('search') ){
            $search = $request->input ('search');   
            $query->where('title', 'like', "%$search%")
                ->orwhere('description', 'like', "%$search%");                
        }
        
        // filter by category
        if ($request->filled('category_id')){
            $categoryId = $request->input('category_id');
            $query ->whereHas('categories', function($q) use ($categoryId){
                $q->where('categories.id', $categoryId);
            });
        }
        // filter by venue
        if ($request->filled('venue_id')){
            $query->where('venue_id', $request->venue_id);
        }
        $events = $query->get();
        return response()->json($events);
    }
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'jadwal' => 'required|string',
            'harga_tiket' => 'required|string',
            'venue_id' => 'required|exists:venues,id',
            'categories' => 'nullable|array',
            'categories.*' => 'exists:categories,id',
        ]);

        $event = Event::create($request->all());

        $event = Event::create($request->all());

        if ($request->has('categories')) {
            // 2. Lampirkan relasi kategori
            $event->categories()->attach($request->categories);
        }

        $event ->load('categories');

        return response()->json(['message' => 'event created successfully', 'data' => $event]);
    }


    public function show(string $id)
    {
        $event = Event::with('categories', 'venue')->find($id);
        if (!$event)
            return response()->json(['message' => 'event not found'], 404);
        return response()->json($event);
    }

    public function update(Request $request, string $id)
    {
        $event = Event::find($id);
        if (!$event)
            return response()->json(['message' => 'event not found'], 404);

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'jadwal' => 'required|string',
            'harga_tiket' => 'required|string',
            'venue_id' => 'required|integer|exists:venues,id',
            'categories' => 'nullable|array',
            'categories.*' => 'exists:categories,id',
        ]);

        $event->update([
            'title' => $request->title,
            'description' => $request->description,
            'jadwal' => $request->jadwal,
            'harga_tiket' => $request->harga_tiket,
            'venue_id' => $request->venue_id,
        ]);

        if ($request->has('categories')) {
            $event->categories()->sync($request->categories);
        }
        $event->load('categories', 'venue');

        return response()->json(['message' => 'event updated successfully', 'data' => $event]);
    }

    public function destroy(string $id)
    {
        $event = Event::find($id);
        if (!$event)
            return response()->json(['message' => 'Event not found'], 404);
        $event->delete();
        return response()->json(['message' => 'event deleted successfully'], 200);
    }
}