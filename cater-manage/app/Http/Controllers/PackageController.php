<?php

namespace App\Http\Controllers;

use App\Models\Package;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class PackageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        
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
            $packageitemFields = $request->validate([
                'category_id' => 'nullable|exists:categories,id',
                'name' => 'required|string|max:255',
                'description' => 'nullable|string',
                'price_per_person' => 'required|numeric|min:0',
                'min_pax' => 'required|integer|min:1',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:10240',
                'status' => 'required|in:available,not available',
            ]);

            $packageitemFields['name'] = strip_tags($packageitemFields['name']);
            $packageitemFields['description'] = strip_tags($packageitemFields['description']);

            $imageFolder = public_path('packagePics');
            if (!is_dir(public_path('packagePics'))) {
                mkdir(public_path('packagePics'), 0777, true);
            }

            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $imageName = time() . '_' . $image->getClientOriginalName();
                $image->move($imageFolder, $imageName);
                // Store only the filename, not the full path
                $packageitemFields['image'] = $imageName;
            }

            $package = Package::create($packageitemFields);

            return response()->json([
                'success' => true,
                'message' => 'Package added successfully!',
                'package' => $package
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }
    public function checkName(Request $request)
{
    $name = $request->query('name');
    $exists = Package::where('name', $name)->exists();
    return response()->json(['available' => !$exists]);
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
    public function editPackage(Request $request, $id)
    {
        try {
            $data = $request->validate([
                'category_id'       => 'nullable|exists:categories,id',
                'name'              => 'required|string|max:255',
                'description'       => 'nullable|string',
                'price_per_person'  => 'required|numeric|min:0',
                'min_pax'           => 'required|integer|min:1',
            ]);
    
            $data['name'] = strip_tags($data['name']);
            $data['description'] = isset($data['description']) ? strip_tags($data['description']) : null;
            $package = Package::findOrFail($id);

            $package->update($data);
            return redirect()->back()->with('success', 'Package updated successfully!');
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
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
    public function deletePackage( $id)
    {
        $package = Package::findOrFail($id);
        if ($package->image && File::exists(public_path('packagePics/' . $package->image))) {
            File::delete(public_path('packagePics/' . $package->image));
        }
        $package->delete();
        return redirect()->back()->with('success', 'Package deleted successfully!');
    }
}
