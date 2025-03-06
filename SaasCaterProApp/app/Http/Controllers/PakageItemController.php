<?php

namespace App\Http\Controllers;

use App\Models\Package;
use App\Models\MenuItem;
use App\Models\PackageItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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

    public function store(Request $request)
    {
        $request->validate([
            'package_id' => 'required|exists:packages,id',
            'menu_item_ids' => 'required|array',
            'menu_item_ids.*' => 'exists:menu_items,id',
        ]);

        foreach ($request->menu_item_ids as $menu_item_id) {
            // Check if the menu item already exists in the package
            $exists = PackageItem::where('package_id', $request->package_id)
                ->where('menu_item_id', $menu_item_id)
                ->exists();

            if (!$exists) {
                PackageItem::create([
                    'package_id' => $request->package_id,
                    'menu_item_id' => $menu_item_id,
                ]);
            }
        }

        return redirect()->back()->with('success', 'Items added to the package successfully.');
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
