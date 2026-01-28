<?php

namespace App\Repositories\MerchantPanel\Shops;

use App\Enums\Status;
use App\Enums\UserType;
use App\Models\MerchantShops;
use App\Repositories\MerchantPanel\Shops\ShopsInterface;
use App\Models\Backend\Merchant;
use App\Traits\ReturnFormatTrait;

class ShopsRepository implements ShopsInterface
{
    use ReturnFormatTrait;

    protected $model;

    public function __construct(MerchantShops $model)
    {
        $this->model = $model;
    }

    public function all($merchant_id, string $orderBy = 'id', string $sortBy = 'desc')
    {
        return $this->model::where('merchant_id', $merchant_id)->orderBy($orderBy, $sortBy)->paginate(settings('paginate_value'));
    }

    public function get($id)
    {
        return $this->model::where('id', $id)->first();
    }

    public function getMerchant($id)
    {
        return Merchant::where('user_id', $id)->first();
    }

    public function store($id, $request)
    {
        try {
            $shop              = new $this->model;
            $shop->merchant_id = $id;
            $shop->name        = $request->name;
            $shop->contact_no  = $request->contact_no;
            $shop->address     = $request->address;
            $shop->hub_id      = $request->hub;
            // $shop->coverage_id  = $request->coverage;
            $shop->status      = $request->status;
            $shop->save();

            return $this->responseWithSuccess(___('alert.successfully_added'), []);
        } catch (\Throwable $th) {
            return $this->responseWithError(___('alert.something_went_wrong'), []);
        }
    }

    public function update($id, $request)
    {

        try {
            $shop               = $this->model::where('id', $id)->first();
            $shop->name         = $request->name;
            $shop->contact_no   = $request->contact_no;
            $shop->address      = $request->address;
            $shop->hub_id      = $request->hub;
            // $shop->coverage_id  = $request->coverage;
            $shop->status       = $request->status;
            $shop->save();

            return $this->responseWithSuccess(___('alert.successfully_updated'), []);
        } catch (\Throwable $th) {
            return $this->responseWithError(___('alert.something_went_wrong'), []);
        }
    }

    public function delete($id)
    {
        try {

            $shop = $this->model::find($id);

            if (auth()->user()->user_type == UserType::MERCHANT && $shop->merchant_id != auth()->user()->merchant->id) {
                return $this->responseWithError(___('alert.unauthorized'), []);
            }

            $shop->delete($id);

            return $this->responseWithSuccess(___('alert.successfully_deleted'), []);
        } catch (\Throwable $th) {
            return $this->responseWithError(___('alert.something_went_wrong'), []);
        }
    }

    public function defaultShop($id)
    {
        $merchant_id = Merchant::where('user_id', auth()->user()->id)->first()->id;

        try {
            $merchantShops              = $this->model::where(['default_shop' => Status::ACTIVE, 'merchant_id' => $merchant_id])->get();
            foreach ($merchantShops as $merchant) {
                $merchant->default_shop = Status::INACTIVE;
                $merchant->save();
            }
            $merchantShop               = $this->model::where(['id' => $id, 'merchant_id' => $merchant_id])->first();
            $merchantShop->default_shop = Status::ACTIVE;
            $merchantShop->save();

            return $this->responseWithSuccess(__('alert.successfully_updated'), []);
        } catch (\Throwable $th) {
            return $this->responseWithError(___('alert.something_went_wrong'), []);
        }
    }
}
