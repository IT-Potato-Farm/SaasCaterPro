<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PackageUtility;

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

            // Sanitize text inputs
            $fields['name'] = strip_tags($fields['name']);
            $fields['description'] = isset($fields['description']) ? strip_tags($fields['description']) : null;
            
            if ($request->hasFile('image')) {
                $destinationPath = public_path('packageUtilityPics');
                if (!is_dir($destinationPath)) {
                    mkdir($destinationPath, 0777, true);
                }
                $image = $request->file('image');
                $imageName = time() . '_' . $image->getClientOriginalName();
                $image->move($destinationPath, $imageName);
                $fields['image'] = $imageName;
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
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
