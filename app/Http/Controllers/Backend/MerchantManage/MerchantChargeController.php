<?php

namespace App\Http\Controllers\Backend\MerchantManage;

use App\Enums\Status;
use App\Http\Controllers\Controller;
use App\Http\Requests\Merchant\MerchantChargeStoreRequest;
use App\Http\Requests\Merchant\MerchantChargeUpdateRequest;
use App\Http\Requests\Merchant\MerchantCODChargeUpdateRequest;
use App\Models\Backend\Charges\Charge;
use App\Models\Backend\MerchantCharge;
use App\Repositories\Charge\ChargeInterface;
use App\Repositories\Merchant\MerchantInterface;
use App\Repositories\Merchant\DeliveryCharge\MerchantChargeInterface;
use App\Repositories\ProductCategory\ProductCategoryInterface;
use App\Repositories\ServiceType\ServiceTypeInterface;
use Illuminate\Http\Request;

class MerchantChargeController extends Controller
{
    private $repo;
    protected $repoMerchant;
    protected $repoProductCategory;
    protected $repoServiceType;
    protected $chargeRepo;

    public function __construct(
        MerchantChargeInterface $repo,
        MerchantInterface $repoMerchant,
        ProductCategoryInterface $repoProductCategory,
        ServiceTypeInterface $repoServiceType,
        ChargeInterface $chargeRepo,
    ) {
        $this->repo                 = $repo;
        $this->repoMerchant         = $repoMerchant;
        $this->repoProductCategory  = $repoProductCategory;
        $this->repoServiceType      = $repoServiceType;
        $this->chargeRepo           = $chargeRepo;
    }

    public function index($merchant_id)
    {
        $charges = $this->repo->all($merchant_id, paginate: settings('paginate_value'));

        return view('backend.merchant.delivery-charge.index', compact('charges', 'merchant_id'));
    }

    public function create($merchant_id)
    {
        $existingChargeIds = MerchantCharge::where('merchant_id', $merchant_id)->pluck('charge_id');

        $product_categories = Charge::with('productCategory:id,name')
            ->whereNotIn('id', $existingChargeIds)
            ->where('status', Status::ACTIVE)
            ->get(['id', 'product_category_id'])
            ->unique('product_category_id');

        return view('backend.merchant.delivery-charge.create', compact('merchant_id', 'product_categories'));
    }

    public function store(MerchantChargeStoreRequest $request, $merchant)
    {
        $result = $this->repo->store($request);
        if ($result['status']) {
            return redirect()->route('merchant.deliveryCharge.index', $merchant)->with('success', $result['message']);
        }
        return back()->with('danger', $result['message']);
    }

    public function edit($merchant_id, $charge_id)
    {
        $charge             = $this->repo->get($charge_id);
        $product_categories = $this->repoProductCategory->all(Status::ACTIVE, ['id', 'name']);
        $service_types      = $this->repoServiceType->all(Status::ACTIVE, ['id', 'name']);

        return view('backend.merchant.delivery-charge.edit', compact('service_types', 'product_categories', 'charge', 'merchant_id'));
    }

    public function update(MerchantChargeUpdateRequest $request, $merchant_id)
    {
        $result = $this->repo->update($request);
        if ($result['status']) {
            return redirect()->route('merchant.deliveryCharge.index', $merchant_id)->with('success', $result['message']);
        }
        return back()->with('danger', $result['message']);
    }

    public function delete($merchant_id, $id)
    {
        if ($this->repo->delete($id)) :
            $success[0] = ___('alert.successfully_deleted');
            $success[1] = 'success';
            $success[2] = ___('delete.deleted');
            return response()->json($success);
        else :
            $success[0] = ___('alert.something_went_wrong');
            $success[1] = 'error';
            $success[2] = ___('delete.oops');
            return response()->json($success);
        endif;
    }

    public function CodCharge($merchant_id)
    {
        $merchant     = $this->repoMerchant->get($merchant_id);
        return view('backend.merchant.delivery-charge.cod', compact('merchant', 'merchant_id'));
    }

    public function updateCodCharge(MerchantCODChargeUpdateRequest $request, $merchant_id)
    {
        $result = $this->repo->updateCodCharge($request, $merchant_id);
        if ($result['status']) {
            return redirect()->route('merchant.codCharge.index', $merchant_id)->with('success', $result['message']);
        }
        return back()->with('danger', $result['message']);
    }

    // ====================================================================================================================
    // Merchant charge Ajax response 
    // ====================================================================================================================

    public function serviceType(Request $request, $mid)
    {
        if (!request()->ajax()) {
            return response()->json(['error' => ___('alert.invalid_request')], 400);
        }

        $existingChargeIds = MerchantCharge::where('merchant_id', $mid)->pluck('charge_id');

        $serviceTypes = Charge::with('serviceType:id,name')
            ->whereNotIn('id', $existingChargeIds)
            ->where('status', Status::ACTIVE)
            ->where('product_category_id', $request->product_category_id)
            ->get(['id', 'service_type_id'])
            ->unique('service_type_id');

        return view('backend.merchant.delivery-charge.service_type', compact('serviceTypes'));
    }

    public function area(Request $request, $mid)
    {
        if (!request()->ajax()) {
            return response()->json(['error' => ___('alert.invalid_request')], 400);
        }

        $existingChargeIds = MerchantCharge::where('merchant_id', $mid)->pluck('charge_id');

        $areas = Charge::whereNotIn('id', $existingChargeIds)
            ->where('status', Status::ACTIVE)
            ->where('product_category_id', $request->input('product_category_id'))
            ->where('service_type_id', $request->input('service_type_id'))
            ->select('area')
            ->distinct()
            ->get();

        return view('backend.merchant.delivery-charge.area', compact('areas'));
    }

    public function charge(Request $request, $merchant_id)
    {
        if (!request()->ajax()) {
            return response()->json(['error' => ___('alert.invalid_request')], 400);
        }

        // Check if a merchant charge already exists with the given criteria 
        $merchantChargeExists = MerchantCharge::where([
            'merchant_id'         => $request->input('merchant_id'),
            'product_category_id' => $request->input('product_category_id'),
            'service_type_id'     => $request->input('service_type_id'),
            'area'                => $request->input('area'),
        ])->exists();

        // If a matching merchant charge exists, return an error response 
        if ($merchantChargeExists) {
            return response()->json(['error' => 'Duplicate merchant charge detected.'], 302);
        }

        $charge = Charge::where([
            'product_category_id' => $request->input('product_category_id'),
            'service_type_id'     => $request->input('service_type_id'),
            'area'                => $request->input('area'),
            'status'              => Status::ACTIVE,
        ])->first(['id', 'delivery_time', 'charge', 'additional_charge']);

        if ($charge == null) {
            return response()->json(['error' => 'This Charge combination not found.'], 404);
        }

        return response()->json($charge);
    }
}
