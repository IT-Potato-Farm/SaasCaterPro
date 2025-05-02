<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Package;
use App\Models\Category;
use App\Models\ItemOption;
use App\Models\PackageItem;
use Illuminate\Http\Request;
use App\Models\PackageItemOption;
use Illuminate\Support\Facades\Storage;

class ItemOptionController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'type' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'items' => 'nullable|array',
            'items.*' => 'exists:items,id',
            'category_id' => 'nullable|exists:categories,id', 
        ]);

        if ($request->hasFile('image')) {
            $data['image'] = $this->handleImageUpload($request->file('image'));
        }

        $itemOption = ItemOption::create([
            'type' => $data['type'],
            'description' => $data['description'] ?? null,
            'image' => $data['image'] ?? null,
            'category_id' => $data['category_id'] ?? null, // Save if exists

        ]);

        if (!empty($data['items'])) {
            $itemOption->items()->attach($data['items']);
        }


        return response()->json([
            'success' => true,
            'message' => 'Item option added successfully',
            'item_option' => $itemOption
        ]);
    }

    // LINK ITEMS SA PACKAGE
    public function getOptions(Request $request)
    {
        $categoryId = $request->query('category');

        $query = ItemOption::query();

        // Apply category filter if provided
        if ($categoryId) {
            $query->where('category_id', $categoryId);  // Use 'category_id' instead of 'category'
        }
        $options = $query->with('category')  // Assuming you have a category relationship
        ->get(['id', 'type', 'category_id']);

        $options->transform(function($option) {
        $option->category_name = $option->category->name ?? 'No category';  // Safely access category name
        return $option;
    });

        return response()->json($options);
    }
    public function getCategories(Request $request)
    {
        return response()->json(Category::all());
    }



    public function update(Request $request, $itemOptionId)
    {
        $data = $request->validate([
            'type' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category_id' => 'nullable|exists:categories,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($request->has('category_id') && $request->input('category_id') === '') {
            $data['category_id'] = null;
        }


        $itemOption = ItemOption::findOrFail($itemOptionId);


        if ($request->hasFile('image')) {
            if ($itemOption->image) {
                Storage::disk('public')->delete($itemOption->image);
            }

            $data['image'] = $this->handleImageUpload($request->file('image'));
        } else {

            $data['image'] = $itemOption->image;
        }

        $itemOption->update($data);
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Item Option updated successfully!'
            ]);
        }


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

        // Attach using the pivot table
        $item->itemOptions()->attach($request->item_option_ids);

        return redirect()->back()->with('success', 'Item options linked successfully!');
    }
    // REMOVE ITEM OPTION SA ITEM
    public function unlinkItemOptionFromItem(Request $request)
    {
        $request->validate([
            'item_id' => 'required|exists:items,id',
            'item_option_id' => 'required|exists:item_options,id',
        ]);

        $item = Item::findOrFail($request->item_id);
        $item->itemOptions()->detach($request->item_option_id);

        return redirect()->back()->with('success', 'Item option removed successfully!');
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
