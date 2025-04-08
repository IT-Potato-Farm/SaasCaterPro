<?php

namespace App\View\Components\HomeContent;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use App\Models\Package;

class MenuSectionContent extends Component
{
    public $packages;

    public string $title;
    public string $textcolor;
    public string $buttonColor;
    public string $buttonTextColor;

    public function __construct(
        string $title = '',
        string $textcolor = '',
        string $buttonColor = '',
        string $buttonTextColor = ''

    ) {
        $this->packages =Package::all();

        $this->title = $title;
        $this->textcolor = $textcolor;
        $this->buttonColor = $buttonColor;
        $this->buttonTextColor = $buttonTextColor;
    }

    public function render(): View|Closure|string
    {
        return view('components.home-content.menu-section-content');
    }
}
