<?php

namespace App\View\Components\utility;

use Closure;
use App\Models\Package;
use App\Models\Utility;
use App\Models\PackageUtility;
use Illuminate\View\Component;
use Illuminate\Contracts\View\View;

class utilitylist extends Component
{
    /**
     * Create a new component instance.
     */
    public $utilities;
    public $package_utilities;
    public $packages;

    public function __construct()
    {
        $this->utilities = Utility::with('packages')->get();
        $this->package_utilities = PackageUtility::all();
        $this->packages = Package::all();
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.utility.utilitylist');
    }
}
