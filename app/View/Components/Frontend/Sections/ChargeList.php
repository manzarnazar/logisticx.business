<?php

namespace App\View\Components\Frontend\Sections;

use Closure;
use App\Enums\Area;
use App\Enums\Status;
use Illuminate\View\Component;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Cache;
use Modules\Widgets\Entities\Widgets;
use App\Models\Backend\Charges\Charge;

class ChargeList extends Component
{
    public $widget;
    
    /**
     * Create a new component instance.
     */
    public function __construct($widget)
    {
        $this->widget  = $widget;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        $insideCityCharges   = Cache::rememberForever('insideCityCharges', function () {
            return Charge::where('status', Status::ACTIVE)->where('area', Area::INSIDE_CITY)->orderBy('position')->paginate(settings('paginate_value'));
        });

        $outsideCityCharges   = Cache::rememberForever('outsideCityCharges', function () {
            return Charge::where('status', Status::ACTIVE)->where('area', Area::OUTSIDE_CITY)->orderBy('position')->paginate(settings('paginate_value'));
        });

        $subCityCharges   = Cache::rememberForever('subCityCharges', function () {
            return Charge::where('status', Status::ACTIVE)->where('area', Area::SUB_CITY)->orderBy('position')->paginate(settings('paginate_value'));
        });

        return view('components.frontend.sections.charge-list', compact('insideCityCharges', 'outsideCityCharges', 'subCityCharges'));
    }
}
