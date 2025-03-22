<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\Package;
use App\Models\MenuItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();


        // fetch or crreate cart
        $cart = $user->cart ?? Cart::create(['user_id' => $user->id]);
        $pendingOrder = Order::where('user_id', Auth::id())->where('status', 'pending')->first();

        // get products to display sda cart index
        $menuItems = MenuItem::where('status', 'available')->get();
        $packages = Package::where('status', 'available')->get();
        return view('cart.index', compact('cart', 'pendingOrder', 'menuItems', 'packages'));
    }

    public function add(Request $request)
    {
        $user = Auth::user();

        if (!$user) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'You need to log in first.'], 401);
            }
            return redirect()->route('login')->with('error', 'You need to log in first.');
        }

        $cart = $user->cart ?? Cart::create(['user_id' => $user->id]);

        $validated = $request->validate([
            'menu_item_id' => 'nullable|exists:menu_items,id',
            'package_id'   => 'nullable|exists:packages,id',
            'quantity'     => 'required|integer|min:1',
            'variant'      => 'nullable|string',
            'selected_options' => 'nullable|array'
        ]);

        if (empty($validated['menu_item_id']) && empty($validated['package_id'])) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Please select an item or package.'], 422);
            }
            return redirect()->back()->with('error', 'Please select an item or package.');
        }

        $errors = [];
        $successMessages = [];


        if (!empty($validated['package_id'])) {
            // CALCULATE LAHAT NG QUANTITY NG PACKAGE SA CART 
            $totalPackageCount = $cart->items()->whereNotNull('package_id')->sum('quantity');

            if ($totalPackageCount >= 2) {
                $errors[] = 'You can only add up to 2 package sets per event.';
            } else {
                //  maximum quantity 
                $available = 2 - $totalPackageCount;

                $quantityToAdd = min($validated['quantity'], $available);

                // CHECK IF MERON NA EXISTING PACKAGE SA CART 
                $existingPackageItem = $cart->items()->where('package_id', $validated['package_id'])->first();
                if ($existingPackageItem) {
                    // UPDATE NG QUANTITY AND GINA MAKE SURE NA HINDI MAG EXCEED SA OVERALL LIMIT NA 2 
                    $newQuantity = min($existingPackageItem->quantity + $quantityToAdd, 2);
                    $existingPackageItem->update([
                        'quantity' => $newQuantity,
                        // Update selected options if provided (you may choose to merge or replace).
                        'selected_options' => $request->input('selected_options')
                    ]);
                    $successMessages[] = 'Package updated in cart.';
                } else {
                    // Create a new package cart item with the allowed quantity.
                    $validated['quantity'] = $quantityToAdd;
                    $validated['selected_options'] = $request->input('selected_options');
                    $cart->items()->create($validated);
                    $successMessages[] = 'Package added to cart.';
                }
            }
        }


        if (!empty($validated['menu_item_id'])) {
            $menuData = [
                'menu_item_id' => $validated['menu_item_id'],
                'quantity'     => $validated['quantity']
            ];
            if (!empty($validated['variant'])) {
                $menuData['variant'] = $validated['variant'];
            }

            $existingMenuItem = $cart->items()
                ->where('menu_item_id', $validated['menu_item_id'])
                ->where('variant', $validated['variant'] ?? null)
                ->first();

            if ($existingMenuItem) {
                $existingMenuItem->update([
                    'quantity' => $existingMenuItem->quantity + $validated['quantity']
                ]);
                $successMessages[] = 'Menu item updated in cart.';
            } else {
                $cart->items()->create($menuData);
                $successMessages[] = 'Menu item added to cart.';
            }
        }

        if (!empty($errors)) {
            $errorMessage = implode(' ', $errors);
            if ($request->expectsJson()) {
                return response()->json(['message' => $errorMessage], 422);
            }
            return redirect()->back()->with('error', $errorMessage);
        }

        $message = implode(' ', $successMessages);
        if ($request->expectsJson()) {
            return response()->json(['message' => $message], 200);
        }
        return redirect()->route('cart.index')->with('success', $message);
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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Cart $cart)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Cart $cart)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Cart $cart)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Cart $cart) {}
}
