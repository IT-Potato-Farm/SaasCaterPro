<?php

namespace App\View\Components\packages;

use App\Models\Package;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class addPackageItemBtn extends Component
{
    /**
     * Create a new component instance.
     */
    // public $packages;
    public function __construct()
    {
        // $this->packages = Package::all();
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.packages.add-package-item-btn');
    }
}
