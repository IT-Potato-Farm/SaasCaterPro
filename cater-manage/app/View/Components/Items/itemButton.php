<?php

namespace App\View\Components\Items;

use App\Models\Category;
use Closure;
use App\Models\Menu;
use App\Models\MenuItem;
use Illuminate\View\Component;
use Illuminate\Contracts\View\View;

class itemButton extends Component
{
    /**
     * Create a new component instance.
     */
    
    public $categories;
    public function __construct()
    {
        
        $this->categories = Category::all();
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.items.item-button');
    }
}
