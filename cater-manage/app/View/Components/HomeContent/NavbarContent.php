<?php

namespace App\View\Components\HomeContent;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class NavbarContent extends Component
{
    public string $title;
    public string $logo;
    public string $bac;
    public string $tec;
    public string $buttonTextColor1;
    public string $buttonColor1;
    public string $buttonTextColor2;
    public string $buttonColor2;

    public function __construct(
        string $title = '',
        string $logo = '',
        string $bac = '',
        string $tec = '',    
        string $buttonTextColor1 = '',
        string $buttonColor1 = '',
        string $buttonTextColor2 = '',
        string $buttonColor2 = ''
    ) {
        // dd($title, $logo, $bac, $tec, $buttonTextColor1, $buttonColor1, $buttonTextColor2, $buttonColor2); 
        $this->title = $title;
        $this->logo = $logo;
        $this->bac = $bac;
        $this->tec = $tec;   
        $this->buttonTextColor1 = $buttonTextColor1;
        $this->buttonColor1 = $buttonColor1;
        $this->buttonTextColor2 = $buttonTextColor2;
        $this->buttonColor2 = $buttonColor2;
    }

    public function render(): View|Closure|string
    {
        return view('components.home-content.navbar-content');
    }

}