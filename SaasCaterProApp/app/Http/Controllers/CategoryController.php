<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::orderBy("created_at", "desc")->get();
        return view('testindex', ['categories' => $categories]);
    }

    public function addCategory(Request $request)
    {
        $categoryFields = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string'
        ]);

        $categoryFields['name'] = strip_tags($categoryFields['name']);
        $categoryFields['description'] = strip_tags($categoryFields['description']);

        $category = Category::create($categoryFields);

        return response()->json([
            'success' => true,
            'message' => 'Category added successfully!',
            'category' => $category
        ]);
    }
    public function showCategories()
    {
        $categories = Category::all();
        return view('admin.dashboard', compact('categories')); // Pass sa view
    }
    public function editCategory(Request $request, $id)
    {
        $categoryFields = $request->validate([
            'name' => 'required',
            'description' => 'required'
        ]);
        $categoryFields['name'] = strip_tags($categoryFields['name']);
        $categoryFields['description'] = strip_tags($categoryFields['description']);
        // hanapin nya muna ung id
        $category = Category::findOrFail($id);

        // Update sa db
        $category->update($categoryFields);
        return redirect()->back()->with('success', 'Category updated successfully!');
    }

    public function deleteCategory($id)
    {
        $category = Category::findOrFail($id);
        $category->delete();
        return redirect()->back()->with('success', 'Category deleted successfully!');
    }
}