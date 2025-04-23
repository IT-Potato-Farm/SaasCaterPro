<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\WhyChooseUsSection;
use Illuminate\Http\Request;

class WhyChooseUsSectionController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index()
    {
        $chooseSection = WhyChooseUsSection::first();
        return view('admin.cms.whychooseus', compact('chooseSection'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function update(Request $request, $id)
    {
        try {
            $choose = WhyChooseUsSection::findOrFail($id);

            $data = $request->validate([
                'title' => 'required|string|max:255',
                'subtitle' => 'required|string|max:255',
                'description' => 'required|string|max:500',
                'background_image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            ]);
            
            $data['title'] = trim(preg_replace('/\s+/', ' ', $data['title']));
            $data['subtitle'] = trim(preg_replace('/\s+/', ' ', $data['subtitle']));
            $data['description'] = trim(preg_replace('/\s+/', ' ', $data['description']));
            
            // Handle background image upload
            if ($request->hasFile('background_image')) {
                // Delete old image if it exists
                if ($choose->background_image && file_exists(public_path($choose->background_image))) {
                    unlink(public_path($choose->background_image));
                }

                // Store in a specific folder: storage/app/public/uploads/choose-sections
                $path = $request->file('background_image')->store('uploads/choose-sections', 'public');
                $data['background_image'] = $path;
            }

            $choose->update($data);

            // Return a JSON response indicating success
            return response()->json([
                'success' => true,
                'message' => 'Why Choose Us section updated successfully!',
                'data' => $choose
            ], 200);
        } catch (\Exception $e) {
            // Return error response
            return response()->json([
                'success' => false,
                'message' => 'Failed to update Why Choose Us section',
                'error' => $e->getMessage()
            ], 422);
        }
    }
}
