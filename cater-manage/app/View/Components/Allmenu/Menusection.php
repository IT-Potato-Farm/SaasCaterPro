<?php

namespace App\View\Components\Allmenu;

use Closure;
use App\Models\Category;
use App\Models\MenuItem;
use Illuminate\View\Component;
use Illuminate\Contracts\View\View;

class Menusection extends Component
{
    /**
     * Create a new component instance.
     */
    public $menuItems;
    public $categories;
    public function __construct()
    {
        $this->menuItems = MenuItem::where('status', 'available')->get();
        $this->categories = Category::orderBy('name', 'asc')->get();
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.allmenu.menusection');
    }
}
