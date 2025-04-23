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
        $action = $request->input('action');
        $isGuest = !Auth::check(); // Check if the user is a guest

        // Initialize cart if not already in session

        if ($isGuest) {
            $cart = session()->get('cart', ['items' => []]);

            // Check if the item exists in the guest cart
            $foundKey = null;
            foreach ($cart['items'] as $key => $item) {
                if (($item['menu_item_id'] ?? null) == $id || ($item['package_id'] ?? null) == $id) {
                    $foundKey = $key;
                    break;
                }
            }

            if ($foundKey === null) {
                return $this->handleResponse($request, false, 'Item not found in cart.');
            }

            // Now use the found key to reference the item
            $cartItem = &$cart['items'][$foundKey];
            $currentQuantity = $cartItem['quantity'];

            if ($action === 'decrement') {
                if ($currentQuantity > 1) {
                    $cartItem['quantity'] -= 1;
                } else {
                    unset($cart['items'][$foundKey]); // Remove if quantity reaches 0
                }
            } elseif ($action === 'increment') {
                if (isset($cartItem['package_id'])) {
                    $totalPackages = collect($cart['items'])
                        ->filter(fn($item) => isset($item['package_id']))
                        ->sum('quantity');

                    if ($totalPackages >= 2) {
                        return $this->handleResponse($request, false, 'You can only have 2 package sets per event.');
                    }
                }
                $cartItem['quantity'] += 1;
            }

            session()->put('cart', $cart);
            session()->save(); // Ensure session is saved

            return $this->handleResponse($request, true, 'Cart updated successfully.', $cart);
        }

        // Handle cart update for authenticated users
        $cartItem = CartItem::find($id);
        if (!$cartItem) {
            return $this->handleResponse($request, false, 'Item not found.');
        }

        $currentQuantity = $cartItem->quantity;

        if ($action === 'decrement') {
            if ($currentQuantity > 1) {
                $cartItem->quantity -= 1;
                $cartItem->save();
            } else {
                $cartItem->delete();
            }
        } elseif ($action === 'increment') {
            if ($cartItem->package_id) {
                $totalPackages = $cartItem->cart->items()->whereNotNull('package_id')->sum('quantity');

                if ($totalPackages >= 2) {
                    return $this->handleResponse($request, false, 'You can only have 2 package sets per event.');
                }
            }
            $cartItem->quantity += 1;
            $cartItem->save();
        }

        return $this->handleResponse($request, true, 'Cart updated successfully.');
    }

    /**
     * Handles response based on request type (AJAX or normal).
     */
    private function handleResponse($request, $success, $message, $data = null)
    {
        if ($request->ajax()) {
            return response()->json(['success' => $success, 'message' => $message, 'cart' => $data]);
        }
        return redirect()->back()->with($success ? 'success' : 'error', $message);
    }




    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $isGuest = !Auth::check();

        if ($isGuest) {
            $cart = session()->get('cart', ['items' => []]);

            // Find the item by menu_item_id or package_id
            $foundKey = null;
            foreach ($cart['items'] as $key => $item) {
                if (($item['menu_item_id'] ?? null) == $id || ($item['package_id'] ?? null) == $id) {
                    $foundKey = $key;
                    break;
                }
            }

            if ($foundKey !== null) {
                unset($cart['items'][$foundKey]); // Use foundKey instead of $id
                session()->put('cart', $cart);
                session()->save(); // Make sure the session is saved
            }
        } else {
            // For a logged-in user, the code remains the same
            $cartItem = CartItem::findOrFail($id);
            $cartItem->delete();
        }

        return redirect()->back()->with('success', 'Item removed from cart.');
    }
}
