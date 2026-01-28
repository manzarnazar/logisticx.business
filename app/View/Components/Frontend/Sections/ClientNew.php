<?php

namespace App\View\Components\Frontend\Sections;

use Closure;
use App\Enums\Status;
use Illuminate\View\Component;
use Illuminate\Contracts\View\View;
use Modules\Client\Entities\Client;
use Illuminate\Support\Facades\Cache;
use Modules\Widgets\Entities\Widgets;

class ClientNew extends Component
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
        $clients = Cache::rememberForever('clients', function () {
            return Client::where('status', Status::ACTIVE)->orderBy('position', 'asc')->paginate(settings('paginate_value'));
        });

        return view('components.frontend.sections.client-new', compact('clients'));
    }
}
