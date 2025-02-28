<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\MenuItem;
use Illuminate\Http\Request;

class MenuItemController extends Controller
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
        $menus = Menu::all();
        return view('menu-items.create', compact('menus'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $menuitemFields = $request->validate([
                'menu_id' => 'required|exists:menus,id',
                'category_id' => 'required|exists:categories,id',
                'name' => 'required|string|max:255',
                'description' => 'required|string',
                'price' => 'required|numeric|min:0',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:10240',
                'status' => 'required|in:available,unavailable',
            ]);

            $menuitemFields['name'] = strip_tags($menuitemFields['name']);
            $menuitemFields['description'] = strip_tags($menuitemFields['description']);

            $imageFolder = public_path('ItemsStored');
            if (!is_dir(public_path('ItemsStored'))) {
                mkdir(public_path('ItemsStored'), 0777, true);
            }

            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $imageName = time() . '_' . $image->getClientOriginalName(); // Unique name
                $image->move($imageFolder, $imageName); // Move image to ItemsStored
                $menuitemFields['image'] = 'ItemsStored/' . $imageName; // Save relative path in DB
            }

            $menu = MenuItem::create($menuitemFields);

            return response()->json([
                'success' => true,
                'message' => 'Item added successfully!',
                'menu' => $menu
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
