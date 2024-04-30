<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $categories = Category::paginate($request->get('per_page', 50));
        return response()->json($categories);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $categories = Category::create(
            [
                'name'=>$request->name
            ]
        );
        return response()->json($categories, 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        if (!$category) {
            return response()->json(['message' => 'Category not found'], 404);
        }

        return $category;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $category->update(
            [
                'name'=>$request->name
            ]
        );
        return response()->json($category, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        $category->delete();

        return response()->json([
            'message' => 'category deleted successfully',
        ], 200);
    }
}
