<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Review;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function store(Request $request)
    {
        try {
            // Retrieve the order first
            $order = Order::where('id', $request->order_id)
                    ->where('user_id', Auth::id())
                    ->where('status', 'completed')
                    ->first();

            ///   dd($order);

            // Check if the order exists and belongs to the user
            if (!$order) {
                return response()->json([
                    'success' => false,
                    'message' => 'You can only review completed orders.',
                ], 403);
            }

            // Check if the order already has a review
            if ($order->review) {
                return response()->json([
                    'success' => false,
                    'message' => 'You have already reviewed this order.',
                ], 400);
            }

            // Validate request inputs
            $request->validate([
                'rating' => 'required|integer|min:1|max:5',
                'review' => 'required|string|max:500',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Ensure valid image
            ]);

            // Handle Image Upload
            $imagePath = null;
            if ($request->hasFile('image')) {
                $imagePath = $request->file('image')->store('reviews', 'public');
            }

            // Create the review
            Review::create([
                'user_id' => Auth::id(),
                'order_id' => $order->id,
                'rating' => $request->rating,
                'review' => $request->review,
                'image' => $imagePath,
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
    }

    public function edit($id)
    {
        $review = Review::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        return view('reviews.edit', compact('review'));
    }

    public function update(Request $request, Review $review)
    {
        if ($review->user_id != Auth::id()) {
            return back()->with('error', 'Unauthorized action.');
        }

        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'review' => 'required|string|max:500',
        ]);

        $review->update([
            'rating' => $request->rating,
            'review' => $request->review,
        ]);

        return back()->with('success', 'Review updated successfully!');
    }

    public function destroy(Review $review)
    {
        if ($review->user_id != Auth::id()) {
            return back()->with('error', 'Unauthorized action.');
        }

        $review->delete();

        return back()->with('success', 'Review deleted successfully!');
    }

    public function index()
    {
        $reviews = Review::with('user', 'order')->latest()->get();
        return view('home', compact('reviews'));
    }

    public function adminIndex()
    {
        $reviews = Review::with('user', 'order')->latest()->get();
        return view('admin.reviews', compact('reviews'));
    }
}