<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Item;
use App\Models\Package;
use App\Models\Utility;
use App\Models\ItemOption;
use App\Models\PackageItem;
use Illuminate\Http\Request;
use App\Models\PackageUtility;
use App\Models\PackageItemOption;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class PackageController extends Controller
{
    /**
     * Display a listing of the resource.
     */



    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'name' => 'required|string|unique:packages,name|max:255',
                'description' => 'nullable|string',
                'price_per_person' => 'required|numeric|min:0.01',
                'min_pax' => 'required|integer|min:1',
                'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:10240',
                'item_ids' => 'required|array|min:1',
                'item_ids.*' => 'exists:items,id',
                'utility_ids' => 'nullable|array',
                'utility_ids.*' => 'exists:utilities,id',
                'item_options' => 'nullable|array',
                'item_options.*' => 'array',
            ]);
    
            // Handle image upload
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $validatedData['image'] = $this->handleImageUpload($image);
            }
    
            // Create the Package
            $package = Package::create([
                'name' => $validatedData['name'],
                'description' => $validatedData['description'] ?? null,
                'price_per_person' => $validatedData['price_per_person'],
                'min_pax' => $validatedData['min_pax'],
                'image' => $validatedData['image'] ?? null,
            ]);
    
            // Link Items & Options using existing logic
            foreach ($validatedData['item_ids'] as $itemId) {
                $optionIds = $validatedData['item_options'][$itemId] ?? [];
                $this->linkItemToPackage($package->id, $itemId, $optionIds);
            }
    
            // Link Utilities using existing logic
            if (!empty($validatedData['utility_ids'])) {
                $request->merge(['package_id' => $package->id]);
                $this->addUtilToPackage($request);
            }
    
            return response()->json([
                'success' => true,
                'message' => 'Package added successfully!',
                'package' => $package
            ]);
        } catch (Exception $e) {
            Log::error('Package creation error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while creating the package: ' . $e->getMessage(),
            ], 500);
        }
    }

    // link items to package
    public function linkItemToPackage($packageId, $itemId, array $itemOptionIds = [])
    {
        try {
            Log::debug('Linking Item to Package:', [
                'package_id' => $packageId,
                'item_id' => $itemId,
                'item_option_ids' => $itemOptionIds
            ]);

            // Get or create the PackageItem (respecting unique constraint)
            $packageItem = PackageItem::firstOrCreate([
                'package_id' => $packageId,
                'item_id' => $itemId
            ]);

            Log::debug('PackageItem Used:', ['package_item_id' => $packageItem->id]);

            $linkedOptions = [];
            $item = Item::with('itemOptions')->findOrFail($itemId);

            foreach ($itemOptionIds as $optionId) {
                $option = ItemOption::findOrFail($optionId);

                // Make sure this option belongs to the item
                if ($item->itemOptions->contains('id', $optionId)) {
                    // Avoid duplicate option link
                    $alreadyLinked = PackageItemOption::where('package_item_id', $packageItem->id)
                        ->where('item_option_id', $optionId)
                        ->exists();

                    if (!$alreadyLinked) {
                        PackageItemOption::create([
                            'package_item_id' => $packageItem->id,
                            'item_option_id' => $optionId
                        ]);

                        $linkedOptions[] = $option->type;
                    } else {
                        Log::info('Option already linked, skipping:', ['option_id' => $optionId]);
                    }
                } else {
                    Log::warning('Option does not belong to item', [
                        'option_id' => $optionId,
                        'item_id' => $itemId
                    ]);
                }
            }

            Log::debug('Linked Options:', ['linked_options' => $linkedOptions]);

            // return redirect()->back()->with('success', 'Item options linked successfully!');
            // return redirect()->back();
        } catch (Exception $e) {
            Log::error('Error linking item to package: ' . $e->getMessage(), [
                'exception' => $e->getTraceAsString()
            ]);
            return redirect()->back()->with('error', 'Failed to link item: ' . $e->getMessage());
        }
    }

    public function addItemToPackage(Request $request)
    {
        $validated = $request->validate([
            'package_id' => 'required|exists:packages,id',
            'item_id' => 'required|exists:items,id',
            'item_option_ids' => 'array',
            'item_option_ids.*' => 'exists:item_options,id'
        ]);
        Log::debug('Validated Request Data:', $validated);

        $result = $this->linkItemToPackage(
            $validated['package_id'],
            $validated['item_id'],
            $validated['item_option_ids'] ?? []
        );

        // return redirect()->back();
        return redirect()->back()->with('success', 'Item linked to package successfully!');

    }
    public function addUtilToPackage(Request $request)
    {
        try {
            $request->validate([
                'package_id' => 'required|exists:packages,id', 
                'utility_ids' => 'required|array',
                'utility_ids.*' => 'exists:utilities,id' 
            ]);

            $package = Package::findOrFail($request->package_id);

            // Loop through selected utility IDs and link them to the package
            foreach ($request->utility_ids as $utilityId) {
                // Check if the utility is already linked to the package
                $existingUtility = PackageUtility::where('package_id', $package->id)
                    ->where('utility_id', $utilityId)
                    ->first();

                // If not already linked, create a new association
                if (!$existingUtility) {
                    PackageUtility::create([
                        'package_id' => $package->id,
                        'utility_id' => $utilityId,
                    ]);
                }
            }
            // return redirect()->back()->with('success', 'Utilities linked to the package successfully.');
            return redirect()->back();
        } catch (Exception $e) {
            Log::error("Error linking utilities to package: " . $e->getMessage());

            // Return error response
            return redirect()->back()->with('error', 'An error occurred while linking utilities to the package. Please try again.');
        }
    }

    protected function handleImageUpload($image)
    {

        return basename($image->store('packagepics', 'public'));
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

        $package = Package::with(['packageItems.options.itemOption', 'utilities'])->find($id);

        if (!$package) {
            return response()->json([
                'success' => false,
                'message' => 'Package not found. Please try again.'
            ], 404);
        }
        Log::info('Package Data SHOWDETAILS FUNC:', $package->toArray());

        return response()->json([
            'success'   => true,
            'package'   => $package,
            'foods'     => $package->packageItems->map(function ($packageItem) {
                return [
                    'item' => $packageItem->item,
                    'options' => $packageItem->options->map(function ($option) {
                        return $option->itemOption;  // Returning itemOption details for frontend
                    })
                ];
            }),
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
    public function showItemsOnPackage($id)
    {
        $package = Package::with([
            'packageItems.item',
            'packageItems.options.itemOption',
            'utilities'
        ])->findOrFail($id);

        return view('packages.show', compact('package'));
    }

    public function removeItemFromPackage(Request $request, $packageId)
    {
        $request->validate([
            'items_to_remove' => 'array|nullable',
            'options' => 'array|nullable',
        ]);


        $package = Package::findOrFail($packageId);

        if ($request->has('items_to_remove')) {

            foreach ($request->input('items_to_remove') as $packageItemId) {

                $packageItem = $package->packageItems()->findOrFail($packageItemId);
                $packageItem->delete();
            }
        }
        if ($request->has('options')) {

            foreach ($request->input('options') as $optionId) {

                $packageItemOption = PackageItemOption::findOrFail($optionId);
                $packageItemOption->delete();
            }
        }
        return redirect()->route('package.show', $packageId)->with('success', 'Items and/or options removed successfully.');
    }
    // KUNIN NYA MGA NKA LINK NA UTILS AS PACKAGE
    public function getUtilitiesForPackage(Request $request)
    {
        $packageId = $request->input('package_id');

        $package = Package::findOrFail($packageId);

        $utilities = Utility::all();

        // utils associated sa package
        $linkedUtilities = $package->utilities->pluck('id')->toArray();


        return response()->json([
            'utilities' => $utilities,
            'linked_utilities' => $linkedUtilities,
        ]);
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


            $package = Package::findOrFail($id);

            if ($request->hasFile('image')) {
                if ($package->image) {
                    Storage::disk('public')->delete('packagepics/' . $package->image);
                }

                // Store the new image 
                $image = $request->file('image');
                $data['image'] = $this->handleImageUpload($image);
            } else {
                unset($data['image']);
            }

            $package->update($data);

            return redirect()->back()->with('success', 'Package updated successfully!');
        } catch (Exception $e) {
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
            Storage::disk('public')->delete('packagepics/' . $package->image);
        }

        $package->delete();
        return redirect()->back()->with('success', 'Package deleted successfully!');
    }
}
