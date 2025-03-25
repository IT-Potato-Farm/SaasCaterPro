<?php

namespace App\View\Components\Dashboard;

use Closure;
use App\Models\User;
use App\Models\Order;
use Illuminate\View\Component;
use Illuminate\Contracts\View\View;

class FirstSection extends Component
{
    /**
     * Create a new component instance.
     */
    public $totalUsers;
    public $completedOrdersCount;
    public $pendingOrdersCount;
    public function __construct()
    {
        $this->totalUsers = User::count();
        $this->completedOrdersCount = Order::where('status', 'completed')->count();
        $this->pendingOrdersCount = Order::where('status', 'pending')->count();
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.dashboard.first-section');
    }
}
