<?php

namespace App\Http\Controllers\Backend;

use App\Enums\Status;
use App\Http\Controllers\Controller;
use App\Http\Requests\MerchantShop\StoreRequest;
use App\Http\Requests\MerchantShop\UpdateRequest;
use App\Repositories\Hub\HubInterface;
use App\Repositories\MerchantShops\ShopsInterface;
use App\Repositories\Merchant\MerchantInterface;

class MerchantShopsController extends Controller
{
    protected $repo, $repoMerchant, $hubRepo;

    public function __construct(ShopsInterface $repo, MerchantInterface $repoMerchant, HubInterface $hubRepo,)
    {
        $this->repo         = $repo;
        $this->repoMerchant = $repoMerchant;
        $this->hubRepo      = $hubRepo;
        // $this->coverageRepo = $coverageRepo;
    }

    public function index($merchant_id)
    {
        $shops = $this->repo->merchantShopsGet(merchant_id: $merchant_id,  paginate: settings('paginate_value'));

        return view('backend.merchant.shop.index', compact('shops', 'merchant_id'));
    }

    //merchant shops create page
    public function create($id)
    {
        $merchant_id    = $id;
        // $coverages = $this->coverageRepo->getWithActiveChild();
        $hubs = $this->hubRepo->all(status: Status::ACTIVE, orderBy: 'name', sortBy: 'asc');

        return view('backend.merchant.shop.create', compact('merchant_id', 'hubs'));
    }

    //merchant shops store
    public function store(StoreRequest $request)
    {
        $result = $this->repo->store($request);
        if ($result['status']) {
            return redirect()->route('merchant.shops.index', $request->merchant_id)->with('success', $result['message']);
        }
        return back()->with('danger', $result['message'])->withInput();
    }

    public function edit($id)
    {
        $shop           = $this->repo->get($id);
        $merchant_id    = $shop->merchant_id;
        // $coverages      = $this->coverageRepo->getWithActiveChild();
        $hubs = $this->hubRepo->all(status: Status::ACTIVE, orderBy: 'name', sortBy: 'asc');

        return view('backend.merchant.shop.edit', compact('shop', 'merchant_id', 'hubs'));
    }

    public function update(UpdateRequest $request)
    {
        $result = $this->repo->update($request);
        if ($result['status']) {
            return redirect()->route('merchant.shops.index', $request->merchant_id)->with('success', $result['message']);
        }
        return back()->with('danger', $result['message'])->withInput();
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

    public function defaultShop($merchant_id, $id)
    {
        $result = $this->repo->defaultShop($merchant_id, $id);
        if ($result['status']) {
            return back()->with('success', $result['message']);
        }
        return back()->with('danger', $result['message']);
    }
}
