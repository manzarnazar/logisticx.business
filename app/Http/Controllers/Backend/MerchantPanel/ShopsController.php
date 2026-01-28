<?php

namespace App\Http\Controllers\Backend\MerchantPanel;

use App\Enums\Status;
use App\Http\Controllers\Controller;
use App\Http\Requests\MerchantPanel\Shops\StoreRequest;
use App\Http\Requests\MerchantPanel\Shops\UpdateRequest;
use App\Repositories\Coverage\CoverageInterface;
use App\Repositories\Hub\HubInterface;
use App\Repositories\MerchantPanel\Shops\ShopsInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class ShopsController extends Controller
{
    protected $repo, $hubRepo;

    public function __construct(ShopsInterface $repo, HubInterface $hubRepo)
    {
        $this->repo = $repo;
        $this->hubRepo = $hubRepo;
    }

    public function index()
    {
        $singleMerchant = $this->repo->getMerchant(Auth::user()->id);
        $merchant_shops = $this->repo->all($singleMerchant->id, sortBy: 'asc');
        return view('backend.merchant_panel.shop.index', compact('merchant_shops', 'singleMerchant'));
    }

    //merchant shops create page
    public function create()
    {
        $hubs = $this->hubRepo->all(status: Status::ACTIVE, orderBy: 'name', sortBy: 'asc');
        return view('backend.merchant_panel.shop.create', compact('hubs'));
    }

    //merchant shops store
    public function store(StoreRequest $request)
    {
        $result = $this->repo->store(Auth::user()->merchant->id, $request);

        if ($result['status']) {
            return redirect()->route('merchant-panel.shops.index')->with('success', $result['message']);
        }
        return back()->with('danger', $result['message'])->withInput();
    }

    public function edit($id)
    { // shop id
        $shop = $this->repo->get($id);
        $hubs = $this->hubRepo->all(status: Status::ACTIVE, orderBy: 'name', sortBy: 'asc');
        return view('backend.merchant_panel.shop.edit', compact('shop', 'hubs'));
    }

    public function update($id, UpdateRequest $request)
    {
        $result = $this->repo->update($id, $request);

        if ($result['status']) {
            return redirect()->route('merchant-panel.shops.index')->with('success', $result['message']);
        }
        return back()->with('danger', $result['message'])->withInput();
    }

    public function defaultShop($id)
    {
        $result = $this->repo->defaultShop($id);
        if ($result['status']) {
            return back()->with('success', $result['message']);
        }
        return back()->with('danger', $result['message']);
    }



    public function delete($id)
    {
        $result = $this->repo->delete($id);

        if ($result['status']) :
            $success[0] = $result['message'];
            $success[1] = 'success';
            $success[2] = ___('delete.deleted');
            return response()->json($success);
        else :
            $success[0] = $result['message'];
            $success[1] = 'error';
            $success[2] = ___('delete.oops');
            return response()->json($success);
        endif;
    }

    // json response
    public function shopDetails(Request $request)
    {
        if (!request()->ajax()) {
            return response()->json(['error' => ___('alert.invalid_request')], 422);
        }

        $shop = $this->repo->get($request->input('id'));

        if ($shop == null) {
            return response()->json(['error' => 'No Shop found'], 404);
        }

        return response()->json($shop);
    }
}
