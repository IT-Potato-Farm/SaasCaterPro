<?php

namespace App\View\Components\HomeContent;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class WhyChooseUsContent extends Component
{
    public string $title;
    public string $heading;
    public string $description;
    public string $textcolor;

    public function __construct(
        string $title = '',
        string $heading = '',
        string $description = '',
        string $textcolor = ''
    )
    {
        // dd($title, $heading, $description, $textcolor);
       $this->title = $title;
       $this->heading = $heading;
       $this->description = $description;
       $this->textcolor = $textcolor;

    }

    public function render(): View|Closure|string
    {
        return view('components.home-content.why-choose-us-content');
    }
}
