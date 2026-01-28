<?php

namespace App\View\Components\Frontend\Sections;

use Closure;
use App\Enums\Status;
use Illuminate\View\Component;
use Illuminate\Contracts\View\View;
use Modules\Widgets\Entities\Widgets;

class Cta extends Component
{
    /**
     * Create a new component instance.
     */
    public $widget;

    public function __construct($widget)
    {
        $this->widget  = $widget;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.frontend.sections.cta');
    }
}
