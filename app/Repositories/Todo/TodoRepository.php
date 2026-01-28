<?php

namespace App\Repositories\Todo;

use App\Models\Backend\To_do;
use App\Models\User;
use App\Repositories\Todo\TodoInterface;
use App\Enums\TodoStatus;
use App\Enums\UserType;
use App\Traits\ReturnFormatTrait;

class TodoRepository implements TodoInterface
{

    use ReturnFormatTrait;

    protected $model;

    public function __construct(To_do $model)
    {
        $this->model = $model;
    }


    public function all($status = null, string $orderBy = 'id', string $sortBy = 'desc', int $paginate = null)
    {
        $query = $this->model::query();

        if (auth()->user()->user_type != UserType::ADMIN) {
            $query->where('user_id', auth()->user()->id);
        }

        if ($status != null) {
            $query->where('status', $status);
        }

        $query->orderBy($orderBy, $sortBy);

        if ($paginate != null) {
            return $query->paginate($paginate);
        }

        return $query->get();
    }

    public function get($id)
    {
        return $this->model::find($id);
    }

    public function store($request)
    {
        try {
            $todo               = new $this->model();
            $todo->title        = $request->title;
            $todo->description  = $request->description;
            $todo->user_id      = $request->user_id;
            $todo->date         = $request->date;
            $todo->save();

            return $this->responseWithSuccess(___('alert.successfully_updated'), ['redirect_url' => route('todo.index'), 'status_code' => '201',]);
        } catch (\Throwable $th) {
            return $this->responseWithError(___('alert.something_went_wrong'), ['status_code' => '500']);
        }
    }

    public function update($request)
    {
        try {
            $todo               = $this->model::find($request->id);
            $todo->title        = $request->title;
            $todo->description  = $request->description;
            $todo->user_id      = $request->user_id; // user_id not getting in request , need review
            $todo->date         = $request->date;
            $todo->save();

            return $this->responseWithSuccess(___('alert.successfully_updated'), ['redirect_url' => route('todo.index'), 'status_code' => '201',]);
        } catch (\Throwable $th) {
            return $this->responseWithError(___('alert.something_went_wrong'), ['status_code' => '500']);
        }
    }

    public function todoProcessing($id, $request)
    {
        // dd($request->note);
        try {
            $todoProcessing           = $this->model::find($id);
            $todoProcessing->note     = $request->note;
            $todoProcessing->status   = TodoStatus::PROCESSING;
            $todoProcessing->save();

            return $this->responseWithSuccess(___('alert.todo_processing_success'), ['redirect_url' => route('todo.index'), 'status_code' => '201',]);
        } catch (\Throwable $th) {
            return $this->responseWithError(___('alert.something_went_wrong'), ['status_code' => '500']);
        }
    }
    public function todoComplete($id, $request)
    {
        try {
            $todoComplete         = $this->model::find($id);
            $todoComplete->note   = $request->note;
            $todoComplete->status = TodoStatus::COMPLETED;
            $todoComplete->save();

            return $this->responseWithSuccess(___('alert.todo_compete_success'), ['redirect_url' => route('todo.index'), 'status_code' => '201',]);
        } catch (\Throwable $th) {
            return $this->responseWithError(___('alert.something_went_wrong'), ['status_code' => '500']);
        }
    }

    public function delete($id)
    {
        $this->model::destroy($id);
        return $this->responseWithSuccess(___('alert.successfully_deleted'), []);
    }
}
