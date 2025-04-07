<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Cart;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use App\Mail\OrderConfirmationMail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;
use App\Notifications\OrderConfirmationEmail;

class CheckoutController extends Controller
{
    public function show(Request $request)
    {
        $user = Auth::user();

        // Step 1: pagde nakalogin, store guest cart sa session then redirect to login
        if (!$user) {
            // Store guest cart in session 
            if (session()->has('cart') && count(session()->get('cart')['items']) > 0) {
                // Pass the cart to the session for merging after login
                session()->put('guest_cart', session()->get('cart'));
            }

            return redirect()->route('login')->with('error', 'You need to log in first.');
        }

        // Step 2: Merge guest cart if exists, then clear it
        if (session()->has('guest_cart')) {
            $this->mergeGuestCart($user, session()->get('guest_cart'));
            session()->forget('guest_cart');
        }
        // step3 de maka order ung user if may pending order na sya
        $pendingOrder = Order::where('user_id', $user->id)
            ->where('status', 'pending')
            ->first();

        // Step 4: Fetch the user's cart
        $cart = $user->cart;
        if (!$cart || $cart->items->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }

        // fetch total guests 
        $totalGuests = $request->query('total_guests', 50);
        //  store in the session to give later in the store() method
        session(['total_guests' => $totalGuests]);


        $totalPrice = $cart->items->sum(function ($item) use ($totalGuests) {
            //  party trays items Variant pricing logic
            if ($item->menu_item_id && $item->menuItem) {
                $pricingTiers = $item->menuItem->pricing;
                $selectedVariant = isset($item->variant) ? trim($item->variant) : null;

                if (!empty($selectedVariant) && isset($pricingTiers[$selectedVariant])) {
                    $price = $pricingTiers[$selectedVariant];
                } else {
                    // ELSE pricing based on quantity tiers (if available)
                    if ($item->quantity >= 10 && $item->quantity <= 15) {
                        $price = $pricingTiers['10-15'] ?? 0;
                    } elseif ($item->quantity > 15 && isset($pricingTiers['15-20'])) {
                        $price = $pricingTiers['15-20'];
                    } else {
                        //first available tier as default
                        $price = reset($pricingTiers);
                    }
                }
                return $price * $item->quantity;
            }
            // sa package items maximum of totalGuests and the packages min pax.
            if ($item->package_id && $item->package) {
                $guests = max($totalGuests, $item->package->min_pax);
                return $item->package->price_per_person * $guests * $item->quantity;
            }
            return 0;
        });


        return view('cart.checkout', compact('cart', 'totalPrice', 'pendingOrder', 'totalGuests'));
    }
    public function mergeGuestCart($user, $guestCart)
    {
        foreach ($guestCart['items'] as $guestItem) {
            $existingItem = $user->cart->items()
                ->where(function ($query) use ($guestItem) {
                    if (!empty($guestItem['menu_item_id'])) {
                        $query->where('menu_item_id', $guestItem['menu_item_id']);
                    }
                    if (!empty($guestItem['package_id'])) {
                        $query->orWhere('package_id', $guestItem['package_id']);
                    }
                })
                ->first();

            if ($existingItem) {
                $existingItem->quantity += $guestItem['quantity'];

                // Check if 'selected_options' exists in the guest cart item, then merge
                if (isset($guestItem['selected_options'])) {
                    // Merge the selected_options array from the guest item with the existing cart item
                    $existingItem->selected_options = array_merge($existingItem->selected_options, $guestItem['selected_options']);
                }
                if (!empty($guestItem['variant']) && $guestItem['variant'] !== $existingItem->variant) {
                    $existingItem->variant = $guestItem['variant']; // update the variant

                }
                $existingItem->save();
            } else {
                $user->cart->items()->create([
                    'menu_item_id' => $guestItem['menu_item_id'] ?? null,
                    'package_id' => $guestItem['package_id'] ?? null,
                    'quantity' => $guestItem['quantity'],
                    'price' => $guestItem['price'] ?? 0,
                    'variant' => $guestItem['variant'] ?? null,
                    'selected_options' => $guestItem['selected_options'] ?? [],
                ]);
            }
        }
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        $pendingOrder = Order::where('user_id', $user->id)
            ->where('status', 'pending')
            ->first();
        if ($pendingOrder) {
            // de maka order ulit if may pending
            return redirect()->back()->with('error', 'You already have a pending order. Please review or complete that order before placing a new one.');
        }

        $data = $request->validate([
            'event_type'    => 'required|string',
            'event_date'         => 'required|string',
            'event_start_time' => 'required|date_format:H:i',
            'event_start_end'  => 'required|date_format:H:i',
            'event_address' => 'required|string',
            'total_guests'  => 'required|integer|min:1',
            'concerns'      => 'nullable|string'
        ]);

        // IF OTHERS UNG EVENT TYPE, MAG BASED SYA DON SA CUSTOM EVENT TYPE
        if ($data['event_type'] === 'Other') {
            $customData = $request->validate([
                'custom_event_type' => 'required|string'
            ]);
            $eventType = $customData['custom_event_type'];
        } else {
            $eventType = $data['event_type'];
        }

        $dateRange = explode(' to ', $data['event_date']);
        if (count($dateRange) === 2) {
            $event_date_start = trim($dateRange[0]);
            $event_date_end   = trim($dateRange[1]);
        } else {
            // If single date, assign to both start and end.
            $event_date_start = trim($data['event_date']);
            $event_date_end   = trim($data['event_date']);
        }

        $cart = $user->cart;

        if (!$cart || $cart->items->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }

        // final order total.
        $total = $cart->items->sum(function ($item) use ($data) {
            // sa menu items, check if a variant is set and use its price from the JSON pricing.
            if ($item->menu_item_id && $item->menuItem) {
                $pricingTiers = $item->menuItem->pricing;
                if (!empty($item->variant) && isset($pricingTiers[$item->variant])) {
                    $price = $pricingTiers[$item->variant];
                } else {
                    //  default price
                    $price = $item->menuItem->price;
                }
                return $price * $item->quantity;
            }
            // sa packages naka based on price per person, minimum pax, and quantity.
            if ($item->package_id && $item->package) {
                // if less than yung total guest sa package min pax, ic-count based on the min pax lagi
                $guests = max($data['total_guests'], $item->package->min_pax);
                return $item->package->price_per_person * $guests * $item->quantity;
            }
            return 0;
        });

        // order record with event details.
        $order = Order::create([
            'user_id'         => $user->id,
            'total'           => $total,
            'event_type'      => $eventType,
            'event_date_start' => $event_date_start,
            'event_date_end'   => $event_date_end,
            'event_start_time' => $data['event_start_time'],
            'event_start_end'  => $data['event_start_end'],
            'event_address'   => $data['event_address'],
            'total_guests'    => $data['total_guests'],
            'concerns'        => $data['concerns'] ?? null,
            'status'          => 'pending'
        ]);

        //  OrderItem records based sa cart items.
        foreach ($cart->items as $cartItem) {
            if ($cartItem->menu_item_id && $cartItem->menuItem) {
                $pricingTiers = $cartItem->menuItem->pricing;
                if (!empty($cartItem->variant) && isset($pricingTiers[$cartItem->variant])) {
                    $price = $pricingTiers[$cartItem->variant];
                } else {
                    $price = $cartItem->menuItem->price;
                }
                $itemType = 'menu_item';
                $refId = $cartItem->menu_item_id;
                $variantValue = $cartItem->variant;
            } elseif ($cartItem->package_id && $cartItem->package) {
                $price = $cartItem->package->price_per_person;
                $itemType = 'package';
                $refId = $cartItem->package_id;
                $variantValue = (string) max($data['total_guests'], $cartItem->package->min_pax);
            } else {
                continue;
            }

            OrderItem::create([
                'order_id'          => $order->id,
                'item_reference_id' => $refId,
                'item_type'         => $itemType,
                'quantity'          => $cartItem->quantity,
                'price'             => $price,
                'variant'           => $variantValue,
            ]);
        }

        // clear cart items.
        $cart->items()->delete();
        // Send email notification to the user
        Mail::to($user->email)->send(new OrderConfirmationMail($order));

        // order confirmation page.
        return redirect()->route('order.confirmation', $order->id)
            ->with('success', 'Your order has been placed!');
    }
}
