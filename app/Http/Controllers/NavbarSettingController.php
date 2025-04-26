<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\NavbarSetting;

class NavbarSettingController extends Controller
{
    public function index()
    {

        $navbar = NavbarSetting::first();
        return view('admin.cms.navbar', compact('navbar'));
    }
    public function edit()
    {
        $navbar = NavbarSetting::first();
        return view('admin.navbar_settings.edit', compact('navbar'));
    }

    public function update(Request $request)
    {
        try {
            $navbar = NavbarSetting::first();

            $data = $request->validate([
                'title' => 'required|string|max:255',
                'logo' => 'nullable|image|mimes:jpeg,png,jpg,svg|max:2048',
            ]);

            if ($request->hasFile('logo')) {
                // Delete old logo if exists
                if ($navbar->logo && file_exists(public_path('storage/' . $navbar->logo))) {
                    unlink(public_path('storage/' . $navbar->logo));
                }

                $path = $request->file('logo')->store('uploads/navbar', 'public');
                $data['logo'] = $path;
            }

            $navbar->update($data);

            return response()->json([
                'message' => 'Navbar updated successfully.',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Something went wrong while updating the navbar.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
