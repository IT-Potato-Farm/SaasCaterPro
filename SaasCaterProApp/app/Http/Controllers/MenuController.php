<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\MenuItem;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $menus = Menu::all();
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
    public function addMenu(Request $request)
    {
        $menuFields = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string'
        ]);

        $menuFields['name'] = strip_tags($menuFields['name']);
        $menuFields['description'] = strip_tags($menuFields['description']);

        $menu = Menu::create($menuFields);

        return response()->json([
            'success' => true,
            'message' => 'Menu added successfully!',
            'menu' => $menu
        ]);
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
    public function editItem(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function editMenu(Request $request, string $id)
    {
        $menuFields = $request->validate([
            'name' => 'required',
            'description' => 'required'
        ]);
        $menuFields['name'] = strip_tags($menuFields['name']);
        $menuFields['description'] = strip_tags($menuFields['description']);
        // hanapin nya muna ung id
        $menu = Menu::findOrFail($id);

        // Update sa db
        $menu->update($menuFields);
        return redirect()->back()->with('success', 'Menu updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function deleteMenu($id)
    {
        $menu = Menu::findOrFail($id);
        $menu->delete();
        return redirect()->back()->with('success', 'Menu deleted successfully!');
    }
    public function getMenuDetails($id)
    {
        $menu = MenuItem::with('category')->find($id);

        if (!$menu) {
            return response()->json(['error' => 'Menu item not found'], 404);
        }

        return response()->json([
            'id' => $menu->id,
            'name' => $menu->name,
            'description' => $menu->description,
            'price' => $menu->price,
            'image' => asset("ItemsStored/" . $menu->image),
            'category' => $menu->category->name ?? 'Uncategorized',
            'items' => json_decode($menu->items, true) ?? []
        ]);
    }
}
