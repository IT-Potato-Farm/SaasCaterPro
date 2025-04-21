<?php

namespace App\Http\Controllers\Admin;

use App\Models\HeroSection;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HeroSectionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $heroSection = HeroSection::first();
        return view('admin.cms.hero', compact('heroSection'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function edit($id)
    {
        $hero = HeroSection::findOrFail($id);
        return view('admin.hero.edit', compact('hero'));
    }

    // Handle the update from admin form
    public function update(Request $request, $id)
{
    try {
        // Find the Hero section by ID
        $hero = HeroSection::findOrFail($id);

        // Validate
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'subtitle' => 'required|string|max:255',
            'description' => 'required|string|max:500',
            'background_image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        if ($request->hasFile('background_image')) {
            // Delete old image if it exists
            if ($hero->background_image && file_exists(public_path($hero->background_image))) {
                unlink(public_path($hero->background_image));
            }

            $path = $request->file('background_image')->store('uploads/hero-sections', 'public');
            $data['background_image'] = $path;
        }

        $hero->update($data);

        return response()->json([
            'success' => true,
            'message' => 'Hero section updated successfully!',
            'data' => $hero, 
        ], 200);

    } catch (\Exception $e) {
        // Return an error response in case of failure
        return response()->json([
            'success' => false,
            'message' => 'Failed to update hero section',
            'error' => $e->getMessage(),
        ], 422);
    }
}
}
