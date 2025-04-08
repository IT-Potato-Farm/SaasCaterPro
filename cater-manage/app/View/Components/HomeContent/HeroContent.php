<?php

namespace App\View\Components\HomeContent;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class HeroContent extends Component
{
    public string $title;
    public string $heading;
    public string $description;
    public string $tecc;
    public string $bacimg;

    public function __construct(
        string $title = '',
        string $heading = '',
        string $description = '',
        string $tecc = '',
        string $bacimg = ''
    ) {
        // dd ($title, $heading, $description, $tecc, $bacimg);
        $this->title = $title;
        $this->heading = $heading;
        $this->description = $description;
        $this->tecc = $tecc;
        $this->bacimg = $bacimg;
    }

    
    public function render(): View|Closure|string
    {
        return view('components.home-content.hero-content');
    }
}
