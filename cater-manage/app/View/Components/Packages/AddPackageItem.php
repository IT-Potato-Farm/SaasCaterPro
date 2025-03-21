<?php

namespace App\View\Components\Packages;

use Closure;
use App\Models\Package;
use App\Models\MenuItem;
use App\Models\PackageItem;
use Illuminate\View\Component;
use Illuminate\Contracts\View\View;

class AddPackageItem extends Component
{
    /**
     * Create a new component instance.
     */
     public $packages;
     public $package_items;
    public function __construct()
    {
        $this->packages = Package::all();
        $this->package_items = PackageItem::with('options')->get();
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.packages.add-package-item');
    }
}
