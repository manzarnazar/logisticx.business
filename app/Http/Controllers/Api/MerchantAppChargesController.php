<?php

namespace App\Http\Controllers\Api;

use App\Enums\Status;
use App\Enums\UserType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Traits\ApiReturnFormatTrait;
use App\Repositories\Charge\ChargeInterface;
use App\Http\Resources\MerchantChargeResource;
use App\Http\Resources\Merchant\MerchantCodAndOtherChargeResource;
use App\Repositories\Merchant\DeliveryCharge\MerchantChargeRepository;

class MerchantAppChargesController extends Controller
{
    use ApiReturnFormatTrait;

    private $chargeRepo, $productRepo, $serviceRepo, $merchantChargeRepo;

    public function __construct(ChargeInterface $chargeRepo, MerchantChargeRepository $merchantChargeRepo)
    {
        $this->chargeRepo         = $chargeRepo;
        $this->merchantChargeRepo = $merchantChargeRepo;
    }

    public function generalCharges(Request $request)
    {
        $status =  !hasPermission('charge_create') ? Status::ACTIVE : null;

        $charges = $this->chargeRepo->all(status: $status, paginate: settings('paginate_value'));

        $data = MerchantChargeResource::collection($charges);

        return $this->responseWithSuccess(
            ___('alert.successful'),
            data: [
                'charges' => $data,
                'meta' => [
                    'current_page' => $charges->currentPage(),
                    'last_page'    => $charges->lastPage(),
                    'per_page'     => $charges->perPage(),
                    'total'        => $charges->total(),
                ],
            ]
        );
    }

    public function myCharges(Request $request)
    {
        $merchantID = auth()->user()->merchant->id;

        $charges = $this->merchantChargeRepo->all(merchant_id: $merchantID, paginate: settings('paginate_value'));

        $data = MerchantChargeResource::collection($charges);

        return $this->responseWithSuccess(
            ___('alert.successful'),
            data: [
                'charges' => $data,
                'meta' => [
                    'current_page' => $charges->currentPage(),
                    'last_page'    => $charges->lastPage(),
                    'per_page'     => $charges->perPage(),
                    'total'        => $charges->total(),
                ],
            ]
        );
    }




    public function merchantCodAndOtherCharges()
    {

        $charges = [
            'inside_city'    => settings('cod_inside_city'),
            'sub_city'       => settings('cod_sub_city'),
            'outside_city'   => settings('cod_outside_city'),
            'liquid_fragile' => settings('liquid_fragile'),
            'merchant_vat'   => settings('merchant_vat')
        ];
        // Optionally, uncomment this part to check for no charges
        if (!$charges) {
            return $this->responseWithError(__('alert.no_record_found'));
        }

        // Assuming you are returning the charges wrapped in a Resource
        $data = new MerchantCodAndOtherChargeResource($charges);

        // Respond with success
        return $this->responseWithSuccess(data: $data);
    }
}
