<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class ReviewController extends Controller
{
    public function store(Request $request)
    {
        try {
            // Working Code
            $order = Order::where('id', $request->order_id)
                    ->where('user_id', Auth::id())
                    ->where('status', 'completed')
                    ->first();
            // Working Code

            // Not Yet Tested
            if (!$order) {
                return response()->json([
                    'success' => false,
                    'message' => 'You can only review completed orders.',
                ], 403);
            }
            if ($order->review) {
                return response()->json([
                    'success' => false,
                    'message' => 'You have already reviewed this order.',
                ], 400);
            }
            // Not Yet Tested

            // Working Code
            $request->validate([
                'rating' => 'required|integer|min:1|max:5',
                'review' => 'required|string|max:500',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', 
            ]);

            if ($request->hasFile('image')) {
                $reviewsPath = public_path('reviews');
                if (!File::exists($reviewsPath)) {
                    File::makeDirectory($reviewsPath, 0755, true, true);
                }
            
                $image = $request->file('image');
                $imageName = time() . '-' . $image->getClientOriginalName();
            
                $image->move($reviewsPath, $imageName);
            }

            Review::create([
                'user_id' => Auth::id(),
                'order_id' => $request->order_id,  // Assuming you're getting order_id from the request
                'rating' => $request->rating,
                'review' => $request->review,
                'image' => isset($imageName) ? $imageName : null,  // Store image name if available
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Review submitted successfully!',
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }

        // Working Code
    }

    // Function properly
    public function index()
    {
        $reviews = Review::with('user', 'order')->latest()->get();
        return view('home', compact('reviews'));
    }
    // Function properly

    public function deleteReview(Order $order, Review $review)
    {
        if ($order->user_id != Auth::id()) {
            return redirect()->route('home')->with('error', 'Unauthorized access.');
        }
        if ($review->order_id !== $order->id) {
            return redirect()->route('home')->with('error', 'Review not found for this order.');
        }

        if ($review->image) {
            $imagePath = public_path('reviews/' . $review->image);
            if (File::exists($imagePath)) {
                File::delete($imagePath);
            }
        }

        $review->delete();


        return redirect()->route('userdashboard')->with('success', 'Review deleted successfully!');
    }

}