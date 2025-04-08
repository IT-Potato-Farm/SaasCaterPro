<?php

namespace App\View\Components\HomeContent;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class FooterContent extends Component
{
    public string $logo;
    public string $title;
    public string $bacc;
    public string $teccc;

    public function __construct(
        string $logo = '',
        string $title = '',
        string $bacc = '',
        string $teccc = ''
    ) {
        $this->logo = $logo;
        $this->title = $title;
        $this->bacc = $bacc;
        $this->teccc = $teccc;
    }

    
    public function render(): View|Closure|string
    {
        return view('components.home-content.footer-content');
    }
}
