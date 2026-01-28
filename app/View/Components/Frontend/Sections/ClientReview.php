<?php

namespace App\View\Components\Frontend\Sections;

use Closure;
use App\Enums\Status;
use Illuminate\View\Component;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Cache;  
use Modules\Testimonial\Entities\Testimonial;

class ClientReview extends Component
{
    public $widget;

    /**
     * Create a new component instance.
     */
    public function __construct($widget)
    {
        $this->widget   = $widget;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        $testimonials = Cache::rememberForever('testimonials', function () {
            return Testimonial::with('upload')->where('status', Status::ACTIVE)->orderBy('position', 'asc')->paginate(settings('paginate_value'));
        });

        return view('components.frontend.sections.client-review', compact('testimonials'));
    }
}
