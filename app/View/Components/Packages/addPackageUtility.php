<?php

namespace App\View\Components\packages;

use App\Models\Package;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class addPackageUtility extends Component
{
    /**
     * Create a new component instance.
     */
    public $packages;
    public $utilities;
    public $package_utilities;
    public function __construct($packages, $utilities, $packageUtilities)
    {
        $this->packages = $packages;
        $this->utilities = $utilities;
        $this->package_utilities = $packageUtilities;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.packages.add-package-utility');
    }
}
