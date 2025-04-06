<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Order;
use App\Models\Package;
use App\Models\Category;
use App\Models\ItemOption;
use App\Models\PackageItem;
use App\Models\PackageUtility;
use Illuminate\Http\Request;
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
    public function getItemOptions($itemId)
    {
        $item = Item::findOrFail($itemId);
        $options = $item->itemOptions; // Fetch the related item options for the item

        return response()->json([
            'success' => true,
            'options' => $options
        ]);
    }
    public function goUtilityDashboard()
    {
        if (Auth::check() && Auth::user()->role === 'admin') {
            $utilities =PackageUtility::all();
            $packages = Package::all();
            return view('admin.utilitydashboard', compact('utilities', 'packages'));
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
    public function goUserDashboard()
    {
        if (Auth::check() && Auth::user()->role === 'admin') {
            return view('admin.allusersdashboard');
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
