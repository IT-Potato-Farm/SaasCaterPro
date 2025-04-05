<?php

namespace App\Http\Controllers;

use App\Models\Package;
use App\Models\PackageItem;
use Illuminate\Http\Request;
use App\Models\PackageItemOption;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class PackageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index() {}

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
                'name' => 'required|string|unique:packages,name|max:255',
                'description' => 'nullable|string',
                'price_per_person' => 'required|numeric|min:0',
                'min_pax' => 'required|integer|min:1',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:10240',
                'status' => 'required|in:available,unavailable',
            ]);

            $packageitemFields['name'] = strip_tags($packageitemFields['name']);
            $packageitemFields['description'] = strip_tags($packageitemFields['description']);

            if ($request->hasFile('image')) {
                $image = $request->file('image');
                // Call the helper function to handle image upload
                $packageitemFields['image'] = $this->handleImageUpload($image);
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

    protected function handleImageUpload($image)
    {
        
        return $image->store('packagepics', 'public');
    }

    public function showPackageDetails($id)
    {
        // Load the package along with package items, each item's menu item, and the menu item's category.
        $package = Package::with('package_items.menu_item.category')->findOrFail($id);

        // filter package items dynamically by category name.
        $foods = $package->package_items->filter(function ($packageItem) {
            return optional($packageItem->menu_item->category)->name === 'Foods';
        });

        $utilities = $package->package_items->filter(function ($packageItem) {
            return optional($packageItem->menu_item->category)->name === 'Utilities';
        });

        return response()->json([
            'success'   => true,
            'package'   => $package,
            'foods'     => $foods,
            'utilities' => $utilities,
        ]);
    }
    public function showdetails($id)
    {
        // If you want to include PackageItem options, eager load the 'options' relationship.
        $package = Package::with(['packageItems.options', 'utilities'])->find($id);

        if (!$package) {
            return response()->json([
                'success' => false,
                'message' => 'Package not found. Please try again.'
            ], 404);
        }

        return response()->json([
            'success'   => true,
            'package'   => $package,
            // Return packageItems as 'foods' to match your frontend.
            'foods'     => $package->packageItems,
            'utilities' => $package->utilities,
        ]);
    }

    public function checkName(Request $request)
    {
        $name = $request->query('name');
        $exists = Package::where('name', $name)->exists();
        return response()->json(['available' => !$exists]);
    }
    public function checkOptionType(Request $request)
    {
        $type = $request->query('type');
        $packageFoodItemId = $request->query('package_food_item_id');

        $exists = PackageItemOption::where('type', $type)
            ->where('package_food_item_id', $packageFoodItemId)
            ->exists();

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
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:10240',
                'status' => 'required|in:available,unavailable',
            ]);

            $data['name'] = strip_tags($data['name']);
            $data['description'] = isset($data['description']) ? strip_tags($data['description']) : null;
            $package = Package::findOrFail($id);

            if ($request->hasFile('image')) {
                if ($package->image) {
                    Storage::disk('public')->delete($package->image);
                }
    
                // Store the new image 
                $image = $request->file('image');
                $data['image'] = $this->handleImageUpload($image);
            } else {
                unset($data['image']);
            }

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
    public function deletePackage($id)
    {
        $package = Package::findOrFail($id);

        if ($package->image) {
            Storage::disk('public')->delete($package->image);
        }

        $package->delete();
        return redirect()->back()->with('success', 'Package deleted successfully!');
    }
}
