<?php

namespace App\Http\Controllers;

use App\Models\MenuItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

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
    public function create() {}

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $menuitemFields = $request->validate([
                'category_id' => 'required|exists:categories,id',
                'name' => 'required|string|max:255',
                'description' => 'required|string',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:10240',
                'pricing.10-15' => 'required|numeric|min:1',
                'pricing.15-20' => 'required|numeric|min:1',
            ]);

            

            
            if ($request->hasFile('image')) {
                $menuitemFields['image'] = $this->handleImageUpload($request->file('image'));
            }

            $menu = MenuItem::create($menuitemFields);

            return response()->json([
                'success' => true,
                'message' => 'Item added successfully!',
                'data' => $menu
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'errors' => $e->errors(),
                'message' => 'Validation failed'
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to add item: ' . $e->getMessage()
            ], 500);
        }
    }

    protected function handleImageUpload($image)
    {

        return basename($image->store('party_traypics', 'public'));
    }
    public function checkNameAvailability(Request $request)
    {
        $name = $request->input('name');
        $exists = MenuItem::where('name', $name)->exists();

        return response()->json([
            'available' => !$exists
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
    public function editItem(Request $request,  $id)
    {
        $itemFields = $request->validate([
            'name' => 'required',
            'description' => 'required',
            // 'price' => 'required|numeric|min:0',
            'category_id' => 'required|exists:categories,id',
            'pricing.10-15'     => 'required|numeric|min:1',
            'pricing.15-20'     => 'required|numeric|min:1',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'required|in:available,unavailable',
        ]);
       

        $item = MenuItem::findOrFail($id);

        if ($request->hasFile('image')) {

            Storage::disk('public')->delete('party_traypics/' . $item->image);
            $itemFields['image'] = $this->handleImageUpload($request->file('image'));
        }
        $item->update($itemFields);
        return redirect()->back()->with('success', 'Item updated successfully!');
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
    public function deleteItem($id)
    {
        $menuItem = MenuItem::findOrFail($id);
        if ($menuItem->image) {
            Storage::disk('public')->delete($menuItem->image);
        }

        $menuItem->delete();

        return redirect()->back()->with('success', 'Party tray deleted successfully!');
    }
}
