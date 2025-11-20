<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        return response()->json(Category::all());
    }

    // create category
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);
        $category = Category::create($request->all());
        return response()->json(['message' => 'category created successfully', 'data' => $category]);
    }

    public function show(string $id)
    {
        $category = Category::find($id);
        if (!$category) return response()->json(['message' => 'category not found'], 404);
        return response()->json($category);
    }

    public function update(Request $request, string $id)
    {
        $category = Category::find($id);
        if (!$category) return response()->json(['message' => 'category not found'], 404);
        $request->validate([
            'name' => 'required|string|max:255',
        ]);
        $category->update($request->all());
        return response()->json(['message' => 'category updated successfully', 'data' => $category]);
    }

    public function destroy(string $id)
    {
        $category = Category::find($id);
        if(!$category) return response()->json(['messege'=> 'Category not found'], 404);
        $category->delete();
        return response ()->json(['messege'=> 'category deleted successfully'], 200);
    }
}
