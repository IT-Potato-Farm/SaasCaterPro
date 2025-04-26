<?php

namespace App\View\Components\utility;

use Closure;
use App\Models\Package;
use App\Models\Utility;
use App\Models\PackageUtility;
use Illuminate\View\Component;
use Illuminate\Contracts\View\View;

class UtilityList extends Component
{
    /**
     * Create a new component instance.
     */
    public $utilities;
    public $package_utilities;
    public $packages;

    public function __construct($utilities, $packageUtilities, $packages)
    {
        $this->utilities = $utilities;
        $this->package_utilities = $packageUtilities;
        $this->packages = $packages;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.utility.utilitylist');
    }
}
