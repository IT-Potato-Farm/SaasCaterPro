<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Mail\InvoiceMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $query = Order::query();

        // Filter by status if provided and not empty
        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        // Filter by event_date range if provided
        if ($request->filled('date_from')) {
            $query->whereDate('event_date', '>=', $request->input('date_from'));
        }
        if ($request->filled('date_to')) {
            $query->whereDate('event_date', '<=', $request->input('date_to'));
        }

        // Order the results and paginate
        $orders = $query->orderBy('created_at', 'desc')->paginate(10);

        return redirect()->route('admin.admindashboard', ['activeScreen' => 'bookings']);
    }


    public function confirmation(Order $order)
    {
        return view('order.order_confirmation', compact('order'));
    }
    public function generateInvoice(Order $order)
    {
        Mail::to($order->user->email)->send(new InvoiceMail($order));

        return redirect()->back()->with('success', 'Invoice sent successfully.');
    }

    public function markAsPaid(Order $order)
    {
        if ($order->status === 'cancelled') {
            return redirect()->back()->with('error', 'Cannot mark a cancelled order as paid.');
        }

        $order->status = 'paid';
        $order->save();

        return redirect()->back()->with('success', 'Order marked as paid.');
    }


    public function markAsUnpaid(Order $order)
    {
        if ($order->status === 'cancelled') {
            return redirect()->back()->with('error', 'Cannot mark a cancelled order as unpaid.');
        }

        $order->status = 'pending';
        $order->save();

        return redirect()->back()->with('success', 'Order marked as unpaid.');
    }
    public function markAsOngoing(Order $order)
    {
        if ($order->status === 'cancelled' || $order->status === 'paid') {
            return redirect()->back()->with('error', 'Cannot mark this order as ongoing.');
        }

        $order->status = 'ongoing';
        $order->save();

        return redirect()->back()->with('success', 'Order marked as ongoing.');
    }
    public function markAsPartial(Order $order)
    {
        if ($order->status === 'cancelled' || $order->status === 'paid') {
            return redirect()->back()->with('error', 'This order cannot be marked as partially paid.');
        }

        $order->status = 'partial';
        $order->save();

        return redirect()->back()->with('success', 'Order marked as partially paid.');
    }
    public function cancelOrder(Order $order)
    {
        if ($order->status === 'cancelled') {
            return redirect()->back()->with('error', 'Order is already cancelled.');
        }

        $order->status = 'cancelled';
        $order->save();

        return redirect()->back()->with('success', 'Order has been cancelled.');
    }
}
