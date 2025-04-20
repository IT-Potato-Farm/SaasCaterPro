<?php

namespace App\View\Components\actions;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class StatusBadge extends Component
{
    /**
     * Create a new component instance.
     */
    public $status;
    public $bgColor;
    public $textColor;
    public function __construct($status)
    {
        $this->status = $status;

        $statusStyles = [
            'pending' => ['bg' => 'bg-yellow-100', 'text' => 'text-yellow-800'],
            'partially paid' => ['bg' => 'bg-yellow-100', 'text' => 'text-yellow-800'],
            'ongoing' => ['bg' => 'bg-blue-100', 'text' => 'text-blue-800'],
            'paid' => ['bg' => 'bg-green-100', 'text' => 'text-green-800'],
            'completed' => ['bg' => 'bg-green-200', 'text' => 'text-green-800'],
            'cancelled' => ['bg' => 'bg-red-100', 'text' => 'text-red-800'],
        ];
        $style = $statusStyles[strtolower($status)] ?? ['bg' => 'bg-gray-100', 'text' => 'text-gray-800'];
        $this->bgColor = $style['bg'];
        $this->textColor = $style['text'];
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.actions.status-badge');
    }
}
