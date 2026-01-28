<?php

namespace App\Repositories\CustomerInquiry;

use App\Models\Backend\CustomerInquiry;
use App\Repositories\CustomerInquiry\CustomerInquiryInterface;
use App\Traits\ReturnFormatTrait;
use Illuminate\Support\Facades\Auth;

class CustomerInquiryRepository implements CustomerInquiryInterface
{
    use ReturnFormatTrait;

    protected $model;

    public function __construct(CustomerInquiry $model)
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

    public function find($id)
    {
        return $this->model::find($id);
    }

    public function store($request)
    {
        try {
            $inquiry             = new $this->model;
            $inquiry->name       = $request->name;
            $inquiry->phone      = $request->phone;
            $inquiry->email      = $request->email;
            $inquiry->message    = $request->message;
            $inquiry->subject    = $request->subject;
            $inquiry->save();

            return $this->responseWithSuccess(___('alert.successfully_submitted'), []);
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
