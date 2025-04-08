<?php

namespace App\View\Components\HomeContent;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class AboutUsContent extends Component
{
    public string $title;
    public string $description;
    public string $textcolor;

    public function __construct(
        string $title = '',
        string $description = '',
        string $textcolor = ''
    )
    {
        $this->title = $title;
        $this->description = $description;
        $this->textcolor = $textcolor;
    }

    public function render(): View|Closure|string
    {
        return view('components.home-content.about-us-content');
    }
}
