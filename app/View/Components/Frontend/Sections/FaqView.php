<?php

namespace App\View\Components\frontend\sections;

use Closure;
use App\Enums\Status;
use Modules\Faq\Entities\Faq;
use Illuminate\View\Component;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Cache;

class FaqView extends Component
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
        $faqs = Cache::rememberForever('faqs', function () {
            return Faq::where('status', Status::ACTIVE)->orderBy('position', 'asc')->take(10)->get();
        });
        return view('components.frontend.sections.faq-view', compact('faqs'));
    }
}
