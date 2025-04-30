<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\ItemOption;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Log;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $items = Item::all();

            return response()->json([
                'success' => true,
                'message' => 'Items retrieved successfully!',
                'items'   => $items
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }
    public function checkName(Request $request)
    {
        $exists = Item::where('name', $request->name)->exists();
        return response()->json(['exists' => $exists]);
    }

    /**
     * Store a newly created resource in storage.
     */

    //  ITEM STORE LIKE CHICKEN BEEF
    public function store(Request $request)
    {
        try {
            //validation
            $fields = $request->validate([
                'name' => [
                    'required',
                    'string',
                    'max:255',
                    Rule::unique('items')->where(function ($query) use ($request) {
                        return $query->where('name', $request->name);
                    })
                ],
                'description' => 'nullable|string',
                'options' => 'nullable|array',
                'options.*' => 'exists:item_options,id',
            ]);

            $item = Item::create($fields);
            if (!empty($request->options)) {
                $item->itemOptions()->attach($request->options);
            }

            return response()->json([
                'success' => true,
                'message' => 'Item created and linked to options successfully!',
                'item'    => $item
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
        try {

            $data = $request->validate([
                'name' => 'required|string|max:255',
                'description' => 'nullable|string',
                'selected_options' => 'nullable|array',
                'selected_options.*' => 'exists:item_options,id',
            ]);




            $item = Item::findOrFail($id);

            $item->update($data);

            if ($request->has('selected_options') && is_array($request->selected_options)) {
                // Clear previous options in the pivot table and insert the selected ones
                $item->itemOptions()->sync($request->input('selected_options'));
            } else {
                $item->itemOptions()->detach();
            }
            return redirect()->back()->with('success', 'Item updated successfully!');
        } catch (\Exception $e) {
            Log::error("Error updating item: " . $e->getMessage());

            return redirect()->back()->with('error', 'Error updating item: ' . $e->getMessage());
        }
    }

    // LINK FRIED TO CHICKEN ETC
    public function linkItemOptionToItem(Request $request, $itemId)
    {
        $item = Item::findOrFail($itemId);

        // Get the selected item options from the request
        $itemOptionIds = $request->input('item_options');

        // Link the selected item options to the item
        foreach ($itemOptionIds as $itemOptionId) {
            $itemOption = ItemOption::findOrFail($itemOptionId);
            $itemOption->item()->associate($item);
            $itemOption->save();
        }
        return redirect()->back()->with('success', 'Item options linked successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $item = Item::findOrFail($id);
            $item->delete();

            return redirect()->back()->with('success', 'Item ulam deleted successfully!');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to delete item: ' . $e->getMessage());
        }
    }
}
