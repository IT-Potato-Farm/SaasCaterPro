<?php

namespace App\View\Components\items;

use Closure;
use App\Models\Item;
use Illuminate\View\Component;
use Illuminate\Contracts\View\View;

class itemList extends Component
{
    /**
     * Create a new component instance.
     */
    public $items;
    public function __construct($items)
    {
        $this->items = $items;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.items.item-list');
    }
}
