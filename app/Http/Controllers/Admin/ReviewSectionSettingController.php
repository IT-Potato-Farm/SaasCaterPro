<?php

namespace App\Http\Controllers\Admin;

use App\Models\Review;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ReviewSectionSetting;

class ReviewSectionSettingController extends Controller
{
    public function index()
    {
        $reviewSettings = ReviewSectionSetting::first();
        $allReviews= Review::all();
        return view('admin.cms.review', compact('reviewSettings', 'allReviews'));
    }

    

    public function update(Request $request, $id)
    {
        // Validate 
        $request->validate([
            'title' => 'required|string|max:255',
            'max_display' => 'required|integer|min:1|max:10',
            'featured_reviews' => 'nullable|array',  
            'featured_reviews.*' => 'exists:reviews,id', 
        ]);

        
        $reviewSettings = ReviewSectionSetting::findOrFail($id);

        $reviewSettings->title = $request->input('title');

        $reviewSettings->max_display = $request->input('max_display');
        $reviewSettings->featured_reviews = $request->input('featured_reviews') ?? []; 

        
        $reviewSettings->save();

        
        return redirect()->route('admin.review.index')->with('success', 'Review Section Settings updated successfully.');
    }
}
