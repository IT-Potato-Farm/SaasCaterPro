<?php

namespace App\View\Components\items;

use App\Models\ItemOption;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class itemOptionsList extends Component
{
    /**
     * Create a new component instance.
     */
    public $itemOptions;
    public function __construct()
    {
        $this->itemOptions = ItemOption::all();
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.items.item-options-list');
    }
}
