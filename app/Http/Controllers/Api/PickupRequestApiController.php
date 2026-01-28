<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Traits\ApiReturnFormatTrait;
use App\Http\Resources\Merchant\PickupRequestResource;
use App\Http\Requests\PickupRequest\PickupStoreRequest;
use App\Repositories\MerchantPanel\PickupRequest\PickupRequestInterface;

class PickupRequestApiController extends Controller
{
    use ApiReturnFormatTrait;
    
    protected $repo;

    public function __construct(PickupRequestInterface $repo)
    {
        $this->repo = $repo;
    }

    /**
     * List all pickup requests (regular & express)
     */
    public function index(Request $request)
    {
        $list = $this->repo->getList($request);
        $data = PickupRequestResource::collection($list);

        return $this->responseWithSuccess(
            ___('alert.successful'),
            data: [
                'pickup_requests' => $data,
                'meta' => [
                    'current_page' => $list->currentPage(),
                    'last_page'    => $list->lastPage(),
                    'per_page'     => $list->perPage(),
                    'total'        => $list->total(),
                ],
            ]
        );
    }

    /**
     * Store a pickup request (regular or express)
     */
    public function store(PickupStoreRequest $request)
    {
        $result = $this->repo->store($request);

        if ($result['status']) {
            return $this->responseWithSuccess($result['message']);
        }

        return $this->responseWithError($result['message']);
    }

    public function delete($id)
    {
        $result = $this->repo->delete($id);
        if ($result['status']) {
            return $this->responseWithSuccess($result['message']);
        }
        return $this->responseWithError($result['message']);
    }



}
