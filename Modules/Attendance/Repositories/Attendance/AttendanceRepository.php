<?php

namespace Modules\Attendance\Repositories\Attendance;

use App\Traits\ReturnFormatTrait;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Modules\Attendance\Entities\Attendance;
use Modules\Attendance\Enums\AttendanceType;

class AttendanceRepository implements AttendanceInterface
{
    use ReturnFormatTrait;

    protected $model;

    public function __construct(Attendance $model)
    {
        $this->model    = $model;
    }

    public function all(int $paginate = null, string $orderBy = 'id', string $sortBy = 'desc')
    {
        $query = $this->model::query();

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

    public function getAttandancesForDownload($filteredIds)
    {
        dd($filteredIds);
        return $this->model::with('user.department')->whereIn('id', $filteredIds)->get();
    }


    public function store($request)
    {
        // dd($request);
        try {
            foreach ($request->user as $user) {

                // if ($user['attendance_type'] != AttendanceType::PRESENT) {
                //     continue;
                // }

                DB::beginTransaction();

                $model = $this->model::where('user_id', $user['id'])->whereDate('date', Carbon::parse($request->date)->format('Y-m-d'))->first();

                if (is_null($model)) {
                    $model              = new $this->model;
                    $model->user_id     = $user['id'];
                    $model->date        = $request->date;
                }

                if ($user['check_in'] && $user['attendance_type'] == AttendanceType::PRESENT) {
                    $model->check_in    = $user['check_in'];
                }

                if ($user['check_out'] && $user['attendance_type'] == AttendanceType::PRESENT) {
                    $model->check_out   = $user['check_out'];
                }

                $model->type        = $user['attendance_type'];
                $model->note        = $user['note'];
                $model->save();

                DB::commit();
            }

            return $this->responseWithSuccess(___('alert.successfully_added'), []);
        } catch (\Throwable $th) {
            DB::rollBack();
            return $this->responseWithError(___('alert.something_went_wrong'), []);
        }
    }

    public function update($request)
    {
        // dd($request);
        try {
            $model                  = $this->model::findOrFail($request->id);
            $model->date            = $request->date;
            $model->check_in        = null;
            $model->check_out       = null;

            if ($request->check_in && $request->type == AttendanceType::PRESENT) {
                $model->check_in    = $request->check_in;
            }

            if ($request->check_out && $request->type == AttendanceType::PRESENT) {
                $model->check_out   = $request->check_out;
            }

            $model->type            = $request->type;
            $model->note            = $request->note;
            $model->save();

            return $this->responseWithSuccess(___('alert.successfully_updated'), []);
        } catch (\Throwable $th) {
            return $this->responseWithError(___('alert.something_went_wrong'), []);
        }
    }

    public function delete($id)
    {
        try {
            $model =   $this->model::find($id);
            $model->delete($id);
            return $this->responseWithSuccess(___('alert.successfully_deleted'), []);
        } catch (\Throwable $th) {
            return $this->responseWithError(___('alert.something_went_wrong'), []);
        }
    }
}
