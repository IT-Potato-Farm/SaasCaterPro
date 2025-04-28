<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Penalty;
use Illuminate\Http\Request;

class PenaltyController extends Controller
{
    public function index(Request $request)
    {
        $query = Penalty::query()->with('order');

        if ($request->filled('order_id')) {
            $query->where('order_id', $request->order_id);
        }

        if ($request->filled('min_amount')) {
            $query->where('amount', '>=', $request->min_amount);
        }

        if ($request->filled('max_amount')) {
            $query->where('amount', '<=', $request->max_amount);
        }

        if ($request->filled('reason')) {
            $query->where('reason', 'LIKE', '%' . $request->reason . '%');
        }

        $penalties = $query->latest()->simplePaginate(10);

       
        $totalCount = $query->count(); 
        $totalAmount = $query->sum('amount'); 
        $averagePenalty = $totalCount > 0 ? $totalAmount / $totalCount : 0;

        $penalties->appends($request->all());

        return view('reports.penaltiesreport', compact('penalties', 'totalCount', 'totalAmount', 'averagePenalty'));
    }

    public function create()
    {
        $orders = Order::all();
        return view('penalties.create', compact('orders'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'order_id' => 'required|exists:orders,id',
            'amount' => 'required|numeric|min:0',
            'reason' => 'required|string|max:255',
        ]);

        $penalty = Penalty::create($validated);

        return response()->json([
            'message' => 'Penalty created successfully.',
            'data' => $penalty,
        ], 201);
    }

    public function update(Request $request, Penalty $penalty)
    {
        $validated = $request->validate([
            'order_id' => 'required|exists:orders,id',
            'amount' => 'required|numeric|min:0',
            'reason' => 'required|string|max:255',
        ]);

        $penalty->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Penalty updated successfully.',
            'data' => $penalty,
        ]);
    }
    public function destroy(Penalty $penalty)
    {
        $penalty->delete();

        return response()->json([
            'success' => true,
            'message' => 'Penalty deleted successfully.',
        ]);
    }

    public function show(Penalty $penalty)
    {
        return response()->json([
            'success' => true,
            'data' => $penalty->load('order'),
        ]);
    }
}
