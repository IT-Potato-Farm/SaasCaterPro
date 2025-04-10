<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Package;
use App\Models\MenuItem;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        $request->validate([
            'query' => 'nullable|string|max:255',
        ]);

        $query = $request->input('query');

        // If search is empty, redirect 
        if (empty($query)) {
            return redirect()->back();
        }

        $menuItems = MenuItem::where('status', 'available')
            ->where(function ($q) use ($query) {
                $q->where('name', 'like', "%{$query}%")
                    ->orWhere('description', 'like', "%{$query}%");
            })
            ->with('category')
            ->get();

        // 2. Search items (can be used in packages)
        $items = Item::where(function ($q) use ($query) {
            $q->where('name', 'like', "%{$query}%")
                ->orWhere('description', 'like', "%{$query}%");
        })
            ->with(['itemOptions' => function ($q) use ($query) {
                $q->where('type', 'like', "%{$query}%")
                    ->orWhere('description', 'like', "%{$query}%");
            }])
            ->get();

        // 3. Search packages that:
        // - Have matching name/description
        // - OR have items matching query
        // - OR have item options (through PackageItemOptions) matching query
        $packages = Package::available()
            ->where(function ($q) use ($query) {
                $q->where('name', 'like', "%{$query}%")
                    ->orWhere('description', 'like', "%{$query}%");
            })
            ->orWhereHas('packageItems.item', function ($q) use ($query) {
                $q->where('name', 'like', "%{$query}%")
                    ->orWhere('description', 'like', "%{$query}%");
            })
            ->orWhereHas('packageItems.options.itemOption', function ($q) use ($query) {
                $q->where('type', 'like', "%{$query}%")
                    ->orWhere('description', 'like', "%{$query}%");
            })
            ->with([
                'packageItems.item',
                'packageItems.options.itemOption',
                'category',
                'utilities'
            ])
            ->get();

        return view('search.results', compact('query', 'menuItems', 'items', 'packages'));
    }
}
