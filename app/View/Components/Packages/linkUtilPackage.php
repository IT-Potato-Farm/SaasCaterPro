<?php

namespace App\View\Components\packages;

use Closure;
use App\Models\Package;
use App\Models\PackageUtility;
use Illuminate\View\Component;
use Illuminate\Contracts\View\View;

class linkUtilPackage extends Component
{
    /**
     * Create a new component instance.
     */
    
    public $packages;
    public function __construct($packages)
    {

        $this->packages = $packages;
        
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.packages.link-util-package');
    }
}
