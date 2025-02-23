<?php

namespace App\View\Components;

use Closure;
use App\Models\Category;
use Illuminate\View\Component;
use Illuminate\Contracts\View\View;

class showCategory extends Component
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
        return view('components.show-category');
    }
}
