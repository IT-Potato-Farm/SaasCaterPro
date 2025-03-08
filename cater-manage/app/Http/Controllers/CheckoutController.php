<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
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

        // de maka order ung user if may pending order na sya
        $pendingOrder = Order::where('user_id', $user->id)
        ->where('status', 'pending')
        ->first();
        

        $cart = $user->cart;
        if (!$cart || $cart->items->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }

        $totalPrice = $cart->items->sum(function ($item) {
            $price = $item->menu_item_id ? $item->menuItem->price : $item->package->price_per_person;
            return $price * $item->quantity;
        });

        return view('cart.checkout', compact('cart', 'totalPrice', 'pendingOrder'));
    }
    public function store(Request $request)
    {
        $user = Auth::user();
        $pendingOrder = Order::where('user_id', $user->id)
        ->where('status', 'pending')
        ->first();
        if ($pendingOrder) {
            // de maka order ulit
            return redirect()->back()->with('error', 'You already have a pending order. Please review or complete that order before placing a new one.');
        }

        $data = $request->validate([
            'event_type'    => 'required|string',
            'event_date'    => 'required|date',
            'event_address' => 'required|string',
            'total_guests'  => 'required|integer|min:1',
            'concerns'      => 'nullable|string'
        ]);

        $user = Auth::user();
        $cart = $user->cart;

        if (!$cart || $cart->items->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }

        // final order total.
        $total = $cart->items->sum(function ($item) use ($data) {
            //  menu items multiply price * quantity.
            if ($item->menu_item_id && $item->menuItem) {
                return $item->menuItem->price * $item->quantity;
            }
            //  based on number of guests.
            if ($item->package_id && $item->package) {
                // if ni type ni user is below the minimum pax then ic-count based on the min pax of the package
                $guests = max($data['total_guests'], $item->package->min_pax);
                return $item->package->price_per_person * $guests * $item->quantity;
            }
            return 0;
        });

        // Order record with event details.
        $order = Order::create([
            'user_id'         => $user->id,
            'total'           => $total,
            'event_type'      => $data['event_type'],
            'event_date'      => $data['event_date'],
            'event_address'   => $data['event_address'],
            'total_guests'    => $data['total_guests'],
            'concerns'        => $data['concerns'] ?? null,
            'status'          => 'pending'
        ]);

        // Create OrderItem records based on cart items.
        foreach ($cart->items as $cartItem) {
            if ($cartItem->menu_item_id && $cartItem->menuItem) {
                $price = $cartItem->menuItem->price;
                $itemType = 'menu_item';
            } elseif ($cartItem->package_id && $cartItem->package) {
                $price = $cartItem->package->price_per_person;
                $itemType = 'package';
            } else {
                continue;
            }

            OrderItem::create([
                'order_id'          => $order->id,
                'item_reference_id' => $cartItem->id,
                'item_type'         => $itemType,
                'quantity'          => $cartItem->quantity,
                'price'             => $price,
            ]);
        }

        // clear cart items
        $cart->items()->delete();

        // order confirmation page.
        return redirect()->route('order.confirmation', $order->id)
            ->with('success', 'Your order has been placed!');
    }
}
