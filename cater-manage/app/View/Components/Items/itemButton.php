<?php

namespace App\View\Components\Items;

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
    public $items;
    public function __construct()
    {
        $this->items = Menu::all();
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.items.item-button');
    }
}
