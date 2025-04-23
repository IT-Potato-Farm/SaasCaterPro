<?php

namespace App\View\Components\Customer;

use Closure;
use App\Models\Package;
use App\Models\Category;
use App\Models\MenuItem;
use Illuminate\View\Component;
use Illuminate\Contracts\View\View;

class MenuSection extends Component
{
    /**
     * Create a new component instance.
     */
   
    public $packages;

    public function __construct()
    {
        $this->packages =Package::all();
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.customer.menu-section');
    }
}
