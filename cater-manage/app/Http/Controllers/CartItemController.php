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
    public function update(Request $request, $id)
    {
        $cartItem = CartItem::findOrFail($id);

        $action = $request->input('action');
        $currentQuantity = $cartItem->quantity;
        if ($action === 'decrement') {
            // bawas quantity
            if ($currentQuantity > 1) {
                $cartItem->quantity = $currentQuantity - 1;
                $cartItem->save();
            } else {
                // delete nya if maging 0 yung quantity sa cart
                $cartItem->delete();
            }
        } elseif ($action === 'increment') {
            $cartItem->quantity = $currentQuantity + 1;
            $cartItem->save();
        }

        return redirect()->back()->with('success', 'Cart updated successfully.');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $cartItem = CartItem::findOrFail($id);
        $cartItem->delete();

        return redirect()->back()->with('success', 'Item removed from cart.');
    }
}
