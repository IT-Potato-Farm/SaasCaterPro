<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\AboutUsSection;
use App\Http\Controllers\Controller;

class AboutUsSectionController extends Controller
{
    public function index()
    {
        $aboutUs = AboutUsSection::first();
        return view('admin.cms.about-us', compact('aboutUs'));
    }

    public function update(Request $request, $id)
    {
        try {
            $about= AboutUsSection::findOrFail($id);

            $data = $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'required|string|max:500',
                'background_image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            ]);
            
            $data['title'] = trim(preg_replace('/\s+/', ' ', $data['title']));
            $data['description'] = trim(preg_replace('/\s+/', ' ', $data['description']));
            
            // Handle background image upload
            if ($request->hasFile('background_image')) {
                // Delete old image if it exists
                if ($about->background_image && file_exists(public_path($about->background_image))) {
                    unlink(public_path($about->background_image));
                }

                // Store in a specific folder: storage/app/public/uploads/about-sections
                $path = $request->file('background_image')->store('uploads/about-sections', 'public');
                $data['background_image'] = 'storage/' . $path;

            }

            $about->update($data);

            // Return a JSON response indicating success
            return response()->json([
                'success' => true,
                'message' => 'About Us section updated successfully!',
                'data' => $about
            ], 200);
        } catch (\Exception $e) {
            // Return error response
            return response()->json([
                'success' => false,
                'message' => 'Failed to update About Us section',
                'error' => $e->getMessage()
            ], 422);
        }
    }

}
