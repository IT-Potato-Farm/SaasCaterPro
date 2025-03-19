<?php

namespace App\View\Components\packages;

use App\Models\PackageItem;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class addPackageOptionBtn extends Component
{
    /**
     * Create a new component instance.
     */
    public $packageItems;
    public function __construct()
    {
        $this->packageItems = PackageItem::all();
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.packages.add-package-option-btn');
    }
}
