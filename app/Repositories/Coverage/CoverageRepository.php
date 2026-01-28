<?php

namespace App\Repositories\Coverage;

use App\Enums\Area;
use App\Enums\Status;
use App\Models\Backend\Coverage;
use App\Traits\ReturnFormatTrait;
use Illuminate\Support\Facades\Cache;

class CoverageRepository implements CoverageInterface
{
    use ReturnFormatTrait;

    private $model;

    public function __construct(Coverage $model)
    {
        $this->model = $model;
    }

    public function all(array $column = [], ?int $paginate = null, string $orderBy = 'id', string $sortBy = 'desc', array $where = [], ?string $search = null)
    {
        $query = $this->model::query()
            ->when($search !== null, fn($q) => $q->where('name', 'like', "%{$search}%"))
            ->when(!empty($where), fn($q) => $q->where($where))
            ->when(!empty($column), fn($q) => $q->select($column))
            ->orderBy($orderBy, $sortBy);

        return $paginate !== null ? $query->paginate($paginate) : $query->get();
    }

    public function get(int $id)
    {
        return $this->model::findOrFail($id);
    }

    public function store($request)
    {
        try {
            $area               = $this->model;
            $area->parent_id    = $request->parent != null ? $request->parent : null;
            $area->name         = $request->name;
            $area->position     = $request->position != null ? $request->position : 0;
            $area->status       = $request->status;
            $area->save();

            Cache::forget('coverages');
            Cache::forget('coveragesWithActiveChild');

            return $this->responseWithSuccess(___('alert.successfully_added'), []);
        } catch (\Throwable $th) {
            return $this->responseWithError(___('alert.something_went_wrong'), []);
        }
    }


    public function update($request)
    {
        try {

            $area               = $this->model::findOrFail($request->id);
            $area->parent_id    = $request->parent != null ? $request->parent : null;
            $area->name         = $request->name;
            $area->position     = $request->position != null ? $request->position : 0;
            $area->status       = $request->status;
            $area->save();

            Cache::forget('coverages');
            Cache::forget('coveragesWithActiveChild');

            return $this->responseWithSuccess(___('alert.successfully_updated'), []);
        } catch (\Throwable $th) {
            return $this->responseWithError(___('alert.something_went_wrong'), []);
        }
    }
    // for delete
    public function delete($id)
    {
        $this->model::destroy($id);

        Cache::forget('coverages');
        Cache::forget('coveragesWithActiveChild');

        return $this->responseWithSuccess(___('alert.successfully_deleted'), []);
    }

    public function getWithActiveChild($request = null)
    {
        // Set a default parent_id, status filter if not provided
        $keyword = $request && method_exists($request, 'get') ? $request->get('keyword') : null;
        $query = Coverage::with('activeChild')
            ->where('parent_id', null)
            ->where('status', Status::ACTIVE);

        if ($keyword) {
            $query->where(function ($q) use ($keyword) {
                $q->where('name', 'like', "%$keyword%")
                    ->orWhereHas('activeChild', function ($q1) use ($keyword) {
                        $q1->where('name', 'like', "%$keyword%")
                            ->orWhereHas('activeChild', function ($q2) use ($keyword) {
                                $q2->where('name', 'like', "%$keyword%");
                            });
                    });
            });
        }

        return $query->get(['id', 'parent_id', 'name']);
    }

    public function detectArea(?int $pickup_coverage_id = null, ?int $destination_coverage_id = null)
    {
        $area                   = Area::OUTSIDE_CITY->value;

        if ($pickup_coverage_id == $destination_coverage_id) {
            $area = Area::INSIDE_CITY->value;
        } else {
            $pickup       =  $this->model::find($pickup_coverage_id);
            $destination  =  $this->model::find($destination_coverage_id);

            if ($pickup && $destination && ($pickup->parent_id == $destination->parent_id || $pickup->id == $destination->parent_id || $pickup->parent_id == $destination->id)) {
                $area = Area::SUB_CITY->value;
            }
        }

        return $area;
    }
}
