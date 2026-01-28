<?php

namespace App\Repositories\Fraud;

use App\Models\Backend\Fraud;
use App\Repositories\Fraud\FraudInterface;
use App\Traits\ReturnFormatTrait;
use Illuminate\Support\Facades\Auth;

class FraudRepository implements FraudInterface
{
    use ReturnFormatTrait;

    protected $model;

    public function __construct(Fraud $model)
    {
        $this->model = $model;
    }

    public function all(string $orderBy = 'id', string $sortBy = 'desc')
    {
        return $this->model::orderBy($orderBy, $sortBy)->paginate(settings('paginate_value'));
    }

    public function get($id)
    {
        return $this->model::findOrFail($id);
    }

    public function store($request)
    {
        try {
            $fraud                = new $this->model;
            $fraud->created_by    = Auth::user()->id;
            $fraud->phone         = $request->phone;
            $fraud->name          = $request->name;
            $fraud->details       = $request->details;
            $fraud->tracking_id   = $request->tracking_id;
            $fraud->save();
            return $this->responseWithSuccess(___('alert.successfully_added'), []);
        } catch (\Throwable $th) {
            return $this->responseWithError(___('alert.something_went_wrong'), []);
        }
    }

    public function update($id, $request)
    {
        try {
            $fraud                = $this->model::findOrFail($id);
            $fraud->created_by    = Auth::user()->id;
            $fraud->phone         = $request->phone;
            $fraud->name          = $request->name;
            $fraud->details       = $request->details;
            $fraud->tracking_id   = $request->tracking_id;
            $fraud->save();
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
