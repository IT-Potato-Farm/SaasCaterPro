<?php

namespace App\Http\Controllers;

use DatePeriod;
use DateInterval;
use Carbon\Carbon;
use App\Models\Item;
use App\Models\User;
use App\Models\Order;
use App\Models\Package;
use App\Models\Utility;
use App\Models\Category;
use App\Models\MenuItem;
use App\Models\OrderItem;
use App\Models\ItemOption;
use App\Models\PackageItem;
use Illuminate\Http\Request;
use App\Models\BookingSetting;
use App\Models\PackageUtility;
use App\Models\PackageItemOption;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function index()
    {
        // user authenticated and admin
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            return redirect('/')->with('error', 'Access denied! Only admins can access this page.');
        }


        $packages = Package::all();
        $packageItemsGroupedByPackage = PackageItem::all()
            ->groupBy('package_id')
            ->map(function ($group) {
                return $group->map(function ($item) {
                    return ['id' => $item->id, 'name' => $item->name];
                });
            })->toArray();

        // Pass the packages to view
        return view('admin.dashboard', compact('packages', 'packageItemsGroupedByPackage'));
    }


    public function goDashboard()
    {
        if (Auth::check() && Auth::user()->role === 'admin') {
            $setting = BookingSetting::first();
            return view('admin.finaldashboard', compact('setting'));
        }

        return redirect('/')->with('error', 'Access denied! Only admins can access this page.');
    }
    public function gosettingDashboard()
    {
        if (Auth::check() && Auth::user()->role === 'admin') {
            $setting = BookingSetting::first();
            return view('admin.settingdashboard', compact('setting'));
        }

        return redirect('/')->with('error', 'Access denied! Only admins can access this page.');
    }
    public function goCategoryDashboard()
    {
        if (Auth::check() && Auth::user()->role === 'admin') {
            return view('admin.categoriesdashboard');
        }

        return redirect('/')->with('error', 'Access denied! Only admins can access this page.');
    }
    public function goProductsDashboard()
    {
        if (Auth::check() && Auth::user()->role === 'admin') {
            $menuItems = MenuItem::all();
            $categories = Category::all();
            return view('admin.productsdashboard', compact('categories', 'menuItems'));
        }

        return redirect('/')->with('error', 'Access denied! Only admins can access this page.');
    }
    public function goPackageDashboard()
    {
        if (Auth::check() && Auth::user()->role === 'admin') {
            $packageItemsGroupedByPackage = PackageItem::all()
                ->groupBy('package_id')
                ->map(function ($group) {
                    return $group->map(function ($item) {
                        return ['id' => $item->id, 'name' => $item->name];
                    });
                })->toArray();
            $categories = Category::all();
            // $items = Item::with('itemOptions')->get();
            $items = Item::with('itemOptions')->get();
            // $itemOptions = ItemOption::all();
            $itemOptions = ItemOption::with('category')->get();

            $packages = Package::all();
            $packageItems = PackageItem::all();
            $menuItems = MenuItem::all();
            $utilities = Utility::with('packages')->get();
            $package_utilities = PackageUtility::all();
            return view('admin.packagesdashboard', compact('packageItemsGroupedByPackage',  'items', 'categories', 'itemOptions', 'packages', 'packageItems', 'menuItems', 'utilities', 'package_utilities'));
        }

        return redirect('/')->with('error', 'Access denied! Only admins can access this page.');
    }
    public function getItemOptions($itemId, Request $request)
    {
        $item = Item::with('itemOptions')->findOrFail($itemId);
        $packageId = $request->query('package_id');

        $linkedOptionIds = [];

        if ($packageId) {
            $packageItem = PackageItem::where('package_id', $packageId)
                ->where('item_id', $itemId)
                ->first();

            if ($packageItem) {
                $linkedOptionIds = PackageItemOption::where('package_item_id', $packageItem->id)
                    ->pluck('item_option_id')
                    ->toArray();
            }
        }

        return response()->json([
            'success' => true,
            'options' => $item->itemOptions->map(function ($option) use ($linkedOptionIds) {
                return [
                    'id' => $option->id,
                    'type' => $option->type,
                    'already_linked' => in_array($option->id, $linkedOptionIds),
                ];
            })
        ]);
    }



    public function goUtilityDashboard()
    {
        if (Auth::check() && Auth::user()->role === 'admin') {
            $utilities = Utility::with('packages')->get();
            $package_utilities = PackageUtility::all();
            $packages = Package::all();
            return view('admin.utilitydashboard', compact('utilities', 'package_utilities', 'packages'));
        }

        return redirect('/')->with('error', 'Access denied! Only admins can access this page.');
    }



    public function goBookingsDashboard(Request $request)
    {
        if (Auth::check() && Auth::user()->role === 'admin') {
            $perPage = $request->input('entries', 10);
            $perPage = in_array($perPage, [5, 10, 15, 20, 25]) ? $perPage : 10;
            $requestedSort = $request->input('sort', 'created_at');
            $sortDirection = $request->input('direction', 'desc');

            // Validate direction
            $sortDirection = in_array($sortDirection, ['asc', 'desc']) ? $sortDirection : 'desc';

            // List of allowed user-friendly sort keys
            $allowedColumns = ['id', 'status', 'total', 'amount_paid', 'created_at', 'event_date_start', 'user_first_name'];

            $requestedSort = in_array($requestedSort, $allowedColumns) ? $requestedSort : 'created_at';

            $sortMap = [
                'user_first_name' => 'users.first_name',
            ];

            // Final sort column to use in query
            $sortColumn = $sortMap[$requestedSort] ?? $requestedSort;

            // Build the query
            // $query = Order::with('user');
            $query = Order::active()->with('user');


            if ($request->filled('status')) {
                $query->where('status', $request->input('status'));
            }

            if ($request->filled('status')) {
                $query->where('status', $request->input('status'));
            }

            if ($request->filled('date_from')) {
                $query->whereDate('event_date_start', '>=', $request->input('date_from'));
            }

            if ($request->filled('date_to')) {
                $query->whereDate('event_date_end', '<=', $request->input('date_to'));
            }


            // Search term
            $search = $request->input('search', '');

            // Apply search if provided
            if (!empty($search)) {
                $query->where(function ($q) use ($search) {
                    $q->where('id', 'like', "%{$search}%")
                        ->orWhere('status', 'like', "%{$search}%")
                        ->orWhere('event_type', 'like', "%{$search}%")
                        ->orWhereHas('user', function ($q) use ($search) {
                            $q->where('first_name', 'like', "%{$search}%")
                                ->orWhere('last_name', 'like', "%{$search}%")
                                ->orWhere('email', 'like', "%{$search}%");
                        });
                });
            }

            // Join users if sorting by user fields
            if (str_contains($sortColumn, 'users.')) {
                $query->join('users', 'orders.user_id', '=', 'users.id')
                    ->select('orders.*');
            }
            // Apply sorting
            $query->orderBy($sortColumn, $sortDirection);


            // Get orders with pagination
            $orders = $query->paginate($perPage);

            $statusStyles = [
                'pending' => ['bg' => 'bg-yellow-100', 'text' => 'text-yellow-800'],
                'partially paid' => ['bg' => 'bg-yellow-100', 'text' => 'text-yellow-800'],
                'ongoing' => ['bg' => 'bg-blue-100', 'text' => 'text-blue-800'],
                'paid' => ['bg' => 'bg-green-100', 'text' => 'text-green-800'],
                'completed' => ['bg' => 'bg-green-200', 'text' => 'text-green-800'],
                'cancelled' => ['bg' => 'bg-red-100', 'text' => 'text-red-800'],
            ];

            foreach ($orders as $order) {
                $status = strtolower($order->status);
                $style = $statusStyles[$status] ?? ['bg' => 'bg-gray-100', 'text' => 'text-gray-800'];
                $order->bgColor = $style['bg'];
                $order->textColor = $style['text'];
            }
            $statusFilter = $request->input('status', null);

            return view('admin.bookingsdashboard', compact('orders', 'statusFilter', 'perPage', 'sortColumn', 'sortDirection', 'search', 'statusStyles'));
        }

        return redirect('/')->with('error', 'Access denied! Only admins can access this page.');
    }
    private function calculateGrowthPercentage($currentOrders, $previousOrders)
    {
        if ($previousOrders > 0) {
            $growthPercentage = (($currentOrders - $previousOrders) / $previousOrders) * 100;
            return number_format($growthPercentage, 1) >= 0 ? '+' . number_format($growthPercentage, 1) . '%' : number_format($growthPercentage, 1) . '%';
        } else {
            return $currentOrders > 0 ? '+100%' : 'New'; // Handle new data cases
        }
    }

    public function goReportsDashboard()
    {
        if (Auth::check() && Auth::user()->role === 'admin') {
            // SALES PERFORMANCE
            $weeklySales = collect([]);
            for ($i = 4; $i >= 0; $i--) {
                $weekStart = now()->subWeeks($i)->startOfWeek();
                $weekEnd = now()->subWeeks($i)->endOfWeek();

                $total = Order::whereBetween('created_at', [$weekStart, $weekEnd])
                    ->where('status', 'completed')
                    ->sum('total');

                $weeklySales->push(round($total, 2));
            }

            $totalOrders = Order::count();
            // Current Week Completed Orders


            // Current Week Completed Orders
            $currentWeekOrders = Order::where('status', 'completed')
                ->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])
                ->count();

            // Previous Week Completed Orders
            $previousWeekOrders = Order::where('status', 'completed')
                ->whereBetween('created_at', [Carbon::now()->subWeek()->startOfWeek(), Carbon::now()->subWeek()->endOfWeek()])
                ->count();

            // Current Month Completed Orders
            $currentMonthOrders = Order::where('status', 'completed')
                ->whereMonth('created_at', now()->month)
                ->whereYear('created_at', now()->year)
                ->count();

            // Previous Month Completed Orders
            $previousMonthOrders = Order::where('status', 'completed')
                ->whereMonth('created_at', now()->subMonth()->month)
                ->whereYear('created_at', now()->subMonth()->year)
                ->count();

            // Weekly Growth Calculation
            $weeklyGrowthFormatted = $this->calculateGrowthPercentage($currentWeekOrders, $previousWeekOrders);

            // Monthly Growth Calculation
            $monthlyGrowthFormatted = $this->calculateGrowthPercentage($currentMonthOrders, $previousMonthOrders);







            $completedOrders = Order::where('status', 'completed')->count();
            $pendingOrders = Order::where('status', 'pending')->count();
            $ordersToday = Order::whereDate('event_date_start', '<=', now())
                ->whereDate('event_date_end', '>=', now())
                ->where('status', '!=', 'cancelled')
                ->count();

            $totalRevenue = Order::where('status', 'completed')->sum('total');
            // today revenue
            $todayRevenue = Order::where('status', 'completed')
                ->whereDate('created_at', Carbon::today())
                ->sum('total');

            // yesterday
            $yesterdayStart = Carbon::yesterday()->startOfDay();
            $yesterdayEnd = Carbon::yesterday()->endOfDay();

            $yesterdayRevenue = Order::where('status', 'completed')
                ->whereBetween('event_date_start', [$yesterdayStart, $yesterdayEnd])
                ->sum('total');


            $yesterdayData = Order::selectRaw('HOUR(event_date_start) as hour, SUM(total) as total')
                ->where('status', 'completed')
                ->whereBetween('event_date_start', [$yesterdayStart, $yesterdayEnd])
                ->groupBy('hour')
                ->pluck('total', 'hour')
                ->toArray();

            // Ensure all 24 hours are present
            $hours = range(0, 23);
            $yesterdayRevenueChart = [];
            $yesterdayRevenueLabels = [];

            foreach ($hours as $hour) {
                $label = Carbon::createFromTime($hour)->format('g A'); // 1 AM, 2 AM, 12 PM
                $yesterdayRevenueLabels[] = $label;
                $yesterdayRevenueChart[] = $yesterdayData[$hour] ?? 0;
            }


            // THIS WEEK
            $thisWeekRevenue = Order::where('status', 'completed')
                ->whereBetween('created_at', [
                    Carbon::now()->startOfWeek(),
                    Carbon::now()->endOfWeek()
                ])
                ->sum('total');

            // THIS CURRENT YR
            $yearRevenue = Order::where('status', 'completed')
                ->whereYear('created_at', now()->year)
                ->sum('total');

            // LAST YR
            $lastYearRevenue = Order::where('status', 'completed')
                ->whereYear('created_at', now()->subYear()->year)
                ->sum('total');

            // MONTH
            $monthRevenue = Order::where('status', 'completed')
                ->whereYear('created_at', now()->year)
                ->whereMonth('created_at', now()->month)
                ->sum('total');

            $eventTypeRevenue = Order::where('status', 'completed')
                ->selectRaw('event_type, SUM(total) as total_revenue')
                ->groupBy('event_type')
                ->pluck('total_revenue', 'event_type')
                ->toArray();

            // CHART REVENUE
            // today
            $todayRevenueChart = array_fill(0, 24, 0);
            $todayData = Order::selectRaw('HOUR(created_at) as hour, SUM(total) as total')
                ->where('status', 'completed')
                ->whereDate('created_at', Carbon::today())
                ->groupBy('hour')
                ->orderBy('hour')
                ->pluck('total', 'hour')
                ->toArray();

            foreach ($todayData as $hour => $total) {
                $todayRevenueChart[$hour] = $total;
            }

            $todayRevenueLabels = [];
            for ($i = 0; $i < 24; $i++) {
                $todayRevenueLabels[] = Carbon::createFromTime($i)->format('g A');
            }

            // This Month (Daily)
            // This month's revenue with correct number of days
            $daysInMonth = Carbon::now()->daysInMonth;
            $thisMonthRevenueChart = array_fill(0, $daysInMonth, 0);
            $thisMonthData = Order::selectRaw('DAY(event_date_start) as day, SUM(total) as total')
                ->where('status', 'completed')
                ->whereYear('event_date_start', now()->year)
                ->whereMonth('event_date_start', now()->month)
                ->groupBy('day')
                ->orderBy('day')
                ->pluck('total', 'day')
                ->toArray();

            foreach ($thisMonthData as $day => $total) {
                $thisMonthRevenueChart[$day - 1] = $total; // Adjust for 0-based array
            }

            $thisMonthRevenueLabels = [];
            for ($i = 1; $i <= $daysInMonth; $i++) {
                $thisMonthRevenueLabels[] = Carbon::createFromDate(now()->year, now()->month, $i)->format('F j'); // Example: "April 1"
            }
            // THIS WEEK

            $weekStart = Carbon::now()->startOfWeek();
            $weekEnd = Carbon::now()->endOfWeek();


            $thisWeekData = Order::selectRaw('DAYNAME(event_date_start) as day, SUM(total) as total')
                ->where('status', 'completed')
                ->whereBetween('event_date_start', [$weekStart, $weekEnd])
                ->groupBy('day')
                ->pluck('total', 'day')
                ->mapWithKeys(function ($total, $day) {
                    return [ucfirst(strtolower($day)) => $total];
                })
                ->toArray();

            // Ensure all 7 days are present
            $weekDays = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
            $thisWeekRevenueChart = [];
            foreach ($weekDays as $day) {
                $thisWeekRevenueChart[] = $thisWeekData[$day] ?? 0;
            }
            $thisWeekRevenueLabels = $weekDays;

            // LAST 6 MONTHS START DATE
            $sixMonthsAgo = Carbon::now()->subMonths(6)->startOfMonth();
            $now = Carbon::now();

            $lastSixMonthsRevenue = Order::whereBetween('event_date_start', [$sixMonthsAgo, $now])
                ->where('status', 'completed')
                ->sum('total');

            $lastSixMonthsRevenueDataRaw = Order::selectRaw('DATE_FORMAT(event_date_start, "%b %Y") as month, SUM(total) as total')
                ->whereBetween('event_date_start', [$sixMonthsAgo, $now])
                ->where('status', 'completed')
                ->groupBy('month')
                ->orderByRaw('MIN(event_date_start)')
                ->pluck('total', 'month')
                ->toArray();

            // Ensure all 6 months are present, even if zero
            $lastSixMonthsRevenueLabels = [];
            $lastSixMonthsRevenueChart = [];
            $period = new DatePeriod(
                $sixMonthsAgo,
                new DateInterval('P1M'),
                $now->copy()->addMonth()->startOfMonth()  // one extra to include current month
            );

            foreach ($period as $monthDate) {
                $label = $monthDate->format('M Y');  // e.g. Apr 2025
                $lastSixMonthsRevenueLabels[] = $label;
                $lastSixMonthsRevenueChart[] = $lastSixMonthsRevenueDataRaw[$label] ?? 0;
            }

            // dd($thisMonthRevenueChart);
            // CHART TOTAL EARNINGS
            $currentYear = now()->year;
            $lastYear = now()->subYear()->year;

            $thisYearData = Order::selectRaw('MONTH(event_date_start) as month, SUM(total) as total')
                ->whereYear('event_date_start', $currentYear)
                ->where('status', 'completed')
                ->groupBy('month')
                ->pluck('total', 'month')
                ->toArray();

            $lastYearData = Order::selectRaw('MONTH(event_date_start) as month, SUM(total) as total')
                ->whereYear('event_date_start', $lastYear)
                ->where('status', 'completed')
                ->groupBy('month')
                ->pluck('total', 'month')
                ->toArray();

            $thisYearRevenueChart = [];
            $lastYearRevenueChart = [];

            for ($i = 1; $i <= 12; $i++) {
                $thisYearRevenueChart[] = $thisYearData[$i] ?? 0;
                $lastYearRevenueChart[] = $lastYearData[$i] ?? 0;
            }
            // MOST POPULAR PACKAGE
            $popularPackages = OrderItem::select('item_reference_id', DB::raw('COUNT(*) as total'))
                ->where('item_type', 'package')
                ->groupBy('item_reference_id')
                ->orderByDesc('total')
                ->limit(5)
                ->get();

            $topPackages = $popularPackages->map(function ($item) {
                $package = Package::find($item->item_reference_id);
                return [
                    'name' => $package ? $package->name : 'Unknown Package',
                    'total' => $item->total
                ];
            });

            $upcomingOrders = Order::whereDate('event_date_start', Carbon::tomorrow())
                ->orderBy('event_date_start', 'asc')
                ->get();

            return view('admin.reportsdashboard', compact(
                'weeklySales',
                'totalOrders',
                'completedOrders',
                'upcomingOrders',
                'pendingOrders',
                'ordersToday',
                'totalRevenue',
                'todayRevenue',
                'yesterdayRevenue',
                'yesterdayRevenueChart',
                'yesterdayRevenueLabels',
                'thisWeekRevenue',
                'yearRevenue',
                'lastYearRevenue',
                'monthRevenue',
                'eventTypeRevenue',
                'todayRevenueChart',
                'todayRevenueLabels',
                'thisMonthRevenueChart',
                'thisMonthRevenueLabels',
                'thisWeekRevenueChart',
                'thisWeekRevenueLabels',
                'thisYearRevenueChart',
                'lastYearRevenueChart',
                'topPackages',
                'lastSixMonthsRevenue',
                'lastSixMonthsRevenueChart',
                'lastSixMonthsRevenueLabels',
                'weeklyGrowthFormatted',
                'monthlyGrowthFormatted'
            ));
        }

        return redirect('/')->with('error', 'Access denied! Only admins can access this page.');
    }

    public function goUserDashboard()
    {
        if (Auth::check() && Auth::user()->role === 'admin') {
            $users = User::paginate(10);
            return view('admin.allusersdashboard', compact('users'));
        }

        return redirect('/')->with('error', 'Access denied! Only admins can access this page.');
    }

    public function goCustomerReport(Request $request)
    {
        if (Auth::check() && Auth::user()->role === 'admin') {

            $query = User::where('role', 'customer')
                ->whereHas('orders');

            if ($request->has('date_range') && $request->date_range) {
                $dates = explode(' - ', $request->date_range);
                if (count($dates) == 2) {
                    $startDate = Carbon::parse($dates[0]);
                    $endDate = Carbon::parse($dates[1]);
                    $query->whereHas('orders', function ($query) use ($startDate, $endDate) {
                        $query->whereBetween('event_date_start', [$startDate, $endDate]);
                    });
                }
            }

            if ($request->has('customer_type') && $request->customer_type) {
                $customerType = $request->customer_type;
                if ($customerType === 'new') {
                    $query->whereDoesntHave('orders', function ($q) {
                        $q->whereDate('created_at', '<', Carbon::now()->subMonths(6));
                    });
                } elseif ($customerType === 'returning') {
                    $query->whereHas('orders', function ($q) {
                        $q->whereDate('created_at', '>=', Carbon::now()->subMonths(6));
                    });
                }
            }

            // 1. First get all matching customers
            $customers = $query->with(['orders.penalties', 'orders.orderItems'])->get();

            // 2. Then filter manually for min_spend
            if ($request->has('min_spend') && $request->min_spend) {
                $minSpend = $request->min_spend;

                $customers = $customers->filter(function ($customer) use ($minSpend) {
                    $totalSpend = $customer->orders->sum(function ($order) {
                        $penaltyTotal = $order->penalties->sum('amount');
                        return $order->total + $penaltyTotal;
                    });
                    return $totalSpend >= $minSpend;
                });
            }

            $reportData = $customers->map(function ($customer) {
                $totalAmountSpent = $customer->orders
                    ->where('status', 'completed')
                    ->sum('total');

                $numberOfBookings = $customer->orders->count();

                // Get most popular packages chosen by the customer
                $popularPackages = $customer->orders->flatMap(function ($order) {
                    return $order->orderItems->where('item_type', 'package')->pluck('item_reference_id');
                })
                    ->countBy()
                    ->sortDesc()
                    ->keys()
                    ->take(3);
                $popularPackageNames = Package::whereIn('id', $popularPackages)->pluck('name');
                $popularPackages = $popularPackageNames->toArray();

                $frequencyOfBookings = $customer->orders->groupBy(function ($order) {
                    // Check if it's already a Carbon instance
                    $eventDate = $order->event_date_start instanceof Carbon ? $order->event_date_start : Carbon::parse($order->event_date_start);
                    return $eventDate->format('Y-m-d');
                })->count();

                return [
                    'customer_name' => $customer->first_name . ' ' . $customer->last_name,
                    'contact_information' => $customer->email . ' # ' . $customer->mobile,
                    'mobile' => $customer->mobile,
                    'total_amount_spent' => $totalAmountSpent,
                    'number_of_bookings' => $numberOfBookings,
                    'most_popular_packages' => $popularPackages,
                    'frequency_of_bookings' => $frequencyOfBookings,
                    'latest_event_date' => $customer->orders->max('event_date_start'),
                ];
            });
            return view('reports.customerreport', compact('reportData'));
        }

        return redirect('/')->with('error', 'Access denied! Only admins can access this page.');
    }
    // public function dashboard()
    // {
    //     if (!Auth::check() || Auth::user()->role !== 'admin') {
    //         return redirect('/')->with('error', 'Access denied! Only admins can access this page.');
    //     }
    //     $packages = Package::all();
    //     $packageItemsGroupedByPackage = PackageItem::all()
    //         ->groupBy('package_id')
    //         ->map(function ($group) {
    //             return $group->map(function ($item) {
    //                 return ['id' => $item->id, 'name' => $item->name];
    //             });
    //         })->toArray();
    //     return view('admin.admindashboard', compact('packages', 'packageItemsGroupedByPackage'));
    // }
    public function customChartRange(Request $request)
    {
        $startDate = Carbon::parse($request->startDate)->startOfDay();
        $endDate = Carbon::parse($request->endDate)->endOfDay();

        // Ensure we have valid start/end dates
        if ($endDate->lt($startDate)) {
            return response()->json([
                'error' => 'End date must be after start date'
            ], 400);
        }

        // Query orders that fall within or overlap with the selected date range
        $orders = Order::where('status', 'completed')
            ->where(function ($query) use ($startDate, $endDate) {
                // Order starts within range
                $query->whereBetween('event_date_start', [$startDate, $endDate])
                    // OR order ends within range
                    ->orWhereBetween('event_date_end', [$startDate, $endDate])
                    // OR order spans the entire range (starts before and ends after)
                    ->orWhere(function ($q) use ($startDate, $endDate) {
                        $q->where('event_date_start', '<=', $startDate)
                            ->where('event_date_end', '>=', $endDate);
                    });
            })
            ->get();

        // Generate all dates in the range to ensure we have continuous data for the chart
        $dateRange = [];
        $current = $startDate->copy();

        while ($current->lte($endDate)) {
            $dateRange[$current->format('Y-m-d')] = 0;
            $current->addDay();
        }

        // Assign orders to dates (can be proportional or full amount based on your business logic)
        foreach ($orders as $order) {
            $orderStart = Carbon::parse($order->event_date_start);
            $orderEnd = Carbon::parse($order->event_date_end);

            // Adjust dates to be within our range
            if ($orderStart->lt($startDate)) {
                $orderStart = $startDate->copy();
            }

            if ($orderEnd->gt($endDate)) {
                $orderEnd = $endDate->copy();
            }

            // Calculate days within range
            $daysInRange = $orderStart->diffInDays($orderEnd) + 1;

            if ($daysInRange <= 1) {
                // If single day or same day, assign full amount to that day
                $dateKey = $orderStart->format('Y-m-d');
                $dateRange[$dateKey] += $order->total;
            } else {
                // For multi-day events, either:
                // Option 1: Distribute evenly across days
                $amountPerDay = $order->total / $daysInRange;

                $currentDay = $orderStart->copy();
                while ($currentDay->lte($orderEnd)) {
                    $dateKey = $currentDay->format('Y-m-d');
                    $dateRange[$dateKey] += $amountPerDay;
                    $currentDay->addDay();
                }

                // Option 2: Alternatively, assign full amount to start date only
                // Uncomment below and comment the above if you prefer this approach
                // $dateKey = $orderStart->format('Y-m-d');
                // $dateRange[$dateKey] += $order->total;
            }
        }

        // Prepare data for chart
        $total = array_sum($dateRange);

        // If too many dates for a readable chart, consider aggregating by week or month
        if (count($dateRange) > 31) {
            // Group by week or month for better visualization when range is large
            $aggregatedData = $this->aggregateDataByPeriod($dateRange, $startDate, $endDate);
            return response()->json($aggregatedData);
        }

        return response()->json([
            'labels' => array_keys($dateRange),
            'data' => array_values($dateRange),
            'total' => $total
        ]);
    }

    // Helper function to aggregate data by week or month for larger date ranges
    private function aggregateDataByPeriod($dateRange, $startDate, $endDate)
    {
        $diffInDays = $startDate->diffInDays($endDate);

        if ($diffInDays > 90) {
            // Aggregate by month for ranges > 90 days
            return $this->aggregateByMonth($dateRange);
        } else {
            // Aggregate by week for ranges between 31-90 days
            return $this->aggregateByWeek($dateRange);
        }
    }

    private function aggregateByWeek($dateRange)
    {
        $weeklyData = [];
        $weeklyLabels = [];

        foreach ($dateRange as $date => $value) {
            $carbon = Carbon::parse($date);
            $weekKey = $carbon->startOfWeek()->format('M d') . ' - ' . $carbon->endOfWeek()->format('M d');

            if (!isset($weeklyData[$weekKey])) {
                $weeklyData[$weekKey] = 0;
                $weeklyLabels[] = $weekKey;
            }

            $weeklyData[$weekKey] += $value;
        }

        return [
            'labels' => $weeklyLabels,
            'data' => array_values($weeklyData),
            'total' => array_sum($weeklyData)
        ];
    }

    private function aggregateByMonth($dateRange)
    {
        $monthlyData = [];
        $monthlyLabels = [];

        foreach ($dateRange as $date => $value) {
            $monthKey = Carbon::parse($date)->format('M Y');

            if (!isset($monthlyData[$monthKey])) {
                $monthlyData[$monthKey] = 0;
                $monthlyLabels[] = $monthKey;
            }

            $monthlyData[$monthKey] += $value;
        }

        return [
            'labels' => $monthlyLabels,
            'data' => array_values($monthlyData),
            'total' => array_sum($monthlyData)
        ];
    }
}
