<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PackageUtility;
use Illuminate\Support\Facades\Storage;

class PackageUtilityController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $fields = $request->validate([
                'package_id'  => 'required|exists:packages,id',
                'name'        => 'required|string|unique:package_utilities,name|max:255',
                'description' => 'nullable|string',
                'quantity'    => 'required|integer|min:1',
                'image'       => 'nullable|image|mimes:jpeg,png,jpg,gif|max:10240', // max 10MB
            ]);

           

            if ($request->hasFile('image')) {
                $fields['image'] = $this->handleImageUpload($request->file('image'));
            }
            $utility = PackageUtility::create($fields);

            return response()->json([
                'success'         => true,
                'message'         => 'Package utility added successfully!',
                'package_utility' => $utility,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }
    protected function handleImageUpload($image)
    {
        return basename($image->store('packageUtilities', 'public'));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $utility = PackageUtility::findOrFail($id);

            $data = $request->validate([
                'package_id'  => 'required|exists:packages,id',
                'name'        => 'required|string|max:255|unique:package_utilities,name,' . $utility->id,
                'description' => 'nullable|string',
                'quantity'    => 'required|integer|min:1',
                'image'       => 'nullable|image|mimes:jpeg,png,jpg,gif|max:10240',
            ]);

            

            if ($request->hasFile('image')) {
                if ($utility->image && Storage::disk('public')->exists('packageUtilities/' . $utility->image)) {
                    Storage::disk('public')->delete('packageUtilities/' . $utility->image);
                }

                // Store the new image
                $data['image'] = basename($request->file('image')->store('packageUtilities', 'public'));
            }

            $utility->update($data);

            session()->flash('success', 'Package utility updated successfully!');

            return back();
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $utility = PackageUtility::findOrFail($id);

            if ($utility->image && Storage::disk('public')->exists('packageUtilities/' . $utility->image)) {
                Storage::disk('public')->delete('packageUtilities/' . $utility->image);
            }

            $utility->delete();

            session()->flash('success', 'Package utility deleted successfully!');

            return back();
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}
