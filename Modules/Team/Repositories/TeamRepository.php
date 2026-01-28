<?php

namespace Modules\Team\Repositories;

use App\Enums\Status;
use App\Enums\TeamStatus;
use App\Models\Upload;
use App\Repositories\Upload\UploadInterface;
use App\Traits\ReturnFormatTrait;
use Modules\Team\Repositories\TeamInterface;
use Illuminate\Support\Facades\File;
use Modules\Team\Entities\Team;

class TeamRepository implements TeamInterface
{
    use ReturnFormatTrait;

    protected $model;

    public function __construct(Team $model)
    {
        $this->model = $model;
    }

    public function all(string $orderBy = 'id', string $sortBy = 'desc')
    {
        return $this->model::orderBy($orderBy, $sortBy)->paginate(settings('paginate_value'));
    }

    public function activeAll(string $orderBy = 'position', string $sortBy = 'asc')
    {
        return $this->model::orderBy($orderBy, $sortBy)->where('status', Status::ACTIVE)->get()->take(4);
    }



    public function get($id)
    {
        return $this->model::findOrFail($id);
    }

    public function store($request)
    {
        try {
            $team               = new Team();
            $team->user_id      = $request->user;
            $team->position     = $request->position;
            $team->facebook     = $request->facebook;
            $team->twitter      = $request->twitter;
            $team->linkedin     = $request->linkedin;
            $team->status       = $request->status ?? Status::INACTIVE;
            $team->save();


            return $this->responseWithSuccess(___('alert.successfully_added'), []);
        } catch (\Throwable $th) {
            return $this->responseWithError(___('alert.something_went_wrong'), []);
        }
    }

    public function update($request, $id)
    {
        try {
            $team               = $this->model::findOrFail($id);
            $team->user_id      = $request->user;
            $team->position      = $request->position;
            $team->facebook     = $request->facebook;
            $team->twitter      = $request->twitter;
            $team->linkedin     = $request->linkedin;
            $team->status       = $request->status ?? Status::INACTIVE;
            $team->save();

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

    public function statusUpdate($id)
    {
        try {
            $team                = $this->model::find($id);
            if ($team->status == Status::ACTIVE) :
                $team->status = Status::INACTIVE;
            elseif ($team->status == Status::INACTIVE) :
                $team->status = Status::ACTIVE;
            endif;
            $team->save();

            return true;
        } catch (\Throwable $th) {

            return false;
        }
    }
}
