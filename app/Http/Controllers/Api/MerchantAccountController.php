<?php

namespace App\Http\Controllers\Api;

use Throwable;
use Svg\Tag\Rect;


use App\Enums\Status;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Traits\ApiReturnFormatTrait;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Hash;
use App\Repositories\Bank\BankInterface;
use Illuminate\Contracts\Mail\Attachable;
use App\Http\Resources\Merchant\BankResource;
use App\Http\Requests\Merchant\PaymentInfoStore;
use App\Repositories\MerchantPayment\PaymentInterface;
use App\Http\Resources\Merchant\MerchantPaymentResource;

class MerchantAccountController extends Controller
{
    use ApiReturnFormatTrait;

    protected $paymentRepo, $bankRepo;

    public function __construct(
        PaymentInterface $paymentRepo,
        BankInterface $bankRepo
    ) {
        $this->bankRepo            = $bankRepo;
        $this->paymentRepo         = $paymentRepo;
    }


     public function bankList()
    {
        $banks    = $this->bankRepo->all(Status::ACTIVE, orderBy: 'bank_name');
        $data = BankResource::collection($banks);

        return $this->responseWithSuccess(___('alert.successful'), data: $data);
    }


    public function PaymentAccounts(Request $request)
    {
        $merchantId = Auth::user()->merchant->id;

        if ($request->has('page')) {
            // 👉 Paginated response
            $accounts = $this->paymentRepo->all(
                merchant_id: $merchantId,
                paginate: settings('paginate_value')
            );

            return $this->responseWithSuccess(
                ___('alert.Payment accounts'),
                data: [
                    'accounts' => MerchantPaymentResource::collection($accounts),
                    'meta' => [
                        'current_page' => $accounts->currentPage(),
                        'last_page'    => $accounts->lastPage(),
                        'per_page'     => $accounts->perPage(),
                        'total'        => $accounts->total(),
                    ],
                ]
            );
        }

        // 👉 Without page param → return all accounts
        $accounts = $this->paymentRepo->all(
            merchant_id: $merchantId
        );

        return $this->responseWithSuccess(
            ___('alert.Payment accounts'),
            data: [
                'accounts' => MerchantPaymentResource::collection($accounts),
            ]
        );
    }

    public function createPaymentAccount(PaymentInfoStore $request)
    {
        $result = $this->paymentRepo->store($request);

        if ($result['status']) {
            return $this->responseWithSuccess($result['message']);
        }
        return $this->responseWithError($result['message']);
    }
    public function updatePaymentAccount(PaymentInfoStore $request)
    {
        $result = $this->paymentRepo->update($request);

        if ($result['status']) {
            return $this->responseWithSuccess($result['message']);
        }
        return $this->responseWithError($result['message']);
    }
    public function getPaymentAccountForEdit($id)
    {
        $account = $this->paymentRepo->get($id);

        $data = new MerchantPaymentResource($account);

        return $this->responseWithSuccess(___('alert.successful'), data: $data);
    }
    public function deletePaymentAccount($id)
    {
        $result = $this->paymentRepo->delete($id);
        if ($result['status']) {
            return $this->responseWithSuccess($result['message']);
        }
        return $this->responseWithError($result['message']);
    }
    public function paymentAccountConfigs()
    {
        try {
            return $this->responseWithSuccess(message: ___('alert.Payment Account Configs'), data: config('merchantpayment'));
        } catch (\Throwable $th) {
            return $this->responseWithError(message: ___('alert.something_went_wrong'), code: 500);
        }
    }

    
}
