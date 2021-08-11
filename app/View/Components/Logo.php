<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

class Logo extends Component
{
    /**
     * Get the view / contents that represent the component.
     *
     * @return View
     */
    public function render(): View
    {
        return view('components.logo');
    }
}
