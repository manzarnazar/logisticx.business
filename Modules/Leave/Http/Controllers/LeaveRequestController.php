<?php

namespace Modules\Leave\Http\Controllers;

use App\Enums\Status;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\Support\Renderable;
use Modules\Leave\Entities\LeaveAssign;
use Modules\Leave\Entities\LeaveRequest;
use Modules\Leave\Enums\LeaveRequestStatus;
use Modules\Leave\Repositories\LeaveType\LeaveTypeInterface;
use Modules\Leave\Repositories\LeaveRequest\LeaveRequestInterface;
use Modules\Leave\Http\Requests\LeaveRequest\LeaveRequestStoreRequest;
use Modules\Leave\Http\Requests\LeaveRequest\LeaveRequestUpdateRequest;

class LeaveRequestController extends Controller
{
    private $repo, $typeRepo;

    public function __construct(LeaveRequestInterface $repo, LeaveTypeInterface $type)
    {
        $this->repo = $repo;
        $this->typeRepo = $type;
    }

    public function index()
    {
        $user = Auth::user();

        if (hasPermission('leave_request_read')) {
            $leave_requests = $this->repo->userReadOnly();
            return view('leave::leave-request.index', compact('leave_requests'));
        } else {
            abort(403, 'Unauthorized');
        }
    }

    public function create()
    {
        $types = $this->typeRepo->activeLeaveType();
        return view('leave::leave-request.create', compact('types'));
    }

    public function store(LeaveRequestStoreRequest $request)
    {
        $result = $this->repo->store($request);
        if ($result['status']) {
            return redirect()->route('leave.request.self.index')->with('success', $result['message']);
        }
        return back()->with('danger', $result['message'])->withInput();
    }

    public function edit($id)
    {
        $leave_request = $this->repo->find($id);
        $types = $this->typeRepo->activeLeaveType();
        return view('leave::leave-request.edit', compact('leave_request', 'types'));
    }

    public function update(LeaveRequestUpdateRequest $request, $id)
    {
        $result = $this->repo->update($request, $id);
        if ($result['status']) {
            return redirect()->route('leave.request.self.index')->with('success', $result['message']);
        }
        return back()->with('danger', $result['message'])->withInput();
    }

    public function destroy($id)
    {
        if ($this->repo->delete($id)) :
            $success[0] = ___('alert.successfully_deleted');
            $success[1] = 'success';
            $success[2] = ___('delete.deleted');
            return response()->json($success);
        else :
            $success[0] = ___('alert.something_went_wrong');
            $success[1] = 'error';
            $success[2] = ___('delete.oops');
            return response()->json($success);
        endif;
    }

    public function getLeaveTypes(Request $request)
    {
        if (!request()->ajax()) {
            return response()->json(['message' => ___('alert.invalid_request')], 422);
        }

        $user  =  User::find($request->user_id);
        if (!$user) {
            return response()->json(['message' => 'No User found.'], 404);
        }

        $leaveAssigns = LeaveAssign::with('type')->where('department_id', $user->department_id)->where('status', Status::ACTIVE)->get();

        if (count($leaveAssigns) == 0) {
            return response()->json(['message' => 'No leaves found.'], 404);
        }

        $types = [];

        foreach ($leaveAssigns as $leave) {
            $usedLeaves = LeaveRequest::where('user_id', $request->user_id)->where('type_id', $leave->type_id)->where('status', LeaveRequestStatus::APPROVED)->sum('days');

            $remaining = $leave->days - $usedLeaves;

            if ($remaining > 0) {
                $types[] = [
                    'id'             => $leave->type_id,
                    'name'           => $leave->type->name,
                    'remaining_days' => $remaining,
                ];
            }
        }

        if (count($types) == 0) {
            return response()->json(['message' => 'No remaining leaves found.'], 404);
        }

        return response()->json($types);
    }
}
