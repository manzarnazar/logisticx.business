<?php

namespace App\View\Components\Frontend\Sections;

use Closure;
use App\Enums\Status;
use Illuminate\View\Component;
use App\Models\Backend\Coverage;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Cache;
use Modules\Widgets\Entities\Widgets;
use App\Repositories\Charge\ChargeInterface;
use App\Repositories\Coverage\CoverageInterface;
use App\Repositories\ServiceType\ServiceTypeInterface;

class DeliveryCalculator extends Component
{
    private $coverageRepo, $chargeRepo;

    public $widget;

    /**
     * Create a new component instance.
     */
    public function __construct(ChargeInterface $chargeRepo, CoverageInterface $coverageRepo, $widget)
    {
        $this->coverageRepo = $coverageRepo;
        $this->chargeRepo   = $chargeRepo;
        $this->widget       = $widget;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        // $coverages =  Cache::rememberForever('coveragesWithActiveChild', fn() => $this->coverageRepo->getWithActiveChild(Status::ACTIVE));

        $coverages = Coverage::where('status', Status::ACTIVE)->with('activeChild')->get();

        $productCategories = Cache::rememberForever('productCategories', fn() => $this->chargeRepo->getWithFilter(with: 'productCategory:id,name', columns: ['product_category_id']));

        $serviceTypes = Cache::rememberForever('serviceTypes', fn() => $this->chargeRepo->getWithFilter(with: 'serviceType:id,name', columns: ['service_type_id']));

        return view('components.frontend.sections.delivery-calculator', compact('coverages', 'productCategories', 'serviceTypes'));
    }
}
