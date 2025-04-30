<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Order;
use App\Models\Penalty;
use App\Mail\InvoiceMail;
use Illuminate\Http\Request;
use App\Models\BookingSetting;
use Illuminate\Support\Facades\Mail;

class OrderController extends Controller
{

    public function getOccupiedTimes(Request $request)
    {
        $eventDate = $request->query('event_date');

        if (!$eventDate) {
            return response()->json(['error' => 'Event date is required'], 400);
        }

        $bookingSetting = BookingSetting::first();
        $restTime = $bookingSetting ? $bookingSetting->rest_time : 0;

        $existingBookings = Order::whereDate('event_date_start', $eventDate)
            ->whereNotIn('status', ['cancelled'])
            ->orderBy('event_start_time')  // Important: sort by start time
            ->get(['event_start_time', 'event_start_end']);

        $timesWithRest = $existingBookings->map(function ($booking) use ($restTime) {
            return [
                'start' => Carbon::parse($booking->event_start_time)->format('H:i'),
                'end'   => Carbon::parse($booking->event_start_end)->format('H:i'),
            ];
        })->toArray();

        // Adjust to consider rest time as the "gap"
        $adjusted = [];
        foreach ($timesWithRest as $key => $time) {
            $adjusted[] = [
                'start' => $time['start'],
                'end' => $time['end']
            ];

            // For the last one skip, but for all others shift the next start
            if (isset($timesWithRest[$key + 1])) {
                $next = Carbon::createFromFormat('H:i', $time['end'])->addMinutes($restTime)->format('H:i');
                // Adjust the start of the next event if rest_time pushes it forward
                if ($next > $timesWithRest[$key + 1]['start']) {
                    $timesWithRest[$key + 1]['start'] = $next;
                }
            }
        }

        return response()->json($adjusted);
    }

    public function index(Request $request)
{
    $query = Order::query();

    // Filter by status if provided and not empty
    if ($request->filled('status')) {
        $query->where('status', $request->input('status'));
    }

    // Filter by event_date range if provided
    if ($request->filled('date_from')) {
        $query->whereDate('event_date_start', '>=', $request->input('date_from'));
    }
    if ($request->filled('date_to')) {
        $query->whereDate('event_date_end', '<=', $request->input('date_to'));
    }

    // Order the results and paginate
    $orders = $query->orderBy('created_at', 'desc')->paginate(10);

    // Return view and pass the orders to it
    return view('admin.bookingsdashboard', compact('orders'));
}

    // penalty function
    public function addPenalty(Request $request, Order $order)
    {
        $request->validate([
            'amount' => 'required|numeric|min:0',
            'reason' => 'nullable|string|max:255',
        ]);


        $penalty = Penalty::create([
            'order_id' => $order->id,
            'amount' => $request->amount,
            'reason' => $request->reason,
        ]);

        // 
        $order->total += $penalty->amount;
        $order->save();

        return redirect()->back()->with('success', 'Penalty added successfully!');
    }
    public function cancel(Order $order)
    {
        if (in_array($order->status, ['partial', 'ongoing', 'paid', 'completed'])) {
            return redirect()->back()->with('error', 'Order cannot be canceled at this stage.');
        }

        $order->status = 'cancelled';
        $order->save();

        return redirect()->route('userdashboard')->with('success', 'Order has been canceled successfully.');
    }


    public function confirmation(Order $order)
    {
        return view('order.order_confirmation', compact('order'));
    }
    public function generateInvoice(Order $order)
    {
        Mail::to($order->user->email)->send(new InvoiceMail($order));

        return redirect()->route('admin.bookings')
            ->with('success', 'Invoice sent successfully.');
    }

    public function markAsPaid(Order $order)
    {
        if ($order->status === 'cancelled') {
            return redirect()->route('admin.bookings')
                ->with('error', 'Cannot mark a cancelled order as paid.');
        }

        $order->status = 'paid';
        $order->amount_paid = $order->total;
        $order->save();

        return redirect()->route('admin.bookings')
            ->with('success', 'Order marked as paid.');
    }

    public function markAsUnpaid(Order $order)
    {
        if ($order->status === 'cancelled') {
            return redirect()->route('admin.bookings')
                ->with('error', 'Cannot mark a cancelled order as unpaid.');
        }

        $order->status = 'unpaid';
        $order->save();

        return redirect()->route('admin.bookings')
            ->with('success', 'Order marked as unpaid.');
    }

    public function markAsOngoing(Order $order)
    {
        if ($order->status === 'cancelled' || $order->status === 'paid') {
            return redirect()->route('admin.bookings')
                ->with('error', 'Cannot mark this order as ongoing.');
        }

        $order->status = 'ongoing';
        $order->save();

        return redirect()->route('admin.bookings')
            ->with('success', 'Order marked as ongoing.');
    }

    public function markAsPartial(Order $order, Request $request)
    {

        if ($order->status === 'cancelled' || $order->status === 'paid') {
            return redirect()->route('admin.bookings')
                ->with('error', 'This order cannot be marked as partially paid.');
        }

        $partialAmount = $request->input('partial_amount');  

        if ($partialAmount <= 0 || $partialAmount > ($order->total - $order->amount_paid)) {
            return redirect()->route('admin.bookings')
                ->with('error', 'Invalid partial payment amount.');
        }

        $order->amount_paid += $partialAmount;
        $order->partial_payment_date = now();
        $order->status = 'partial';
        
        if ($order->amount_paid >= $order->total) {
            $order->status = 'paid'; 
            $order->full_payment_date = now(); 
        }

        $order->save();
        return redirect()->route('admin.bookings')
            ->with('success', 'Order marked as partially paid.');
    }
    public function cancelOrder(Order $order)
    {
        if ($order->status === 'cancelled') {
            return redirect()->route('admin.bookings')
                ->with('error', 'Order is already cancelled.');
        }

        $order->status = 'cancelled';
        $order->save();

        return redirect()->route('admin.bookings')
            ->with('success', 'Order has been cancelled.');
    }
    public function markAsCompleted(Order $order)
    {
        if ($order->status === 'cancelled') {
            return redirect()->route('admin.bookings')
                ->with('error', 'Cannot mark a cancelled order as completed.');
        }

        $order->status = 'completed';
        $order->save();

        return redirect()->route('admin.bookings')
            ->with('success', 'Order marked as completed.');
    }
    public function destroy($id)
    {
        $order = Order::findOrFail($id);
        try {
            $order->delete();

            return redirect()->back()->with('success', 'Order deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to delete the order.');
        }
    }
}
