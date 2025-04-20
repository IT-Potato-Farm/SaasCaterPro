<?php

namespace App\View\Components\Dashboard;

use Closure;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Order;
use App\Models\Package;
use App\Models\OrderItem;
use Illuminate\View\Component;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\View\View;

class FirstSection extends Component
{
    /**
     * Create a new component instance.
     */
    public $totalUsers;
    public $completedOrdersCount;
    public $pendingOrdersCount;
    public $totalRevenue;
    public $todayRevenue;
    public $yearRevenue;
    public $lastYearRevenue;
    public $monthRevenue;
    public $thisYearRevenueChart;
    public $lastYearRevenueChart;
    public $mostPopular;
    public $mostPopularCount;
    public $mostPopularPackage;
    public $mostFrequentEvent;
    public $ordersToday;
    public $returningCustomers;
    public function __construct()
    {
        $this->totalUsers = User::count();

        $this->mostPopular = OrderItem::select('item_reference_id', DB::raw('COUNT(*) as total'))
            ->where('item_type', 'package')
            ->groupBy('item_reference_id')
            ->orderByDesc('total')
            ->first();
        $this->mostPopularPackage = $this->mostPopular ? Package::find($this->mostPopular->item_reference_id) : null;
        $this->mostPopularCount = $this->mostPopular ? $this->mostPopular->total : 0;

        // FREQUENT EVENT
        $this->mostFrequentEvent = Order::select('event_type', DB::raw('count(*) as total'))
            ->groupBy('event_type')
            ->orderByDesc('total')
            ->first()?->event_type;
        // ORDERS TODAY
        $this->ordersToday = Order::whereDate('event_date_start', '<=', today())
            ->whereDate('event_date_end', '>=', today())
            ->where('status', '!=', 'cancelled')
            ->count();
            

        // RETURNINGG CUSTOMRRT
        $this->returningCustomers = Order::whereNotNull('user_id')
            ->where('status', '!=', 'cancelled')
            ->select('user_id')
            ->groupBy('user_id')
            ->havingRaw('COUNT(*) > 1')
            ->get()
            ->count();

        $this->completedOrdersCount = Order::where('status', 'completed')->count();
        $this->pendingOrdersCount = Order::where('status', 'pending')->count();
        $this->totalRevenue = Order::where('status', 'completed')->sum('total');
        
        $this->todayRevenue = Order::where('status', 'completed')
            ->whereDate('created_at', Carbon::today())
            ->sum('total');

        // THIS CURRENT YR
        $this->yearRevenue = Order::where('status', 'completed')
            ->whereYear('created_at', now()->year)
            ->sum('total');

        // LAST YR
        $this->lastYearRevenue = Order::where('status', 'completed')
            ->whereYear('created_at', now()->subYear()->year)
            ->sum('total');

        // MONTH
        $this->monthRevenue = Order::where('status', 'completed')
            ->whereYear('created_at', now()->year)
            ->whereMonth('created_at', now()->month)
            ->sum('total');

        // CHART TOTAL EARNINGS FUNC
        $currentYear = now()->year;
        $lastYear = now()->subYear()->year;

        $thisYearData = Order::selectRaw('MONTH(created_at) as month, SUM(total) as total')
            ->whereYear('created_at', $currentYear)
            ->where('status', 'completed')
            ->groupBy('month')
            ->pluck('total', 'month')
            ->toArray();

        $lastYearData = Order::selectRaw('MONTH(created_at) as month, SUM(total) as total')
            ->whereYear('created_at', $lastYear)
            ->where('status', 'completed')
            ->groupBy('month')
            ->pluck('total', 'month')
            ->toArray();

        // Fill missing months with 0
        $this->thisYearRevenueChart = [];
        $this->lastYearRevenueChart = [];

        for ($i = 1; $i <= 12; $i++) {
            $this->thisYearRevenueChart[] = $thisYearData[$i] ?? 0;
            $this->lastYearRevenueChart[] = $lastYearData[$i] ?? 0;
        }
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.dashboard.first-section');
    }
}
