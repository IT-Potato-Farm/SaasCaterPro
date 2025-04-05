<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Auth;

class UserDashboardController extends Controller
{
    public function index()
    {
        $orders = Order::where('user_id', Auth::id())
            ->with('review')
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

    // for review
    public function showReview($id)
    {
        $order = Order::findOrFail($id);

        if ($order->user_id != Auth::id()) {
            return redirect()->route('home')->with('error', 'Unauthorized access.');
        }
        
        return view('order-review', compact('order'));
    }

    public function editReview(Order $order)
    {
        if ($order->user_id != Auth::id()) {
            return redirect()->route('home')->with('error', 'Unauthorized access.');
        }

        if (!$order->review) {
            return redirect()->route('home')->with('error', 'No review found for this order.');
        }

        return view('edit-review', compact('order'));
    }

    public function updateReview(Request $request, Order $order)
    {
        if ($order->user_id != Auth::id()) {
            return redirect()->route('home')->with('error', 'Unauthorized access.');
        }
    
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'review' => 'required|string|max:500',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
    
        $review = $order->review;
        $review->update([
            'rating' => $request->rating,
            'review' => $request->review,
        ]);
    
        
        if ($request->hasFile('image')) {
            
            $reviewsPath = public_path('reviews');
            if (!File::exists($reviewsPath)) {
                File::makeDirectory($reviewsPath, 0755, true, true);
            }
    
            $image = $request->file('image');
            $imageName = time() . '-' . $image->getClientOriginalName(); 
    
            $image->move($reviewsPath, $imageName);
    
            $review->image = $imageName;
            $review->save();
        }
    
        return redirect()->route('showReview', $order->id)->with('success', 'Review updated successfully!');
    }

}
