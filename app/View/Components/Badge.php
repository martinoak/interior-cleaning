<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

class Badge extends Component
{
    public mixed $red;
    public mixed $orange;
    public mixed $triangle;
    public mixed $text;

    public function __construct(mixed $red = false, mixed $orange = false, mixed $triangle = false, string $text = '')
    {
        $this->red = $red;
        $this->orange = $orange;
        $this->triangle = $triangle;
        $this->text = $text;
    }

    public function render(): View
    {
        return view('components.badge');
    }
}
