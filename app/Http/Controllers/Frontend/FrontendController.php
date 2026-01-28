<?php

namespace App\Http\Controllers\Frontend;

use App\Enums\Area;
use App\Enums\Status;
use Illuminate\Http\Request;
use App\Models\Backend\Parcel;
use App\Models\Backend\Coverage;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
use App\Models\Backend\Charges\Charge;
use App\Repositories\Charge\ChargeInterface;
use Modules\Pages\Repositories\PagesInterface;
use App\Repositories\Coverage\CoverageInterface;
use Modules\Blog\Repositories\Blog\BlogInterface;
use Modules\Widgets\Repositories\WidgetsInterface;
use Modules\Service\Repositories\Service\ServiceInterface;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Modules\Faq\Entities\Faq;

class FrontendController extends Controller
{

    protected $blogRepo, $widget, $coverageRepo, $chargeRepo, $pageRepo, $serviceRepo;

    protected $data = [];

    public function __construct(
        BlogInterface $blogRepo,
        WidgetsInterface $widget,
        CoverageInterface $coverageRepo,
        ChargeInterface $chargeRepo,
        PagesInterface $pageRepo,
        ServiceInterface $serviceRepo
    ) {
        $this->widget       = $widget;
        $this->blogRepo     = $blogRepo;
        $this->coverageRepo = $coverageRepo;
        $this->chargeRepo   = $chargeRepo;
        $this->pageRepo     = $pageRepo;
        $this->serviceRepo   = $serviceRepo;
    }

    // Home
    public function index(Request $request)
    {

        $this->data['widgets']           = $this->widget->getWidget(status: Status::ACTIVE);

        // return $this->data['widgets'];
        return view('frontend.pages.home', $this->data);
    }


    public function about()
    {
        $page = Cache::rememberForever('about_us', fn() => $this->pageRepo->page('about_us'));

        return view('frontend.pages.about', compact('page'));
    }

    public function privacyReturn()
    {
        $page = Cache::rememberForever('privacy_policy', fn() => $this->pageRepo->page('privacy_policy'));

        return view('frontend.pages.privacy_return', compact('page'));
    }

    public function terms_Condition()
    {
        $page = Cache::rememberForever('terms_conditions', fn() => $this->pageRepo->page('terms_conditions'));

        return view('frontend.pages.terms_condition', compact('page'));
    }

    public function track(Request $request)
    {
        $parcel =  Parcel::with('parcelEvent')->where('tracking_id', $request->tracking_id)->first();

        return view('frontend.pages.track', compact('parcel'));
    }

    // Charges

    public function charges()
    {
        $insideCityCharges   = Cache::rememberForever('insideCityCharges', function () {
            return Charge::where('status', Status::ACTIVE)->where('area', Area::INSIDE_CITY)->orderBy('position', 'desc')->paginate(settings('paginate_value'));
        });

        $outsideCityCharges   = Cache::rememberForever('outsideCityCharges', function () {
            return Charge::where('status', Status::ACTIVE)->where('area', Area::OUTSIDE_CITY)->orderBy('position', 'desc')->paginate(settings('paginate_value'));
        });

        $subCityCharges   = Cache::rememberForever('subCityCharges', function () {
            return Charge::where('status', Status::ACTIVE)->where('area', Area::SUB_CITY)->orderBy('position', 'desc')->paginate(settings('paginate_value'));
        });

        $coverages =  Cache::rememberForever('coveragesWithActiveChild', fn() => $this->coverageRepo->getWithActiveChild(Status::ACTIVE));

        $productCategories  = Cache::rememberForever('productCategories', fn() => $this->chargeRepo->getWithFilter(with: 'productCategory:id,name', columns: ['product_category_id']));

        $calculatorWidget =  $this->widget->activeDeliveryCalculator();
        $chargeListWidget =  $this->widget->activeChargeListSection();

        return view('frontend.pages.charges', compact('calculatorWidget', 'chargeListWidget', 'productCategories', 'coverages', 'insideCityCharges', 'outsideCityCharges', 'subCityCharges'));
    }

    // Coverages

    public function coverage(Request $request)
    {
        $request->validate(['q' => 'nullable|string|max:100']);

        if ($request->input('q')) {
            $coverages = $this->coverageRepo->all(where: ['status' => Status::ACTIVE], search: $request->input('q'));
        } else {
            $coverages = Cache::rememberForever('coverages', fn() =>  $this->coverageRepo->all(where: ['status' => Status::ACTIVE]));
        }



        $districts    = Coverage::whereNull('parent_id')->get();
        $allCoverages = Coverage::with('parent.parent')->get();
        $mapped       = collect();

        foreach ($districts as $district) {
            foreach ($allCoverages as $coverage) {
                if (is_null($coverage->parent_id)) continue;

                $actualDistrict = null;

                if ($coverage->parent && is_null($coverage->parent->parent_id)) {
                    $actualDistrict = $coverage->parent;
                    $type = $actualDistrict->id === $district->id ? 'Inside City' : 'Outside City';


                    if ($type == 'Inside City') {

                        $cod = settings('cod_inside_city');

                        $charge = Charge::where('area', Area::INSIDE_CITY->value)->where('product_category_id', 1)->where('service_type_id', 1)->first();
                        $charges[1] = [$charge->charge, $charge->charge + $charge->additional_charge, $charge->charge + ($charge->additional_charge * 2)];

                        $charge = Charge::where('area', Area::INSIDE_CITY->value)->where('product_category_id', 2)->where('service_type_id', 1)->first();
                        $charges[2] = [$charge->charge, $charge->charge + $charge->additional_charge, $charge->charge + ($charge->additional_charge * 2)];
                    } elseif ($type == 'Outside City') {

                        $cod = settings('cod_outside_city');



                        $charge = Charge::where('area', Area::OUTSIDE_CITY->value)->where('product_category_id', 1)->where('service_type_id', 1)->first();
                        $charges[1] = [$charge->charge, $charge->charge + $charge->additional_charge, $charge->charge + ($charge->additional_charge * 2)];

                        $charge = Charge::where('area', Area::OUTSIDE_CITY->value)->where('product_category_id', 2)->where('service_type_id', 1)->first();
                        $charges[2] = [$charge->charge, $charge->charge + $charge->additional_charge, $charge->charge + ($charge->additional_charge * 2)];
                    } else {
                        $cod = 0;
                        $charges = [];
                    }
                } elseif ($coverage->parent && $coverage->parent->parent && is_null($coverage->parent->parent->parent_id)) {
                    $actualDistrict = $coverage->parent->parent;
                    $type = $actualDistrict->id === $district->id ? 'Sub City' : 'Outside City';


                    if ($type == 'Sub City') {

                        $cod = settings('cod_sub_city');

                        $charge = Charge::where('area', Area::SUB_CITY->value)->where('product_category_id', 1)->where('service_type_id', 1)->first();
                        $charges[1] = [$charge->charge, $charge->charge + $charge->additional_charge, $charge->charge + ($charge->additional_charge * 2)];

                        $charge = Charge::where('area', Area::SUB_CITY->value)->where('product_category_id', 2)->where('service_type_id', 1)->first();
                        $charges[2] = [$charge->charge, $charge->charge + $charge->additional_charge, $charge->charge + ($charge->additional_charge * 2)];
                    } elseif ($type == 'Outside City') {

                        $cod = settings('cod_outside_city');


                        $charge = Charge::where('area', Area::OUTSIDE_CITY->value)->where('product_category_id', 1)->where('service_type_id', 1)->first();
                        $charges[1] = [$charge->charge, $charge->charge + $charge->additional_charge, $charge->charge + ($charge->additional_charge * 2)];

                        $charge = Charge::where('area', Area::OUTSIDE_CITY->value)->where('product_category_id', 2)->where('service_type_id', 1)->first();
                        $charges[2] = [$charge->charge, $charge->charge + $charge->additional_charge, $charge->charge + ($charge->additional_charge * 2)];
                    } else {
                        $cod = 0;
                        $charges = [];
                    }
                } else {
                    $type = 'Unknown';
                }

                // Filter by keyword
                $keyword = $request->keyword === $district->name ? $district->name : null;
                $keyword = $request->keyword === $coverage->name ? $coverage->name : null;
                $keyword = $request->keyword === $actualDistrict->name ? $actualDistrict->name : null;
                $keyword = $request->keyword === $type ? $type : null;

                $inputKeyword = strtolower($request->keyword);
                $matchKeyword = false;

                if (
                    $inputKeyword &&
                    (
                        str_contains(strtolower($district->name), $inputKeyword) ||
                        str_contains(strtolower($coverage->name), $inputKeyword) ||
                        str_contains(strtolower($actualDistrict->name ?? ''), $inputKeyword) ||
                        str_contains(strtolower($type), $inputKeyword)
                    )
                ) {
                    $matchKeyword = true;
                }

                // Apply type filter if provided
                if (
                    ($request->filled('type') && $request->type !== $type) ||
                    ($request->filled('keyword') && !$matchKeyword)
                ) {
                    continue;
                }

                $mapped->push([
                    'district' => $district->name,
                    'thana_area' => $coverage->name,
                    'type' => $type,
                    'charges' => $charges,
                    'cod' => $cod
                ]);
            }
        }


        // Paginate
        $perPage = 10;
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $pagedData = $mapped->slice(($currentPage - 1) * $perPage, $perPage)->values();
        $coverages = new LengthAwarePaginator($pagedData, $mapped->count(), $perPage, $currentPage, [
            'path' => $request->url(),
            'query' => $request->query(), // keeps type in URL
        ]);

        return view('frontend.pages.coverage', compact('coverages'));
    }

    // Blog

    public function blogs(Request $request)
    {
        $request->validate(['q' => 'nullable|string|max:100']);

        $paginate = ceil(settings('paginate_value') / 4) * 4;

        if ($request->input('q') || $request->input('page')) {
            $key = "blogs_" . $request->input('q') . $request->input('page');
            $blogs = Cache::remember($key, now()->addMinutes(10), fn() => $this->blogRepo->all(status: Status::ACTIVE, search: $request->input('q'), paginate: $paginate, orderBy: 'updated_at'));
        } else {
            $blogs = Cache::rememberForever("blogs", fn() => $this->blogRepo->all(status: Status::ACTIVE, paginate: $paginate, orderBy: 'position'));
        }

        $blogs->withPath('/blogs');

        return view('frontend.pages.blogs', compact('blogs'));
    }

    public function blogSingle($slug)
    {
        $blog =  $this->blogRepo->findBySlug($slug);

        $blogs = Cache::rememberForever("recent_blogs", fn() => $this->blogRepo->all(status: Status::ACTIVE, paginate: settings('paginate_value'), orderBy: 'created_at'));

        return view('frontend.pages.blog-single', compact('blog', 'blogs'));
    }


    public function serviceDetails($id)
    {

        $serviceDetails = $this->serviceRepo->get($id);
        $services = Cache::rememberForever("services", fn() => $this->serviceRepo->all(Status::ACTIVE, 'created_at'));

        $faqs = Cache::rememberForever('faqs', function () {
            return Faq::where('status', Status::ACTIVE)->orderBy('position', 'asc')->take(5)->get();
        });

        $blogs = Cache::rememberForever("recent_blogs", fn() => $this->blogRepo->all(status: Status::ACTIVE, paginate: settings('paginate_value'), orderBy: 'created_at'));
        return view('frontend.pages.service-details', compact('serviceDetails', 'services', 'blogs', 'faqs'));
    }

    //contact

    public function contactUs()
    {
        return view('frontend.pages.contact_us');
    }
}
