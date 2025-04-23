<?php

namespace App\View\Components\Dashboard;

use Closure;
use App\Models\User;
use Illuminate\View\Component;
use Illuminate\Contracts\View\View;

class Users extends Component
{
    /**
     * Create a new component instance.
     */
    public $users;
    public function __construct()
    {
        $this->users=User::all();
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.dashboard.users');
    }
}
