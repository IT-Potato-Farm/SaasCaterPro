<?php

namespace App\View\Components\HomeContent;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use App\Models\Review;

class RatingSectionContent extends Component
{
    public $reviews;
    public string $star;

    public function __construct(
        $reviews = null,
        string $star = ''
    )
    {
        $this->reviews = $reviews ?? Review::with('user')->latest()->get();
        $this->star = $star;
    }

    public function render(): View|Closure|string
    {
        return view('components.home-content.rating-section-content', ['reviews' => $this->reviews]);
    }
}
