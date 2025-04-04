<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserDashboardController extends Controller
{
    public function index()
    {
        $orders = Order::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('userdashboard', compact('orders'));
    }

    public function show($orderId)
    {
        if (!Auth::check()) {
            abort(403, 'You must be logged in to view this order.');
        }
        $userId = Auth::id();
        // load orderItems along with their itemable (Package or MenuItem)
        $order = Order::with('orderItems')->where('id', $orderId)->where('user_id', $userId)->first();

        // order doesn't exist or doesn't belong to the user, abort with 403
        if (!$order) {
            abort(403, 'Unauthorized access to this order.');
        }
        return view('order-process', compact('order'));
    }
}
