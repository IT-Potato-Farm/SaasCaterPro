<?php

namespace App\View\Components\Packages;

use Closure;
use App\Models\Category;
use Illuminate\View\Component;
use Illuminate\Contracts\View\View;

class AddBtn extends Component
{
    /**
     * Create a new component instance.
     */
    public $categories;
    public $utilities;
    public $items;
    public function __construct($categories, $utilities, $items)
    {
        $this->categories = $categories;
        $this->items = $items;
        $this->utilities = $utilities;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.packages.add-btn');
    }
}
