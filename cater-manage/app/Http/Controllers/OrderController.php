<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function confirmation(Order $order)
{
    return view('order.order_confirmation', compact('order'));
}
}
