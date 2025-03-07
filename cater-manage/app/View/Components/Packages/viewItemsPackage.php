<?php

namespace App\View\Components\Packages;

use App\Models\PackageItem;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class viewItemsPackage extends Component
{
    /**
     * Create a new component instance.
     */
    public $packageItems;
    public function __construct()
    {
       $this->packageItems = PackageItem::with(['package', 'menuItem'])->get();
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.packages.view-items-package');
    }
}
