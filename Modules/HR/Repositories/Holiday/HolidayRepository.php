<?php

namespace Modules\HR\Repositories\Holiday;

use App\Enums\Status;
use App\Repositories\Upload\UploadInterface;
use App\Traits\ReturnFormatTrait;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Modules\HR\Entities\Holiday;

class HolidayRepository implements HolidayInterface
{
    use ReturnFormatTrait;

    protected $model, $upload;

    public function __construct(Holiday $model, UploadInterface $upload)
    {
        $this->model    = $model;
        $this->upload   = $upload;
    }

    public function all(bool $status = null,  int $paginate = null, string $orderBy = 'id', string $sortBy = 'desc')
    {
        $query = $this->model::query();

        $query->with('file');

        if ($status !== null) {
            $query->where('status', $status);
        }

        $query->orderBy($orderBy, $sortBy);

        if ($paginate !== null) {
            return  $query->paginate($paginate);
        } else {
            return $query->get();
        }
    }

    public function get($id)
    {
        return $this->model::findOrFail($id);
    }



    public function store($request)
    {
        try {
            // dd($request);
            // $date = explode('to', $request->days); // case sensitive
            // $date = preg_split('/\bto\b/i', $request->days); // case insensitive
            // $from   = Carbon::parse(trim($date[0]))->startOfDay()->toDateTimeString();
            // $to     = Carbon::parse(trim($date[1]))->endOfDay()->toDateTimeString();
            DB::beginTransaction();
            $model              = new $this->model();
            $model->title       = $request->title;
            $model->from        = $request->from;
            $model->to          = $request->to;
            $model->description = $request->description;
            $model->file_id      = $this->upload->uploadImage($request->file, 'files/', [], null);
            $model->status      = $request->status ?? Status::INACTIVE;
            $model->save();
            DB::commit();
            return $this->responseWithSuccess(___('alert.successfully_added'), []);
        } catch (\Throwable $th) {
            DB::rollBack();
            return $this->responseWithError(___('alert.something_went_wrong'), []);
        }
    }

    public function update($request)
    {
        try {
            DB::beginTransaction();
            $model              = $this->model::findOrFail($request->id);
            $model->title       = $request->title;
            $model->from        = $request->from;
            $model->to          = $request->to;
            $model->description = $request->description;
            $model->file_id     = $this->upload->uploadImage($request->file, 'files/', [], $model->file_id);
            $model->status      = $request->status ?? Status::INACTIVE;
            $model->save();
            DB::commit();
            return $this->responseWithSuccess(___('alert.successfully_updated'), []);
        } catch (\Throwable $th) {
            DB::rollBack();
            return $this->responseWithError(___('alert.something_went_wrong'), []);
        }
    }

    public function delete($id)
    {
        try {
            $model =   $this->model::find($id);
            $this->upload->deleteImage($model->file_id, 'delete');
            $model->delete($id);
            return $this->responseWithSuccess(___('alert.successfully_deleted'), []);
        } catch (\Throwable $th) {
            return $this->responseWithError(___('alert.something_went_wrong'), []);
        }
    }
}
