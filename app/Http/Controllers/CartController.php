<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\Package;
use App\Models\MenuItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('loginpage')->with('message', 'Please log in to view your cart.');

        }
        // if (!$user) {
        //     $cart = session()->get('cart', ['items' => []]); // Guest cart (session)
        //     $cartItems = collect($cart['items']); // Convert to collection for easier handling
        // } else {
        //     // Fetch or create cart for logged-in users
        //     $cart = Cart::firstOrCreate(['user_id' => $user->id]);
        //     $cartItems = $cart->items; // Retrieve cart items from DB
        // }
        $cart = Cart::firstOrCreate(['user_id' => $user->id]);
        $cartItems = $cart->items;

        // Fetch pending order only if user is logged in
        $activeStatuses = ['pending', 'partial', 'ongoing', 'paid'];
        $pendingOrder = $user ? Order::where('user_id', $user->id)
            ->whereIn('status', $activeStatuses)
            ->first() : null;

        // Get available menu items and packages
        $menuItems = MenuItem::where('status', 'available')->get();
        $packages = Package::where('status', 'available')->get();

        return view('cart.index', compact('cart', 'cartItems', 'pendingOrder', 'menuItems', 'packages'));
        // return view('cart.sanagumana', compact('cart', 'cartItems', 'pendingOrder', 'menuItems', 'packages'));
    }
    public function index2()
    {
        $user = Auth::user();
        $isGuest = !$user;

        // Initialize variables
        $cartItems = collect([]);
        $pendingOrder = null;

        try {
            if ($isGuest) {
                // cart for guests
                $cartData = session()->get('cart', ['items' => []]);
                $cartItems = collect($cartData['items']);
                $cart = $cartData;
            } else {
                // cart for logged-in users
                $cart = Cart::firstOrCreate(['user_id' => $user->id]);
                $cartItems = $cart->items ?: collect([]);

                //  pending order for logged-in users
                //REFACTOR $pendingOrder = Order::where('user_id', $user->id)
                //      ->where('status', 'pending')
                //      ->first();
                $pendingOrder = Order::pendingForUser($user->id)->first();
            }

            // available menu items and packages
            $menuItems = MenuItem::available()->get();
            $packages = Package::available()->get();

            return view('cart.sanagumana', compact(
                'cart',
                'cartItems',
                'pendingOrder',
                'menuItems',
                'packages',
                'isGuest'
            ));
        } catch (\Exception $e) {
            // Log the error and return with a flash message
            Log::error('Cart loading error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Unable to load your cart. Please try again.');
        }
    }

    public function add(Request $request)
    {
        if (!Auth::check()) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Please login to continue'], 401);
            }
            return redirect()->route('login')->with('error', 'Please login to add items to cart.');
        }

        $validated = $request->validate([
            'menu_item_id' => 'nullable|exists:menu_items,id',
            'package_id'   => 'nullable|exists:packages,id',
            'quantity'     => 'required|integer|min:1',
            'variant'      => 'nullable|string',
            'selected_options' => 'nullable|array',
            'included_utilities' =>'nullable|array',
        ]);

        if (empty($validated['menu_item_id']) && empty($validated['package_id'])) {
            return $this->jsonOrRedirect($request, 'Please select an item or package.', 422);
        }

        $user = Auth::user();
        $cart = $this->getUserCart($user);
        // $cart = $user ? $this->getUserCart($user) : $this->getGuestCart();
        $cartItems = $this->getCartItems($cart);

        $messages = [];

        if (!empty($validated['package_id'])) {
            $messages = array_merge($messages, $this->addPackageToCart($cart, $cartItems, $validated));
        }

        if (!empty($validated['menu_item_id'])) {
            $messages = array_merge($messages, $this->addMenuItemToCart($cart, $cartItems, $validated));
        }

        if (!empty($messages['errors'])) {
            return $this->jsonOrRedirect($request, implode(' ', $messages['errors']), 422);
        }

        return $this->jsonOrRedirect($request, implode(' ', $messages['success']), 200);
    }

    private function getCartItems($cart)
    {
        return is_object($cart) ? $cart->items() : collect($cart['items']);
    }

    private function getUserCart($user)
    {
        return $user->cart ?: Cart::create(['user_id' => $user->id]);
    }

    private function getGuestCart()
    {
        $cart = session()->get('cart', ['items' => []]);
        session()->put('cart', $cart);
        return $cart;
    }

    private function addPackageToCart($cart, $cartItems, $validated)
    {
        $messages = ['success' => [], 'errors' => []];
        $totalPackageCount = $cartItems->whereNotNull('package_id')->sum('quantity');
    
        if ($totalPackageCount >= 2) {
            $messages['errors'][] = 'You can only add up to 2 package sets per event.';
        } else {
            $available = 2 - $totalPackageCount;
            $quantityToAdd = min($validated['quantity'], $available);
    
            $package = Package::findOrFail($validated['package_id']);
            
            // Get the utilities associated with this package
            $utilities = $package->utilities->map(function ($utility) {
                return [
                    'name' => $utility->name,
                    'description' => $utility->description,
                    'image' => $utility->image,
                    'quantity' => $utility->quantity,  // Include quantity if needed
                ];
            })->toArray();
    
            // Process the selected options properly
            $rawOptions = $validated['selected_options'] ?? [];
            $includedItems = $validated['included_utilities'] ?? [];
            
            // This is the corrected part - maintain the object structure from the frontend
            $selectedOptions = [];
            
            // Process the selected options maintaining the structure
            // The frontend sends data like: {"5": [{"id": "1", "type": "Fried"}]}
            foreach ($rawOptions as $foodId => $options) {
                if (is_array($options) && !empty($options)) {
                    $selectedOptions[$foodId] = $options;
                }
            }
            
            if (isset($cart->user_id)) {
                $existingPackageItem = $cartItems->where('package_id', $validated['package_id'])->first();
                if ($existingPackageItem) {
                    $existingPackageItem->update([
                        'quantity' => min($existingPackageItem->quantity + $quantityToAdd, 2),
                        'selected_utilities' => $utilities,
                        'selected_options' => $selectedOptions,
                    ]);
                    $messages['success'][] = 'Package updated in cart.';
                } else {
                    $cart->items()->create(array_merge($validated, [
                        'quantity' => $quantityToAdd,
                        'selected_utilities' => $utilities,
                        'selected_options' => $selectedOptions, 
                    ]));
                    $messages['success'][] = 'Package added to cart.';
                }
            } else {
                $cart['items'][] = array_merge($validated, [
                    'quantity' => $quantityToAdd,
                    'selected_utilities' => $utilities,
                    'selected_options' => $selectedOptions,
                ]);
                session()->put('cart', $cart);
                $messages['success'][] = 'Package added to cart (guest mode).';
            }
        }
    
        return $messages;
    }

    private function addMenuItemToCart($cart, $cartItems, $validated)
    {
        $messages = ['success' => [], 'errors' => []];

        if (isset($cart->user_id)) {
            $existingMenuItem = $cartItems
                ->where('menu_item_id', $validated['menu_item_id'])
                ->where('variant', $validated['variant'] ?? null)
                ->first();

            if ($existingMenuItem) {
                $existingMenuItem->update(['quantity' => $existingMenuItem->quantity + $validated['quantity']]);
                $messages['success'][] = 'Party Tray updated in cart.';
            } else {
                $cart->items()->create($validated);
                $messages['success'][] = 'Party tray added to cart.';
            }
        } else {
            $cart['items'][] = $validated;
            session()->put('cart', $cart);
            $messages['success'][] = 'Menu item added to cart (guest mode).';
        }

        return $messages;
    }

    /**
     * Handle JSON or Redirect Response
     */
    private function jsonOrRedirect($request, $message, $status)
    {
        if ($request->expectsJson()) {
            return response()->json(['message' => $message], $status);
        }
        return redirect()->route('cart.index')->with($status === 200 ? 'success' : 'error', $message);
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
