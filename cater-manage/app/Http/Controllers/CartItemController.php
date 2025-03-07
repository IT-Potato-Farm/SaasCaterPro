<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartItemController extends Controller
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
    public function update(Request $request, CartItem $cartItem)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1'
        ]);
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login')->with('error', 'You need to log in first.');
        }

        // Ensure the cart item belongs to the authenticated user's cart.
        if ($cartItem->cart->user_id !== $user->id) {
            return redirect()->route('cart.index')->with('error', 'Unauthorized action.');
        }

        // Update the cart item's quantity.
        $cartItem->update([
            'quantity' => $request->quantity,
        ]);

        return redirect()->route('cart.index')->with('success', 'Cart item updated.');
    }
    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CartItem $cartItem)
    {
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login')->with('error', 'You need to log in first.');
        }

        // Ensure the cart item belongs to the authenticated user's cart.
        if ($cartItem->cart->user_id !== $user->id) {
            return redirect()->route('cart.index')->with('error', 'Unauthorized action.');
        }

        $cartItem->delete();

        return redirect()->route('cart.index')->with('success', 'Cart item removed.');
    }
}
