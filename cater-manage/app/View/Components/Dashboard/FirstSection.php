<?php

namespace App\View\Components\Dashboard;

use Closure;
use App\Models\User;
use Illuminate\View\Component;
use Illuminate\Contracts\View\View;

class FirstSection extends Component
{
    /**
     * Create a new component instance.
     */
    public $totalUsers;
    public function __construct()
    {
        $this->totalUsers = User::count();
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.dashboard.first-section');
    }
}
