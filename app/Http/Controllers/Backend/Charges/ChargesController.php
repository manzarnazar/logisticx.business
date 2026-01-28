<?php

namespace App\Http\Controllers\Backend\Charges;

use App\Enums\Status;
use App\Enums\UserType;
use App\Http\Controllers\Controller;
use App\Http\Requests\Charges\ChargeStoreRequest;
use App\Repositories\Charge\ChargeInterface;
use App\Repositories\Merchant\DeliveryCharge\MerchantChargeInterface;
use App\Repositories\ProductCategory\ProductCategoryInterface;
use App\Repositories\ServiceType\ServiceTypeInterface;

class ChargesController extends Controller
{
    private $repo, $productRepo, $serviceRepo, $merchantChargeRepo;

    public function __construct(ChargeInterface $repo, ProductCategoryInterface $productRepo, ServiceTypeInterface $serviceRepo, MerchantChargeInterface $merchantChargeRepo)
    {
        $this->repo                 = $repo;
        $this->merchantChargeRepo   = $merchantChargeRepo;
        $this->productRepo          = $productRepo;
        $this->serviceRepo          = $serviceRepo;
    }

    public function index()
    {
        $status =  !hasPermission('charge_create') ? Status::ACTIVE : null;
        $charges = $this->repo->all(status: $status, paginate: settings('paginate_value'));

        if (auth()->user()->user_type == UserType::MERCHANT) {
            return view('backend.merchant_panel.charge.regular_charge', compact('charges'));
        }

        return view('backend.charge.index', compact('charges'));
    }

    public function merchantCharge($merchant_id = null)
    {
        $merchant_id = auth()->user()->user_type == UserType::MERCHANT ? auth()->user()->merchant->id : $merchant_id;
        $charges = $this->merchantChargeRepo->all(merchant_id: $merchant_id, status: Status::ACTIVE, paginate: settings('paginate_value'));
        return view('backend.merchant_panel.charge.my_charge', compact('charges'));
    }

    public function create()
    {
        $product_categories = $this->productRepo->all(Status::ACTIVE);
        $service_types      = $this->serviceRepo->all(Status::ACTIVE);
        return view('backend.charge.create', compact('product_categories', 'service_types'));
    }

    public function store(ChargeStoreRequest $request)
    {
        $result = $this->repo->store($request);
        if ($result['status']) {
            return redirect()->route('charge.index')->with('success', $result['message']);
        }
        return back()->with('danger', $result['message']);
    }

    public function edit($id)
    {
        $charge = $this->repo->get($id);
        $product_categories = $this->productRepo->all(Status::ACTIVE);
        $service_types      = $this->serviceRepo->all(Status::ACTIVE);
        return view('backend.charge.edit', compact('charge', 'product_categories', 'service_types'));
    }

    public function update(ChargeStoreRequest $request)
    {
        $result = $this->repo->update($request);
        if ($result['status']) {
            return redirect()->route('charge.index')->with('success', $result['message']);
        }
        return back()->with('danger', $result['message']);
    }

    public function delete($id)
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
}
