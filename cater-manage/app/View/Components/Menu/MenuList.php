<?php

namespace App\View\Components\menu;

use Closure;
use App\Models\Menu;
use Illuminate\View\Component;
use Illuminate\Contracts\View\View;

class MenuList extends Component
{
    /**
     * Create a new component instance.
     */
    public $menus;
    public function __construct()
    {
        $this->menus = Menu::all();
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.menu.menu-list');
    }
}
