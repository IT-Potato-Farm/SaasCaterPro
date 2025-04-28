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
    public function index()
    {
        $reviews = Review::with(['user', 'order'])
            ->latest() 
            ->paginate(10); 

        $averageRating = Review::avg('rating') ?? 0;
        return view('allreview', compact('reviews', 'averageRating'));
    }

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



            // Validate the incoming request (including the image)
            $request->validate([
                'rating' => 'required|integer|min:1|max:5',
                'review' => 'required|string|max:500',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',  // Validate image
            ]);

            $imageName = null;
            if ($request->hasFile('image')) {
                $imageName = $this->handleImageUpload($request->file('image'));
            }




            // Create the review
            Review::create([
                'user_id' => Auth::id(),
                'order_id' => $request->order_id,  // Assuming you're getting order_id from the request
                'rating' => $request->rating,
                'review' => $request->review,
                'image' => $imageName,
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
    protected function handleImageUpload($image)
    {
        return basename($image->store('reviews', 'public'));
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
        // if ($review->user_id != Auth::id()) {
        //     return back()->with('error', 'Unauthorized action.');
        // }
        if ($review->image && Storage::disk('public')->exists('reviews/' . $review->image)) {
            Storage::disk('public')->delete('reviews/' . $review->image);
        }
    
        $review->delete();
    
        return back()->with('success', 'Review deleted successfully!');
    }



    public function adminIndex()
    {
        $reviews = Review::with('user', 'order')->latest()->get();
        return view('admin.reviews', compact('reviews'));
    }
}
