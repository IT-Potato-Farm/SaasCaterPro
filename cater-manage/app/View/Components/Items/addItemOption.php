<?php

namespace App\View\Components\items;

use Closure;
use App\Models\Item;
use Illuminate\View\Component;
use Illuminate\Contracts\View\View;

class addItemOption extends Component
{
    /**
     * Create a new component instance.
     */
    public $item;
    
    public function __construct(Item $item)
    {
        $this->item = $item;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.items.add-item-option', ['item' => $this->item]);
    }
}
