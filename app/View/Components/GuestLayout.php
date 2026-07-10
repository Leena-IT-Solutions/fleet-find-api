<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

class GuestLayout extends Component
{
    public bool $plain;

    /**
     * Create a new component instance.
     */
    public function __construct(bool $plain = false)
    {
        $this->plain = $plain;
    }

    /**
     * Get the view / contents that represents the component.
     */
    public function render(): View
    {
        return view('layouts.guest');
    }
}
