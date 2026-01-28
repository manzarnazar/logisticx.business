<?php

namespace App\View\Components\frontend\sections;

use Closure;
use App\Enums\Status;
use Illuminate\View\Component;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Cache;
use Modules\Features\Entities\Features;

class HowItWorkView extends Component
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

        $features = Cache::rememberForever('how_it_works', fn() => Features::where('status', Status::ACTIVE)->orderBy('position', 'asc')->take(10)->get());

        return view('components.frontend.sections.how-it-work-view', compact('features'));
    }
}
