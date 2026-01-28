<?php

namespace App\Repositories\MerchantShops;

use App\Enums\Status;
use App\Models\Backend\Hub;
use App\Models\MerchantShops;
use App\Repositories\MerchantShops\ShopsInterface;
use App\Traits\ReturnFormatTrait;
use Illuminate\Support\Facades\Auth;

class ShopsRepository implements ShopsInterface
{
    use ReturnFormatTrait;

    protected $model;

    public function __construct(MerchantShops $model)
    {
        $this->model = $model;
    }

    public function all()
    {
        return $this->model::orderBy('id', 'desc')->paginate(settings('paginate_value'));
    }

    public function get($id)
    {
        return $this->model::with('coverage:id,name')->findOrFail($id);
    }
    public function getMerchantShopDetails($merchantId, $shopId)
    {
        return $this->model::with('coverage:id,name')->where('merchant_id', $merchantId)->where('id', $shopId)->get();
    }

    public function merchantShopsGet(int $merchant_id, bool $status = null, int $paginate = null)
    {
        $query = $this->model::query();

        $query->where('merchant_id', $merchant_id);

        if ($status !== null) {
            $query->where('status', $status);
        }

        $query->orderBy('default_shop', 'desc');
        $query->orderBy('updated_at', 'desc');

        if ($paginate !== null) {
            return  $query->paginate($paginate);
        }

        return $query->get();
    }

    public function defaultShop($merchant_id, $id)
    {
        try {
            $merchantShops              = $this->model::where(['default_shop' => Status::ACTIVE, 'merchant_id' => $merchant_id])->get();
            foreach ($merchantShops as $merchant) {
                $merchant->default_shop = Status::INACTIVE;
                $merchant->save();
            }
            $merchantShop               = $this->model::where(['id' => $id, 'merchant_id' => $merchant_id])->first();
            $merchantShop->default_shop = Status::ACTIVE;
            $merchantShop->save();

            return $this->responseWithSuccess(___('alert.successfully_updated'), []);
        } catch (\Throwable $th) {
            return $this->responseWithError(___('alert.something_went_wrong'), []);
        }
    }

    public function store($request)
    {

        try {
            $shop              = new $this->model;
            $shop->merchant_id = $request->merchant_id;
            $shop->name        = $request->name;
            $shop->contact_no  = $request->contact_no;
            $shop->address     = $request->address;
            $shop->hub_id      = $request->hub;
            $shop->coverage_id = Hub::find($shop->hub_id)->coverage_id;
            $shop->status      = $request->status;
            $shop->save();

            return $this->responseWithSuccess(___('alert.successfully_added'), []);
        } catch (\Throwable $th) {
            return $this->responseWithError(___('alert.something_went_wrong'), []);
        }
    }

    public function update($request)
    {
        try {
            $shop              = $this->model::where('id', $request->id)->first();
            $shop->merchant_id = $request->merchant_id;
            $shop->name        = $request->name;
            $shop->contact_no  = $request->contact_no;
            $shop->address     = $request->address;
            $shop->hub_id      = $request->hub;
            $shop->coverage_id = Hub::find($shop->hub_id)->coverage_id;
            $shop->status      = $request->status;
            $shop->save();

            return $this->responseWithSuccess(___('alert.successfully_updated'), []);
        } catch (\Throwable $th) {
            return $this->responseWithError(___('alert.something_went_wrong'), []);
        }
    }

    public function delete($id)
    {
        try {
            $this->model::destroy($id);

            return $this->responseWithSuccess(___('alert.successfully_deleted'), []);
        } catch (\Throwable $th) {
            return $this->responseWithError(___('alert.something_went_wrong'), []);
        }
    }
}
