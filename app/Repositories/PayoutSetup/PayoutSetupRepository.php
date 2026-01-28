<?php

namespace App\Repositories\PayoutSetup;

use App\Enums\PayoutSetup;
use App\Enums\Status;
use App\Models\Backend\Setting;
use App\Traits\ReturnFormatTrait;
use App\Repositories\PayoutSetup\PayoutSetupInterface;

class PayoutSetupRepository implements PayoutSetupInterface
{

    use ReturnFormatTrait;
    private $model;

    public function __construct(Setting $model)
    {
        $this->model = $model;
    }

    public function update($payment_method, $request)
    {
        try {


            switch ($payment_method) {
                case PayoutSetup::STRIPE:
                    $request['stripe_status'] = $request->stripe_status ? Status::ACTIVE : Status::INACTIVE;
                    break;
                case PayoutSetup::SSL_COMMERZ:
                    $request['sslcommerz_testmode'] = $request->sslcommerz_testmode ? Status::ACTIVE : Status::INACTIVE;
                    $request['sslcommerz_status']   = $request->sslcommerz_status ? Status::ACTIVE : Status::INACTIVE;
                    break;
                case PayoutSetup::PAYPAL:
                    $request['paypal_status']       = $request->paypal_status ? Status::ACTIVE : Status::INACTIVE;
                    break;
                case PayoutSetup::BKASH:
                    $request['bkash_test_mode']   = $request->bkash_test_mode ? Status::ACTIVE : Status::INACTIVE;
                    $request['bkash_status']      = $request->bkash_status ? Status::ACTIVE : Status::INACTIVE;
                    break;
                default:

                    break;
            }

            $requestData = $request->except(['_method', '_token']);
            foreach ($requestData as $key => $value) {
                $setting          = $this->model::where('key', $key)->first();
                $setting->value   = $value;
                $setting->save();
            }
            return $this->responseWithSuccess(___('alert.successfully_updated'), []);
        } catch (\Throwable $th) {

            return $this->responseWithError(___('alert.something_went_wrong'), []);
        }
    }
}
