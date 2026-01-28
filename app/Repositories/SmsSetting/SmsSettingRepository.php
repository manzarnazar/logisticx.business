<?php

namespace App\Repositories\SmsSetting;

use App\Repositories\SmsSetting\SmsSettingInterface;
use App\Models\Backend\SmsSetting;
use App\Traits\ReturnFormatTrait;


class SmsSettingRepository implements SmsSettingInterface
{

    use ReturnFormatTrait;
    private $model;

    public function __construct(SmsSetting $model)
    {
        $this->model = $model;
    }
    public function all()
    {
        return $this->model::orderByDesc('updated_at')->paginate(settings('paginate_value'));
    }
    public function get($id)
    {
        return $this->model::find($id);
    }

    public function store($request)
    {

        try {
            $smsSetting                       = new $this->model;
            $smsSetting->gateway              = $request->gateway;
            $smsSetting->api_key              = $request->api_key;
            $smsSetting->secret_key           = $request->secret_key;
            $smsSetting->username             = $request->username;
            $smsSetting->user_password        = $request->user_password;
            $smsSetting->api_url              = $request->api_url;
            $smsSetting->status               = $request->status;
            $smsSetting->save();

            return $this->responseWithSuccess(___('alert.successfully_added'), []);
        } catch (\Throwable $th) {
            return $this->responseWithError(___('alert.something_went_wrong'), []);
        }
    }

    public function update($id, $request)
    {
        try {

            $smsSetting                       = $this->model::find($id);
            $smsSetting->gateway              = $request->gateway;
            $smsSetting->api_key              = $request->api_key;
            $smsSetting->secret_key           = $request->secret_key;
            $smsSetting->username             = $request->username;
            $smsSetting->user_password        = $request->user_password;
            $smsSetting->api_url              = $request->api_url;
            $smsSetting->status               = $request->status;
            $smsSetting->save();

            return $this->responseWithSuccess(___('alert.successfully_updated'), []);
        } catch (\Throwable $th) {
            return $this->responseWithError(___('alert.something_went_wrong'), []);
        }
    }

    public function delete($id)
    {

        $this->model::destroy($id);
        return $this->responseWithSuccess(___('alert.successfully_deleted'), []);
    }
}
