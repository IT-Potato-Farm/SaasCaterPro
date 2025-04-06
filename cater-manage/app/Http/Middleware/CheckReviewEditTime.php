<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Review;

class CheckReviewEditTime
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        
        $order = $request->route('order');

        $review = is_object($order)
            ? $order->review
            : Review::where('order_id', $order)->first();

        if (!$review) {
            return redirect()->route('userdashboard')->with('error', 'Review not found.');
        }

        if (now()->diffInMinutes($review->created_at) > 15) {
            return redirect()->route('userdashboard')->with('error', 'You can only edit a review within 15 minutes of posting.');
        }

        return $next($request);
    }
}
