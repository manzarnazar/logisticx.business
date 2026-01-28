<?php

namespace App\Repositories\AccountHeads;

use App\Enums\Status;
use App\Enums\AccountHeads;
use App\Traits\ReturnFormatTrait;
use App\Models\Backend\AccountHead;
use App\Repositories\AccountHeads\AccountHeadsInterface;

class AccountHeadsRepository implements AccountHeadsInterface
{
    use ReturnFormatTrait;

    private $model;

    public function __construct(AccountHead $model)
    {
        $this->model = $model;
    }

    public function all(string $orderBy = 'id', string $sortBy = 'desc')
    {
        return  $this->model::orderBy($orderBy, $sortBy)->paginate(settings('paginate_value'));
    }
    public function getActive(string $orderBy = 'id', string $sortBy = 'asc', $head = AccountHeads::INCOME)
    {
        return $this->model::where('status', Status::ACTIVE)->where('type', $head)->orderBy($orderBy, $sortBy)->get();
    }

    public function get($id)
    {
        return  $this->model::find($id);
    }

    public function store($request)
    {
        try {
            $account_head           = new $this->model;
            $account_head->type     = $request->type;
            $account_head->name     = $request->name;
            $account_head->status   = $request->status;
            $account_head->save();

            return $this->responseWithSuccess(___('alert.successfully_added'), []);
        } catch (\Throwable $th) {
            return $this->responseWithError(___('alert.something_went_wrong'), []);
        }
    }

    public function update($id, $request)
    {
        try {
            $account_head           =  $this->model::find($id);
            $account_head->type     = $request->type;
            $account_head->name     = $request->name;
            $account_head->status   = $request->status;
            $account_head->save();

            return $this->responseWithSuccess(___('alert.successfully_updated'), []);
        } catch (\Throwable $th) {

            if ($th->getCode() == 1403)  return $this->responseWithError(message: $th->getMessage(), status_code: 403);

            return $this->responseWithError(___('alert.something_went_wrong'), []);
        }
    }

    public function delete($id)
    {
        try {
            $this->model::destroy($id);

            return $this->responseWithSuccess(___('alert.successfully_deleted'), []);
        } catch (\Throwable $th) {

            if ($th->getCode() == 1403)  return $this->responseWithError(message: $th->getMessage(), status_code: 403);

            return $this->responseWithError(___('alert.something_went_wrong'), []);
        }
    }

    public function getHeads($type = null,  bool $status = Status::ACTIVE, ?int $paginate = null)
    {
        $query = $this->model::query();

        if ($type !== null) {
            $query->where('type', $type);
        }

        if ($status !== null) {
            $query->where('status', $status);
        }

        if ($paginate !== null) {
            return  $query->paginate($paginate);
        } else {
            return $query->get();
        }
    }
}
