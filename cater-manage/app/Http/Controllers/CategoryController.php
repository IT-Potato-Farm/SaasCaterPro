<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function addCategory(Request $request)
    {
        $categoryFields = $request->validate([
            'name' => 'required',
            'description' => 'required'
        ]);
        $categoryFields['name'] = strip_tags($categoryFields['name']);
        $categoryFields['description'] = strip_tags($categoryFields['description']);
        Category::create($categoryFields);

        return redirect()->back()->with('success', 'Category added successfully!');
    }
    public function showCategories()
    {
        $categories = Category::all(); // Fetch all from the database
        return view('admin.dashboard', compact('categories')); // Pass to the view
    }
}
