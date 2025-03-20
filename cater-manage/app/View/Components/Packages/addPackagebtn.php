<?php

namespace App\View\Components\packages;

use Closure;
use App\Models\Category;
use App\Models\Package;
use Illuminate\View\Component;
use Illuminate\Contracts\View\View;

class addPackagebtn extends Component
{
    /**
     * Create a new component instance.
     */
    public $categories;
    public $packages;
    public function __construct()
    {
        $this->categories = Category::all();
        $this->packages = Package::all();
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.packages.add-packagebtn');
    }
}
