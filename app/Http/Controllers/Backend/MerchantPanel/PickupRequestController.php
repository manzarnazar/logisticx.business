<?php

namespace App\Http\Controllers\Backend\MerchantPanel;

use App\Http\Controllers\Controller;
use App\Http\Requests\MerchantPanel\Parcel\PickupStoreRequest;
use App\Repositories\MerchantPanel\PickupRequest\PickupRequestInterface;

class PickupRequestController extends Controller
{
    protected $repo;

    public function __construct(PickupRequestInterface $repo)
    {
        $this->repo = $repo;
    }

    public function regularStore(PickupStoreRequest $request)
    {
        $result = $this->repo->regularStore($request);

        if ($request->wantsJson()) {
            return response()->json($result, $result['data']['status_code']);
        }

        if ($result['status']) {
            return redirect()->back()->with('success', $result['message']);
        }

        return redirect()->back()->withInput()->with('danger', $result['message']);
    }

    public function expressStore(PickupStoreRequest $request)
    {
        $result = $this->repo->expressStore($request);

        if ($request->wantsJson()) {
            return response()->json($result, $result['data']['status_code']);
        }

        if ($result['status']) {
            return redirect()->back()->with('success', $result['message']);
        }

        return redirect()->back()->withInput()->with('danger', $result['message']);
    }
}
