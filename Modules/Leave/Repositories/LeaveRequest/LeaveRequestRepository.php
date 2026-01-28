<?php

namespace Modules\Leave\Repositories\LeaveRequest;


use Carbon\Carbon;
use App\Enums\Status;
use App\Enums\ImageSize;
use App\Models\User;
use App\Traits\ReturnFormatTrait;
use Illuminate\Support\Facades\Auth;
use Modules\Leave\Entities\LeaveRequest;
use Modules\Leave\Enums\LeaveRequestStatus;
use App\Repositories\Upload\UploadInterface;
use Modules\Leave\Entities\LeaveAssign;
use Modules\Leave\Repositories\LeaveRequest\LeaveRequestInterface;



class LeaveRequestRepository implements LeaveRequestInterface
{
    use ReturnFormatTrait;

    protected $model, $upload;

    public function __construct(LeaveRequest $model, UploadInterface $upload)
    {
        $this->model = $model;
        $this->upload = $upload;
    }

    public function all(string $orderBy = 'id', string $sortBy = 'desc')
    {
        return $this->model->orderBy($orderBy, $sortBy)->paginate(settings('paginate_value'));
    }

    public function userReadOnly()
    {
        $AuthUserId = Auth::id();
        return $this->model->where('user_id', $AuthUserId)->orderBy('id', 'desc')->paginate(settings('paginate_value'));
    }

    public function activeLeaveRequest()
    {
        return $this->model->where('status', Status::ACTIVE)->orderBy('position', 'desc')->get();
    }

    public function find($id)
    {
        return $this->model->find($id);
    }

    public function store($request)
    {

        try {

            $user_id                = $request->has('user') && haspermission('leave_request_read_all') ? $request->user : auth()->user()->id;

            $user                 = User::find($user_id);

            $leaveAssign          = LeaveAssign::where('department_id', $user->department_id)->where('type_id', $request->type_id)->where('status', Status::ACTIVE)->first();

            $usedLeave            = $this->model::where('user_id', $user_id)->where('type_id', $request->type_id)->where('status', LeaveRequestStatus::APPROVED)->sum('days');

            if (($leaveAssign->days - $usedLeave) < 1) {
                return $this->responseWithError(___('alert.limit_exceed'), []);
            }

            $date                 = preg_split('/\bto\b/i', $request->date);
            $from                 = Carbon::parse(trim($date[0]))->startOfDay();
            $to                   = isset($date[1]) ? Carbon::parse(trim($date[1]))->endOfDay() : Carbon::parse(trim($date[0]))->endOfDay();

            // Storing new Request Starts Here 

            $leave_req            = new $this->model;

            $leave_req->user_id   = $user_id;
            $leave_req->type_id   = $request->type_id;
            $leave_req->name      = $user->name;
            $leave_req->date      = now();
            $leave_req->from_date = $from;
            $leave_req->to_date   = $to;
            $leave_req->days      = $from->diffInDays($to) + 1;
            $leave_req->reason    = $request->reason;
            $leave_req->file_id   = $this->upload->uploadImage($request->file_id, 'application');
            $leave_req->save();

            return $this->responseWithSuccess(___('alert.successfully_added'), []);
        } catch (\Throwable $th) {
            return $this->responseWithError(___('alert.something_went_wrong'), []);
        }
    }

    public function update($request, $id)
    {
        try {

            $date = preg_split('/\bto\b/i', $request->date);

            $from = Carbon::parse(trim($date[0]))->startOfDay();
            $to = isset($date[1]) ? Carbon::parse(trim($date[1]))->endOfDay() : null;


            // Updating new Request Starts Here 

            $leave_req                  = $this->model->find($id);

            $leave_req->type_id         = $request->type_id;
            $leave_req->user_id         = $request->user;
            $leave_req->role_id         = $request->role_id;
            $leave_req->date            = now();
            $leave_req->department_id   = $request->department_id;
            $leave_req->from_date       = $from->toDateTimeString();
            $leave_req->to_date         = $to ? $to->toDateTimeString() :  $leave_req->from_date;
            $leave_req->days            = $to ? $from->diffInDays($to) + 1 : 1;
            $leave_req->reason          = $request->reason;
            $leave_req->file_id         = $this->upload->uploadImage($request->file_id, 'application', [], $leave_req->file_id);

            $leave_req->save();

            return $this->responseWithSuccess(___('alert.successfully_updated'), []);
        } catch (\Throwable $th) {
            return $this->responseWithError(___('alert.something_went_wrong'), []);
        }
    }

    public function delete($id)
    {
        $this->model::destroy($id);
        return $this->responseWithSuccess(___('alert.successfully_deleted'), []);

        try {

            $leave_req = $this->find($id);
            $this->upload->deleteImage($leave_req->file_id, 'delete');
            $leave_req->delete();

            return $this->responseWithSuccess(___('alert.successfully_deleted'), []);
        } catch (\Throwable $th) {
            return $this->responseWithError(___('alert.something_went_wrong'), []);
        }
    }

    public function requestPending($id, $request)
    {

        try {
            $leave_request            = $this->model::find($id);
            $leave_request->note      = $request->note;
            $leave_request->status    = LeaveRequestStatus::PENDING;
            $leave_request->save();

            return $this->responseWithSuccess(___('alert.successfully_status_updated'), []);
        } catch (\Throwable $th) {
            return $this->responseWithError(___('alert.something_went_wrong'), []);
        }
    }

    public function requestApproved($id, $request)
    {
        try {

            $leave_request           = $this->model::find($id);
            $leave_request->note     = $request->note;
            $leave_request->status   = LeaveRequestStatus::APPROVED;
            $leave_request->save();

            return $this->responseWithSuccess(___('alert.successfully_status_updated'), []);
        } catch (\Throwable $th) {
            return $this->responseWithError(___('alert.something_went_wrong'), []);
        }
    }

    public function requestRejected($id, $request)
    {
        try {
            $leave_request           = $this->model::find($id);
            $leave_request->note     = $request->note;
            $leave_request->status   = LeaveRequestStatus::REJECTED;
            $leave_request->save();

            return $this->responseWithSuccess(___('alert.successfully_status_updated'), []);
        } catch (\Throwable $th) {
            return $this->responseWithError(___('alert.something_went_wrong'), []);
        }
    }
}
