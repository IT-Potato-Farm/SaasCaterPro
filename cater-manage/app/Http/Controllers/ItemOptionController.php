<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\ItemOption;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ItemOptionController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'type' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $data['image'] = $this->handleImageUpload($request->file('image'));
        }

        $itemOption = ItemOption::create($data);

        return response()->json([
            'success' => true,
            'message' => 'Item option added successfully',
            'item_option' => $itemOption
        ]);
    }


    public function update(Request $request, $itemOptionId)
    {
        $data = $request->validate([
            'type' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $itemOption = ItemOption::findOrFail($itemOptionId);


        if ($request->hasFile('image')) {
            if ($itemOption->image) {
                Storage::disk('public')->delete($itemOption->image);
            }

            $data['image'] = $this->handleImageUpload($request->file('image'));
        }

        $itemOption->update($data);
        return redirect()->back()->with('success', 'Item Option updated successfully!');
    }

    public function destroy($itemOptionId)
    {
        $itemOption = ItemOption::findOrFail($itemOptionId);

        if ($itemOption->image) {
            Storage::disk('public')->delete($itemOption->image);
        }

        $itemOption->delete();


        return redirect()->back()->with('success', 'Item Option deleted successfully!');
    }

    protected function handleImageUpload($image)
    {
        return $image->store('item_option_images', 'public');
    }

    public function checkType(Request $request)
    {
        $type = $request->input('type');

        $exists = ItemOption::where('type', $type)->exists();

        return response()->json(['exists' => $exists]);
    }
    public function linkItemOptionToItem(Request $request)
    {
        // Validate input
        $request->validate([
            'item_id' => 'required|exists:items,id',
            'item_option_ids' => 'required|array',
            'item_option_ids.*' => 'exists:item_options,id',
        ]);

        $item = Item::find($request->item_id);

        // Attach the item options to the item using the pivot table
        $item->itemOptions()->attach($request->item_option_ids);

        return redirect()->back()->with('success', 'Item options linked successfully!');
    }

    public function getItemOptions($itemId)
    {
        $itemOptions = ItemOption::where('item_id', $itemId)->get();

        return response()->json([
            'options' => $itemOptions
        ]);
    }
    public function getExistingItemOptionsForItem($itemId)
    {
        $existingOptions = Item::find($itemId)->itemOptions()->pluck('item_options.id')->toArray();

        return response()->json($existingOptions);
    }
}
