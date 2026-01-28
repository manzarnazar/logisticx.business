<?php

namespace Modules\HR\Repositories\Weekend;

use App\Traits\ReturnFormatTrait;
use Modules\HR\Entities\Weekend;

class WeekendRepository implements WeekendInterface
{
    use ReturnFormatTrait;

    protected $model;

    public function __construct(Weekend $model)
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

    public function update($request)
    {
        try {
            $model              = $this->model::findOrFail($request->id);
            $model->name        = $request->name;
            $model->is_weekend  = $request->is_weekend;
            $model->status      = $request->status;
            $model->save();
            return $this->responseWithSuccess(___('alert.successfully_updated'), []);
        } catch (\Throwable $th) {
            return $this->responseWithError(___('alert.something_went_wrong'), []);
        }
    }
}
