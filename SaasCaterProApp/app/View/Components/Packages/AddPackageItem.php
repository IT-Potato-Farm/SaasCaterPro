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
     public $menu_items;
     public $existingPackageItems;
    public function __construct()
    {
        $this->packages = Package::all();
        $this->menu_items = MenuItem::all();
        $this->existingPackageItems = PackageItem::pluck('menu_item_id')->toArray();
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.packages.add-package-item');
    }
}
