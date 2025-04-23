<?php

namespace App\View\Components\Dashboard;

use Closure;
use App\Models\Category;
use App\Models\MenuItem;
use Illuminate\View\Component;
use Illuminate\Contracts\View\View;

class Products extends Component
{
    /**
     * Create a new component instance.
     */
    public $menuItems;
    public $categories;
    public function __construct()
    {
        $this->menuItems=MenuItem::all();
        $this->categories=Category::all();
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.dashboard.products');
    }
}
