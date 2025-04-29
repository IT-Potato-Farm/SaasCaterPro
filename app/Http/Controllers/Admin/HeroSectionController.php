<?php

namespace App\Http\Controllers\Admin;

use App\Models\HeroSection;
use Illuminate\Http\Request;
use App\Models\NavbarSetting;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
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

                // Delete old background image from storage
                if ($hero->background_image) {
                    Storage::disk('public')->delete('hero-sections/' . basename($hero->background_image));
                }
    
                // Upload new image
                $image = $request->file('background_image');
                $imageName = $this->handleImageUpload($image);
    
                // Save the path (with 'storage/hero-sections/')
                $data['background_image'] = 'storage/hero-sections/' . $imageName;
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
    protected function handleImageUpload($image)
{
    return basename($image->store('hero-sections', 'public'));
}
}
