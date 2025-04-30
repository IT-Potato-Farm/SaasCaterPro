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
    public $itemOptions;
    public $categories;
    public $items;
    public function __construct($itemOptions, $categories, $items)
    {
        $this->itemOptions = $itemOptions;
        $this->categories = $categories;
        $this->items = $items;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.packages.add-package-item-btn');
    }
}
