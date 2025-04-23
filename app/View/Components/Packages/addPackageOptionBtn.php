<?php

namespace App\View\Components\packages;

use Closure;
use App\Models\Package;
use App\Models\PackageItem;
use Illuminate\View\Component;
use Illuminate\Contracts\View\View;

class addPackageOptionBtn extends Component
{
    /**
     * Create a new component instance.
     */
    public $packageItems;
    public $packages;
    
    public function __construct($packages, $packageItems)
    {
        $this->packageItems = $packageItems;
        $this->packages = $packages;
        
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.packages.add-package-option-btn');
    }
}
