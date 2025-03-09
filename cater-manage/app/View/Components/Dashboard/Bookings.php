<?php

namespace App\View\Components\Dashboard;

use Closure;
use App\Models\Order;
use Illuminate\View\Component;
use Illuminate\Contracts\View\View;

class Bookings extends Component
{
    /**
     * Create a new component instance.
     */
    public $orders;
    public function __construct()
    {
        $this->orders = Order::with('user')->orderBy('created_at', 'desc')->paginate(10);
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.dashboard.bookings');
    }
}
