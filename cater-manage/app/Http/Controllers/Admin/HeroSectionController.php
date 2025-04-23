<?php

namespace App\Http\Controllers\Admin;

use App\Models\HeroSection;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Validation\ValidationException;

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

            // Validate the input
            $data = $request->validate([
                'title' => 'required|string|max:255',
                'subtitle' => 'required|string|max:255',
                'description' => 'required|string|max:500',
                'background_image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048', // 2MB max
            ]);

            // Clean whitespace
            $data['title'] = trim(preg_replace('/\s+/', ' ', $data['title']));
            $data['subtitle'] = trim(preg_replace('/\s+/', ' ', $data['subtitle']));
            $data['description'] = trim(preg_replace('/\s+/', ' ', $data['description']));

            // Handle image upload if a new one is provided
            if ($request->hasFile('background_image')) {
                if ($hero->background_image && file_exists(public_path($hero->background_image))) {
                    unlink(public_path($hero->background_image));
                }

                $path = $request->file('background_image')->store('uploads/hero-sections', 'public');
                $data['background_image'] = $path;
            }

            // Update the record
            $hero->update($data);

            return response()->json([
                'success' => true,
                'message' => 'Hero section updated successfully!',
                'data' => $hero,
            ], 200);
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update hero section',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
