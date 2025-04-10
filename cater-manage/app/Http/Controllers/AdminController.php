<?php

namespace App\Http\Controllers;

use App\Models\Utility;
use Carbon\Carbon;
use App\Models\Item;
use App\Models\User;
use App\Models\Order;
use App\Models\Package;
use App\Models\Category;
use App\Models\ItemOption;
use App\Models\PackageItem;
use Illuminate\Http\Request;
use App\Models\PackageUtility;
use App\Models\PackageItemOption;
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
            return view('admin.finaldashboard');
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
            return view('admin.productsdashboard');
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

            $items = Item::all();
            $itemOptions = ItemOption::all();
            $packages = Package::all();

            return view('admin.packagesdashboard', compact('packageItemsGroupedByPackage', 'items', 'itemOptions', 'packages'));
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



    public function goBookingsDashboard()
    {
        if (Auth::check() && Auth::user()->role === 'admin') {
            return view('admin.bookingsdashboard');
        }

        return redirect('/')->with('error', 'Access denied! Only admins can access this page.');
    }
    public function goReportsDashboard()
    {
        if (Auth::check() && Auth::user()->role === 'admin') {
            return view('admin.reportsdashboard');
        }

        return redirect('/')->with('error', 'Access denied! Only admins can access this page.');
    }
    public function goUserDashboard()
    {
        if (Auth::check() && Auth::user()->role === 'admin') {
            return view('admin.allusersdashboard');
        }

        return redirect('/')->with('error', 'Access denied! Only admins can access this page.');
    }

    public function goCustomerReport()
    {
        if (Auth::check() && Auth::user()->role === 'admin') {

            $customers = User::where('role', 'customer')
                ->with(['orders' => function ($query) {
                    $query->with('orderItems');
                }])
                ->get();

            
            $reportData = $customers->map(function ($customer) {
                $totalAmountSpent = $customer->orders->sum(function ($order) {
                    return $order->total + $order->penalty_fee; // Sum of total and penalty fee for each order
                });

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
                    'total_amount_spent' => $totalAmountSpent,
                    'number_of_bookings' => $numberOfBookings,
                    'most_popular_packages' => $popularPackages,
                    'frequency_of_bookings' => $frequencyOfBookings,
                ];
            });
            return view('reports.customerreport', compact('reportData'));
        }

        return redirect('/')->with('error', 'Access denied! Only admins can access this page.');
    }
    public function dashboard()
    {
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
        return view('admin.admindashboard', compact('packages', 'packageItemsGroupedByPackage'));
    }
}
