<?php

namespace App\Http\Controllers;

use App\Models\Package;
use App\Models\MenuItem;
use App\Models\PackageItem;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use App\Models\PackageItemOption;

class PackageItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $packageItems = PackageItem::with(['package', 'menuItem'])->get();
        return view('package_items.index', compact('packageItems'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $packages = Package::all();
        $menuItems = MenuItem::all();
        return view('package_items.create', compact('packages', 'menuItems'));
    }

    /**
     * Store a newly created resource in storage.
     */

    // public function store(Request $request)
    // {
    //     $request->validate([
    //         'package_id' => 'required|exists:packages,id',
    //         'menu_item_id' => 'required|exists:menu_items,id',
    //     ]);

    //     PackageItem::create($request->all());

    //     return redirect()->route('package_items.index')->with('success', 'Package item added successfully.');
    // }

    // this is the function during the mock defense for package item
    // public function store(Request $request)
    // {
    //     $request->validate([
    //         'package_id' => 'required|exists:packages,id',
    //         'menu_item_ids' => 'required|array',
    //         'menu_item_ids.*' => 'exists:menu_items,id',
    //     ]);

    //     foreach ($request->menu_item_ids as $menu_item_id) {
    //         // Check if the menu item already exists in the package
    //         $exists = PackageItem::where('package_id', $request->package_id)
    //             ->where('menu_item_id', $menu_item_id)
    //             ->exists();

    //         if (!$exists) {
    //             PackageItem::create([
    //                 'package_id' => $request->package_id,
    //                 'menu_item_id' => $menu_item_id,
    //             ]);
    //         }
    //     }

    //     return redirect()->back()->with('success', 'Items added to the package successfully.');
    // }
    public function store(Request $request)
    {
        try {
            $fields = $request->validate([
                'package_id'  => 'required|exists:packages,id',
                'name' => [
                    'required',
                    'string',
                    'max:255',
                    Rule::unique('package_items')->where(function ($query) use ($request) {
                        return $query->where('package_id', $request->package_id);
                    })
                ],
                'description' => 'nullable|string',
            ]);

           

            $packageItem = PackageItem::create($fields);

            return response()->json([
                'success'      => true,
                'message'      => 'Package item added successfully!',
                'package_item' => $packageItem
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }
    public function massstore(Request $request)
    {
        try {
            $fields = $request->validate([
                'package_id'       => 'required|exists:packages,id',
                'package_item_ids' => 'required|array',
                'package_item_ids.*' => 'exists:package_items,id',
            ]);

            // Get the selected package
            $package = Package::findOrFail($fields['package_id']);

            // Assign package_id to selected package items
            PackageItem::whereIn('id', $fields['package_item_ids'])
                ->update(['package_id' => $package->id]);

            return response()->json([
                'success' => true,
                'message' => 'Package items added successfully!',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }
    // function para iadd yung pagkain like chicken into types like fried etc

    public function optionstore(Request $request)
    {
        try {
            // Validate 
            $fields = $request->validate([
                'package_food_item_id' => 'required|exists:package_items,id',
                'type'                 => 'required|string|unique:package_food_item_options,type|max:255',
                'description'          => 'nullable|string',
                'image'       => 'nullable|image|mimes:jpeg,png,jpg,gif|max:10240' // 10MB
            ]);


            
            if ($request->hasFile('image')) {
                $destinationPath = public_path('packageItemOptionPics');
                if (!is_dir($destinationPath)) {
                    mkdir($destinationPath, 0777, true);
                }
                $image = $request->file('image');
                $imageName = time() . '_' . $image->getClientOriginalName();
                $image->move($destinationPath, $imageName);
                $fields['image'] = $imageName;
            }


            // food item option record
            $option = PackageItemOption::create($fields);

            return response()->json([
                'success'                  => true,
                'message'                  => 'Food item option added successfully!',
                'package_food_item_option' => $option,
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
        $exists = PackageItem::where('name', $request->name)
            ->where('package_id', $request->package_id)
            ->exists();
        return response()->json(['exists' => $exists]);
    }



    /**
     * Display the specified resource.
     */
    public function show(PackageItem $packageItem)
    {
        //
    }
    public function getExistingMenuItems($packageId)
    {
        $existingItems = PackageItem::where('package_id', $packageId)
            ->pluck('menu_item_id')
            ->toArray();

        return response()->json($existingItems);
    }
    public function getExistingPackageItems($packageId)
    {
        $existingItems = PackageItem::where('package_id', $packageId)->pluck('id')->toArray();

        return response()->json($existingItems);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PackageItem $packageItem)
    {
        $packages = Package::all();
        $menuItems = MenuItem::all();
        return view('package_items.edit', compact('packageItem', 'packages', 'menuItems'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PackageItem $packageItem)
    {
        $request->validate([
            'package_id' => 'required|exists:packages,id',
            'menu_item_id' => 'required|exists:menu_items,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $packageItem->update($request->all());

        return redirect()->route('package_items.index')->with('success', 'Package item updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PackageItem $packageItem)
    {
        $packageItem->delete();
        return redirect()->route('package_items.index')->with('success', 'Package item deleted successfully.');
    }
}
