<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Cart;
use App\Models\Order;
use App\Mail\InvoiceMail;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use App\Models\BookingSetting;
use App\Mail\OrderConfirmationMail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;
use App\Notifications\OrderConfirmationEmail;

class CheckoutController extends Controller
{
    public function getAvailableSlots(Request $request)
    {
        $eventDate = $request->query('event_date');
        if (!$eventDate) {
            return response()->json(['error' => 'Event date is required'], 400);
        }

        $bookingSettings = BookingSetting::first();
        if (!$bookingSettings || !$bookingSettings->service_start_time || !$bookingSettings->service_end_time || !$bookingSettings->events_per_day) {
            return response()->json(['error' => 'Booking settings are not configured properly'], 500);
        }

        $timeSlots = $this->generateTimeSlots($bookingSettings, $eventDate);


        $formattedSlots = array_map(function ($slot) {
            return [
                'start' => Carbon::createFromFormat('H:i', $slot['start'])->format('H:i'),
                'end' => Carbon::createFromFormat('H:i', $slot['end'])->format('H:i'),
            ];
        }, $timeSlots);

        return response()->json(array_values($formattedSlots));
    }

    public function show(Request $request)
    {
        $user = Auth::user();
        // EVENT DATE
        $eventDate = $request->query('event_date');
        session(['event_date' => $eventDate]);

        $booking_settings = BookingSetting::first();
        // Set the start and end times from booking settings
        if (!$booking_settings || !$booking_settings->service_start_time || !$booking_settings->service_end_time || !$booking_settings->events_per_day) {
            return redirect()->back()->with('error', 'Booking settings are not configured properly.');
        }

        $timeSlots = $this->generateTimeSlots($booking_settings, $eventDate);
        // dd($timeSlots, $existingBookings);

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


        // FUNCTION TO FETCH TOTAL GUEST PAG MAY PACKAGE ITEM SA CART
        $hasPackage = $cart->items->contains(function ($item) {
            return $item->package_id && $item->package;
        });
        $totalGuests = null;
        if ($hasPackage) {
            $totalGuests = $request->query('total_guests', 50);
            session(['total_guests' => $totalGuests]);
        }

        // fetch total guests 
        // $totalGuests = $request->query('total_guests', 50);
        // session(['total_guests' => $totalGuests]);

        $dateRange = explode(' to ', $eventDate);
        if (count($dateRange) === 2) {
            $event_date_start = trim($dateRange[0]);
            $event_date_end = trim($dateRange[1]);
        } else {
            $event_date_start = trim($eventDate);
            $event_date_end = trim($eventDate);
        }
        // EVEBT DAYS CALCULATION
        $days = Carbon::parse($event_date_start)->diffInDays(Carbon::parse($event_date_end)) + 1;


        $totalPrice = $cart->items->sum(function ($item) use ($totalGuests, $days) {
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
                return $item->package->price_per_person * $guests * $item->quantity * $days;
            }
            return 0;
        });

        return view('cart.checkout', compact('cart', 'totalPrice', 'pendingOrder', 'totalGuests', 'eventDate', 'booking_settings', 'timeSlots', 'days'));
    }
    private function generateTimeSlots($booking_settings, $eventDate)
    {
        $start = Carbon::createFromTimeString($booking_settings->service_start_time);
        $end = Carbon::createFromTimeString($booking_settings->service_end_time);
        $rest_minutes = $booking_settings->rest_time ?? 30; // Default to 30 minutes if not set
        $eventsPerDay = $booking_settings->events_per_day ?? 2; // Default to 2 if not set

        // Calculate total service minutes available
        $totalServiceMinutes = $start->diffInMinutes($end);
        $totalRestTime = ($eventsPerDay - 1) * $rest_minutes;
        $slotDuration = ($totalServiceMinutes - $totalRestTime) / $eventsPerDay;

        $timeSlots = [];
        $currentStart = $start->copy();

        for ($i = 0; $i < $eventsPerDay; $i++) {
            // Determine the end of this slot
            $slotEnd = ($i < $eventsPerDay - 1)
                ? $currentStart->copy()->addMinutes($slotDuration)
                : $end->copy();  // Last slot stretches to end of service time

            // Prevent overshooting the end time
            if ($slotEnd->gt($end)) {
                $slotEnd = $end->copy();
            }

            // Add this slot
            $timeSlots[] = [
                'start' => $currentStart->format('H:i'),
                'end' => $slotEnd->format('H:i'),
                'occupied' => false
            ];

            // Move to the start of the next slot, factoring in rest time
            $currentStart = $slotEnd->copy()->addMinutes($rest_minutes);
            if ($currentStart->gte($end)) break;
        }

        // Find existing bookings for this date
        $existingBookings = Order::whereDate('event_date_start', $eventDate)
            ->whereNotIn('status', ['cancelled'])
            ->get(['event_start_time', 'event_start_end']);

        // Mark slots as occupied if they overlap with a booking
        foreach ($timeSlots as $key => $slot) {
            $slotStart = Carbon::createFromFormat('H:i', $slot['start']);
            $slotEnd = Carbon::createFromFormat('H:i', $slot['end']);

            foreach ($existingBookings as $booking) {
                $bookingStart = Carbon::parse($booking->event_start_time);
                $bookingEnd = Carbon::parse($booking->event_start_end);

                // Check for overlap
                if (($slotStart->lte($bookingEnd) && $slotEnd->gte($bookingStart)) ||
                    ($bookingStart->lte($slotEnd) && $bookingEnd->gte($slotStart))
                ) {
                    $timeSlots[$key]['occupied'] = true;
                    break;  // No need to check other bookings if already occupied
                }
            }
        }

        // Sort occupied ranges by start time
        usort($timeSlots, function ($a, $b) {
            return $a['start'] <=> $b['start'];
        });

        // Ensure we don't exceed the maximum events per day
        return array_filter($timeSlots, function ($slot) {
            return !$slot['occupied'];
        });
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

        $cart = $user->cart;
        if (!$cart || $cart->items->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }
        if ($pendingOrder) {
            // de maka order ulit if may pending
            return redirect()->back()->with('error', 'You already have a pending order. Please review or complete that order before placing a new one.');
        }

        $data = $request->validate([
            'event_type'    => 'required|string',
            'event_date'         => 'required|string',
            // 'event_start_time' => 'required|date_format:H:i',
            // 'event_start_end'  => 'required|date_format:H:i',
            'time_mode'     => 'required|string|in:slot,custom',
            'event_address' => 'required|string',
            // 'total_guests'  => 'required|integer|min:1',
            'concerns'      => 'nullable|string'
        ]);

        $bookingSettings = BookingSetting::first();
        if (!$bookingSettings) {
            return redirect()->back()->with('error', 'Booking settings are not configured.');
        }


        //  time selection logic based on 'time_mode'
        if ($data['time_mode'] === 'slot') {
            // User chose to select from available time slots
            $slotData = $request->validate([
                'event_time_slot' => 'required|string'
            ]);
            $timeParts = explode(' - ', $slotData['event_time_slot']);
            if (count($timeParts) !== 2) {
                return redirect()->back()->with('error', 'Invalid time slot selected.');
            }


            try {
                $startTime = Carbon::createFromFormat('H:i', $timeParts[0]);
                $endTime = Carbon::createFromFormat('H:i', $timeParts[1]);
            } catch (\Exception $e) {
                return redirect()->back()->with('error', 'Invalid time slot format.');
            }

            $serviceStart = Carbon::createFromTimeString($bookingSettings->service_start_time);
            $serviceEnd = Carbon::createFromTimeString($bookingSettings->service_end_time);

            // Validate within service hours and start before end
            if ($startTime->lt($serviceStart) || $endTime->gt($serviceEnd) || $startTime->gte($endTime)) {
                $serviceStartDisplay = $serviceStart->format('g:iA');
                $serviceEndDisplay = $serviceEnd->format('g:iA');
                return redirect()->back()->with('error', "Selected time must be between {$serviceStartDisplay}-{$serviceEndDisplay} and start time must be before end time.");
            }

            // Check for overlaps with existing bookings
            $eventDate = trim(explode(' to ', $data['event_date'])[0]); // Get start date
            $existingBookings = Order::whereDate('event_date_start', $eventDate)
                ->whereNotIn('status', ['cancelled'])
                ->get(['event_start_time', 'event_start_end']);

            foreach ($existingBookings as $booking) {
                $bookingStart = Carbon::parse($booking->event_start_time);
                $bookingEnd = Carbon::parse($booking->event_start_end);
                if ($startTime->lte($bookingEnd) && $endTime->gte($bookingStart)) {
                    $bookingStartDisplay = $bookingStart->format('g:iA');
                    $bookingEndDisplay = $bookingEnd->format('g:iA');
                    return redirect()->back()->with('error', "Selected time overlaps with a booked slot ({$bookingStartDisplay}-{$bookingEndDisplay}).");
                }
            }

            $data['event_start_time'] = $startTime->format('H:i');
            $data['event_start_end'] = $endTime->format('H:i');
        } elseif ($data['time_mode'] === 'custom') {
            // custom time
            // $data['event_start_time'] = $request->input('custom_start_time');  
            // $data['event_start_end'] = $request->input('custom_end_time');  
            $customSlot = $request->validate([
                'custom_time_slot' => 'required|string'
            ])['custom_time_slot'];
            $timeParts = explode('|', $customSlot);

            $startTime = $timeParts[0]; // e.g., "13:00"
            $endTime = $timeParts[1];   // e.g., "16:00"

            // Validate custom time
            try {
                $start = Carbon::createFromFormat('H:i', $startTime);
                $end = Carbon::createFromFormat('H:i', $endTime);
            } catch (\Exception $e) {
                return redirect()->back()->with('error', 'Invalid time format.');
            }

            $serviceStart = Carbon::createFromTimeString($bookingSettings->service_start_time);
            $serviceEnd = Carbon::createFromTimeString($bookingSettings->service_end_time);

            // Check if within service hours and start before end
            if ($start->lt($serviceStart) || $end->gt($serviceEnd) || $start->gte($end)) {
                $serviceStartDisplay = $serviceStart->format('g:iA');
                $serviceEndDisplay = $serviceEnd->format('g:iA');
                return redirect()->back()->with('error', "Selected time must be between {$serviceStartDisplay}-{$serviceEndDisplay} and start time must be before end time.");
            }

            // Check for overlaps with existing bookings
            $eventDate = trim(explode(' to ', $data['event_date'])[0]); // Get start date
            $existingBookings = Order::whereDate('event_date_start', $eventDate)
                ->whereNotIn('status', ['cancelled'])
                ->get(['event_start_time', 'event_start_end']);

            foreach ($existingBookings as $booking) {
                $bookingStart = Carbon::parse($booking->event_start_time);
                $bookingEnd = Carbon::parse($booking->event_start_end);
                if ($start->lte($bookingEnd) && $end->gte($bookingStart)) {
                    $bookingStartDisplay = $bookingStart->format('g:iA');
                    $bookingEndDisplay = $bookingEnd->format('g:iA');
                    return redirect()->back()->with('error', "Selected time overlaps with a booked slot ({$bookingStartDisplay}-{$bookingEndDisplay}).");
                }
            }
          

            $data['event_start_time'] = $startTime;
            $data['event_start_end'] = $endTime;
            
        }

        // Step 2: Check if the cart contains a package
        $hasPackage = $cart->items->contains(function ($item) {
            return $item->package_id !== null;
        });

        // Step 3: If a package exists, require total_guests
        if ($hasPackage) {
            $guestData = $request->validate([
                'total_guests' => 'required|integer|min:1'
            ]);
            $data['total_guests'] = $guestData['total_guests'];
        } else {
            // Default to 0 if not provided (or set as nullable in your DB)
            $data['total_guests'] = 0;
        }

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

        // Calculate number of days including both start and end
        $days = Carbon::parse($event_date_start)->diffInDays(Carbon::parse($event_date_end)) + 1;


        // final order total.
        // Packages - charged per guest per day, menu items are charged per order.
        $total = $cart->items->sum(function ($item) use ($data, $days) {
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
                return $item->package->price_per_person * $guests * $item->quantity * $days;
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
            $includedUtilities = [];
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

                $includedUtilities = $cartItem->package->utilities->pluck('name')->toArray();
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
                'selected_options' => $cartItem->selected_options,
                'included_utilities' => $includedUtilities,
            ]);
        }

        // clear cart items.
        $cart->items()->delete();
        // Send email notification to the user
        Mail::to($user->email)->send(new OrderConfirmationMail($order));
        Mail::to($order->user->email)->send(new InvoiceMail($order));

        // order confirmation page.
        return redirect()->route('order.confirmation', $order->id)
            ->with('success', 'Your order has been placed!');
    }
}
