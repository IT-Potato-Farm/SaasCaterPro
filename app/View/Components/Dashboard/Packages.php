<?php

namespace App\View\Components\dashboard;

use App\Models\Category;
use App\Models\Package;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Packages extends Component
{
    /**
     * Create a new component instance.
     */
    public $packages;
    public $categories;
    public function __construct()
    {
        $this->packages=Package::all(); 
        $this->categories=Category::all(); 
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.dashboard.packages');
    }
}
