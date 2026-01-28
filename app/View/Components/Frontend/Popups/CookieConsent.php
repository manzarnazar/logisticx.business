<?php

namespace App\View\Components\Frontend\Popups;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class CookieConsent extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.frontend.popups.cookie-consent');
    }

    public function shouldRender()
    {
        return auth()->check() && !auth()->user()->cookie_consent;
    }
}
