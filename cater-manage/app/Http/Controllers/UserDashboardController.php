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
        // load orderItems along with their itemable (Package or MenuItem)
        $order = Order::with('orderItems')->findOrFail($orderId);
        return view('order-process', compact('order'));
    }
}
