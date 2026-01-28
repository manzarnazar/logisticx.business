<?php

namespace App\Http\Controllers\Api;

use Throwable;
use Svg\Tag\Rect;


use App\Enums\Status;
use Illuminate\Http\Request;
use App\Models\Backend\Merchant;
use App\Http\Controllers\Controller;
use App\Traits\ApiReturnFormatTrait;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Validator;

use App\Repositories\Bank\BankInterface;
use Illuminate\Contracts\Mail\Attachable;
use App\Http\Resources\Merchant\BankResource;
use App\Http\Requests\Merchant\PaymentInfoStore;
use App\Repositories\MerchantShops\ShopsInterface;
use App\Http\Resources\Merchant\MerchantShopResource;
use App\Repositories\MerchantPayment\PaymentInterface;
use App\Http\Requests\MerchantPanel\Shops\StoreRequest;
use App\Http\Requests\MerchantPanel\Shops\UpdateRequest;
use App\Http\Resources\Merchant\MerchantPaymentResource;

class MerchantShopController extends Controller
{
    use ApiReturnFormatTrait;

    protected $shopRepo;

    public function __construct(
        ShopsInterface $shopRepo,
    ) {
        $this->shopRepo            = $shopRepo;
    }

    private function mid()  // mid = Merhchant User-Id 
    {
        return Auth::user()->merchant->id;
    }

    public function shopList(Request $request)
    {
        $merchantId = $this->mid();

        if ($request->has('page')) {
            // 👉 Paginated response
            $shops = $this->shopRepo->merchantShopsGet(
                $merchantId,
                status: Status::ACTIVE,
                paginate: settings('paginate_value')
            );

            return $this->responseWithSuccess(
                ___('alert.successful'),
                data: [
                    'shops' => MerchantShopResource::collection($shops),
                    'meta'  => [
                        'current_page' => $shops->currentPage(),
                        'last_page'    => $shops->lastPage(),
                        'per_page'     => $shops->perPage(),
                        'total'        => $shops->total(),
                    ],
                ]
            );
        }

        // 👉 Without ?page → return all shops
        $shops = $this->shopRepo->merchantShopsGet(
            $merchantId,
            status: Status::ACTIVE
        );

        return $this->responseWithSuccess(
            ___('alert.successful'),
            data: [
                'shops' => MerchantShopResource::collection($shops),
            ]
        );
    }

    public function shopCreate(StoreRequest $request)
    {

        $request->merge(['merchant_id' => $this->mid()]);

        $result = $this->shopRepo->store($request);

        if ($result['status']) {
            return $this->responseWithSuccess($result['message']);
        }
        return $this->responseWithError($result['message']);
    }
    public function getShopForEdit($id)
    { // shop id
        $shop = $this->shopRepo->get($id);
        $data = new MerchantShopResource($shop);
        return $this->responseWithSuccess(___('alert.successful'), data: $data);
    }
    public function updateShop(StoreRequest $request)
    { 

        $request->merge(['merchant_id' => $this->mid()]);

        $result = $this->shopRepo->update($request);

        if ($result['status']) {
            return $this->responseWithSuccess($result['message']);
        }
        return $this->responseWithError($result['message']);
    }
    public function deleteShop($id)
    {
        $result = $this->shopRepo->delete($id);
        if ($result['status']) {
            return $this->responseWithSuccess($result['message']);
        }
        return $this->responseWithError($result['message']);
    }
    public function defaultShop($shop_id)
    {
        $merchant_id = Merchant::where('user_id', auth()->user()->id)->first()->id;
        $result = $this->shopRepo->defaultShop($merchant_id, $shop_id);
        if ($result['status']) {
            return $this->responseWithSuccess($result['message']);
        }
        return $this->responseWithError($result['message']);
    }

    
}
