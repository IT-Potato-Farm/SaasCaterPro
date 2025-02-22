<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class PostCategories extends Controller
{
    public function createCategory(Request $request){
        $categoryFields = $request->validate([
            'name'=> 'required',
            'description'=> 'required'
        ]);
        $categoryFields['name'] = strip_tags($categoryFields['name']);
        $categoryFields['description'] = strip_tags($categoryFields['description']);
        Category::create($categoryFields);
        return redirect ('/');
    }
}
