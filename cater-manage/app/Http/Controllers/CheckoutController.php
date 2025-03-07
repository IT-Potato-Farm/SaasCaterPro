<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    public function show()
    {
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login')->with('error', 'You need to log in first.');
        }

        $cart = $user->cart;
        if (!$cart || $cart->items->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }

        $totalPrice = $cart->items->sum(function ($item) {
            $price = $item->menu_item_id ? $item->menuItem->price : $item->package->price_per_person;
            return $price * $item->quantity;
        });

        return view('cart.checkout', compact('cart', 'totalPrice'));
    }
}
