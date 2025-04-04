<?php

namespace App\View\Components\Customer;

use Closure;
use App\Models\Review;
use Illuminate\View\Component;
use Illuminate\Contracts\View\View;

class Ratingsection extends Component
{
    /**
     * Create a new component instance.
     */
    public $reviews;
    public function __construct($reviews = null)
    {
        $this->reviews = $reviews ?? Review::with('user')->latest()->get();
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.customer.ratingsection', ['reviews' => $this->reviews]);
    }
}
