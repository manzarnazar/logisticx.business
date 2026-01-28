<?php

namespace App\Http\Controllers\Api;

use Throwable;
use Svg\Tag\Rect;
use App\Http\Requests\Support\SupportStoreRequest;


use App\Enums\Status;
use App\Enums\UserType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Traits\ApiReturnFormatTrait;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Validator;
use App\Http\Resources\Merchant\DepartmentResource;
use App\Http\Resources\Merchant\MerchantSupportResource;
use App\Repositories\MerchantPanel\Support\SupportInterface;


class MerchantSupportController extends Controller
{
    use ApiReturnFormatTrait;

    protected $supportRepo;

    public function __construct(
        SupportInterface $supportRepo
    ) {
        $this->supportRepo            = $supportRepo;
    }


    public function allSupports(Request $request)
    {
     
        $supports = $this->supportRepo->all();
        $data     = MerchantSupportResource::collection($supports);

        return $this->responseWithSuccess(
            ___('alert.successful'),
            data: [
                'supports' => $data,
                'meta' => [
                    'current_page' => $supports->currentPage(),
                    'last_page'    => $supports->lastPage(),
                    'per_page'     => $supports->perPage(),
                    'total'        => $supports->total(),
                ],
            ]
        );
        
    }

    public function getDepartments()
    {
        $supports = $this->supportRepo->departments();

        $data = DepartmentResource::collection($supports);
        return $this->responseWithSuccess(___('alert.successful'), data: $data);
    }
    public function createSupport(SupportStoreRequest $request)
    {


        $result = $this->supportRepo->store($request);


        if ($result['status']) {
            return $this->responseWithSuccess($result['message']);
        }
        return $this->responseWithError($result['message']);
    }

    public function editSupport($id)
    {
        $supports = $this->supportRepo->get($id);

        $data = new MerchantSupportResource($supports);
        return $this->responseWithSuccess(___('alert.successful'), data: $data);
    }
    public function viewSupport($id)
    {
        $singleSupport = $this->supportRepo->get($id);

        if (auth()->user()->user_type != UserType::ADMIN && auth()->user()->id != $singleSupport->user_id) {
            return $this->responseWithError(___('alert.something_went_wrong'));
        }

        $data = new MerchantSupportResource($singleSupport);
        return $this->responseWithSuccess(___('alert.successful'), data: $data);
    }

    public function updateSupport(SupportStoreRequest $request)
    {
        
        $result = $this->supportRepo->update($request->id, $request);

        if ($result['status']) {
            return $this->responseWithSuccess($result['message']);
        }
        return $this->responseWithError($result['message']);
    }
    public function deleteSupport($id)
    {
        $result = $this->supportRepo->delete($id);
        if ($result['status']) {
            return $this->responseWithSuccess($result['message']);
        }
        return $this->responseWithError($result['message']);
    }

    public function supportConfigs()
    {
        $supports = [
            'services' => collect(config('site.support.services'))->map(function ($value, $key) {
                return [
                    'key'   => $key,
                    'label' => ___("common.$value"),
                ];
            })->values(),

            'priority' => collect(config('site.support.priority'))->map(function ($value, $key) {
                return [
                    'key'   => $key,
                    'label' => ___("common.$value"),
                ];
            })->values(),
        ];

        return $this->responseWithSuccess(___('alert.successful'), data: $supports);
    }


    
    
}
