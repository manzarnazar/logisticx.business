<?php

namespace App\View\Components\frontend\sections;

use Closure;
use App\Enums\Status;
use Illuminate\View\Component;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Cache;
use Modules\Faq\Entities\Faq;
use Modules\Service\Entities\Service;

class ServiceView extends Component
{
    /**
     * Create a new component instance.
     */
    public  $widget;
    public function __construct($widget)
    {
        $this->widget  = $widget;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        $services = Cache::rememberForever('services', function () {
            return Service::with('upload')->where('status', Status::ACTIVE)->orderBy('position', 'asc')->take(10)->get();
        });

        $faqs = Cache::rememberForever('features', function () {
            return Faq::where('status', Status::ACTIVE)->orderBy('position', 'asc')->take(5)->get();
        });
        return view('components.frontend.sections.service-view', compact('services', 'faqs'));
    }
}
