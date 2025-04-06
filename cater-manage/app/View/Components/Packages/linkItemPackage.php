<?php

namespace App\View\Components\packages;

use Closure;
use App\Models\Item;
use App\Models\Package;
use Illuminate\View\Component;
use Illuminate\Contracts\View\View;

class linkItemPackage extends Component
{
    /**
     * Create a new component instance.
     */
    public $packages;
    public $items;
    public function __construct()
    {
        $this->packages = Package::all();
        $this->items = Item::all();

    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.packages.link-item-package');
    }
}
