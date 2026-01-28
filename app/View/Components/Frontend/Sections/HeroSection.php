<?php

namespace App\View\Components\Frontend\Sections;

use Closure;
use Illuminate\Http\Request;
use Illuminate\View\Component;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Cache;
use App\Repositories\Charge\ChargeInterface;
use App\Repositories\Coverage\CoverageInterface;
use App\Repositories\HomePageSlider\HomePageSliderInterface;

class HeroSection extends Component
{
    private $coverageRepo, $chargeRepo;

    public $widget;
    protected $sliderRepo;

    /**
     * Create a new component instance.
     */
    public function __construct(ChargeInterface $chargeRepo,HomePageSliderInterface $sliderRepo, CoverageInterface $coverageRepo, $widget)
    {
        $this->coverageRepo = $coverageRepo;
        $this->chargeRepo   = $chargeRepo;
        $this->widget       = $widget;
        $this->sliderRepo       = $sliderRepo;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        $request = new Request();
        $coverages =  Cache::rememberForever('coveragesWithActiveChild', fn() => $this->coverageRepo->getWithActiveChild($request));
        $homePageSlider =  Cache::rememberForever('homePageSlider', fn() => $this->sliderRepo->all());


        $productCategories = Cache::rememberForever('productCategories', fn() => $this->chargeRepo->getWithFilter(with: 'productCategory:id,name', columns: ['product_category_id']));
        return view('components.frontend.sections.hero-section', compact('coverages', 'productCategories', 'homePageSlider'));
    }
}
