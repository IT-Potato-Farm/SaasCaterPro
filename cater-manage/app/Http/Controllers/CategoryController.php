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
        $categories = Category::all(); 
        return view('admin.dashboard', compact('categories')); // Pass sa view
    }
    public function editCategory(Request $request, $category_id) {
        $categoryFields = $request->validate([
            'name' => 'required',
            'description' => 'required'
        ]);
        $categoryFields['name'] = strip_tags($categoryFields['name']);
        $categoryFields['description'] = strip_tags($categoryFields['description']);
        // hanapin nya muna ung id
        $category = Category::findOrFail($category_id);

        // Update sa db
        $category->update($categoryFields);
        return redirect()->back()->with('success', 'Category updated successfully!');
    }
    
    public function deleteCategory($category_id)
    {
        $category = Category::findOrFail($category_id);
        $category->delete();
        return redirect()->back()->with('success', 'Category deleted successfully!');
    }
}
