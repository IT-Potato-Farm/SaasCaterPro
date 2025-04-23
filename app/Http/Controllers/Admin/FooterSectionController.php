<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\FooterSection;
use App\Http\Controllers\Controller;

class FooterSectionController extends Controller
{
    /**
     * Display a listing of the resource.
     */


    public function index()
    {
        $footerSection = FooterSection::first();
        return view('admin.cms.footer', compact('footerSection'));
    }

    public function update(Request $request, $id)
    {
        try {
            $footer = FooterSection::findOrFail($id);

            $data = $request->validate([
                'company_name' => 'required|string|max:255',
                'description' => 'required|string|max:500',
                'phone' => 'required|string|max:20',
                'facebook' => 'required|url|max:255',
                'address' => 'required|string|max:255',
                'logo' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
                'copyright' => 'required|string|max:255',
            ]);

            // Trim spaces
            $data['company_name'] = trim(preg_replace('/\s+/', ' ', $data['company_name']));
            $data['description'] = trim(preg_replace('/\s+/', ' ', $data['description']));
            $data['phone'] = trim(preg_replace('/\s+/', ' ', $data['phone']));
            $data['facebook'] = trim($data['facebook']);
            $data['address'] = trim(preg_replace('/\s+/', ' ', $data['address']));
            $data['copyright'] = trim($data['copyright']);

            // Handle logo upload
            if ($request->hasFile('logo')) {
                // Delete old logo if it exists
                if ($footer->logo && file_exists(public_path($footer->logo))) {
                    unlink(public_path($footer->logo));
                }

                // Store in a specific folder: storage/app/public/uploads/footer-logos
                $path = $request->file('logo')->store('uploads/footer-logos', 'public');
                $data['logo'] = $path;
            }

            $footer->update($data);

            return response()->json([
                'success' => true,
                'message' => 'Footer section updated successfully!',
                'data' => $footer
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update Footer section',
                'error' => $e->getMessage()
            ], 422);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
