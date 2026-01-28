<?php

namespace Modules\Leave\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Modules\Leave\Entities\LeaveAssign;
use App\Repositories\Role\RoleInterface;
use App\Repositories\User\UserInterface;
use Modules\Leave\Entities\LeaveRequest;
use Illuminate\Contracts\Support\Renderable;
use App\Repositories\Department\DepartmentInterface;
use Modules\Leave\Enums\LeaveRequestStatus;
use Modules\Leave\Repositories\LeaveType\LeaveTypeInterface;
use Modules\Leave\Repositories\LeaveAssign\LeaveAssignInterface;
use Modules\Leave\Repositories\LeaveRequest\LeaveRequestInterface;

class AllLeaveRequestController extends Controller
{
    private $repo, $typeRepo, $dept_repo, $role_repo, $user_repo, $leaveAssignRepo;

    public function __construct(LeaveRequestInterface $repo, LeaveTypeInterface $type, LeaveAssignInterface $leaveAssignRepo, DepartmentInterface $dept_repo, RoleInterface $role_repo, UserInterface $user_repo)
    {
        $this->repo            = $repo;
        $this->typeRepo        = $type;
        $this->dept_repo       = $dept_repo;
        $this->role_repo       = $role_repo;
        $this->user_repo       = $user_repo;
        $this->leaveAssignRepo = $leaveAssignRepo;
    }
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {

        if (hasPermission('leave_request_read_all') &&  hasPermission('leave_request_read')) {
            //for Super-Admin/Admin

            $department = auth()->user()->department_id;
            $departmentWiseAssignedLeaveDays = LeaveAssign::where('department_id', $department)->get();

            $leave_requests = $this->repo->all(); // all requests
            return view('leave::all-leave-request.index', compact('leave_requests'));
        } else {
            abort(403, 'Unauthorized');
        }
    }

    public function requestPending(Request $request)
    {
        $result = $this->repo->requestPending($request->request_id, $request);
        if ($result['status']) {
            return redirect()->route('all-leave-request.index')->with('success', $result['message']);
        }
        return back()->with('danger', $result['message']);
    }

    public function requestApproved(Request $request)
    {

        $result = $this->repo->requestApproved($request->request_id, $request);
        if ($result['status']) {
            return redirect()->route('all-leave-request.index')->with('success', $result['message']);
        }
        return back()->with('danger', $result['message']);
    }

    public function requestRejected(Request $request)
    {
        $result = $this->repo->requestRejected($request->request_id, $request);
        if ($result['status']) {
            return redirect()->route('all-leave-request.index')->with('success', $result['message']);
        }
        return back()->with('danger', $result['message']);
    }




    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        $types          = $this->typeRepo->activeLeaveType();
        $departments    = $this->dept_repo->activeDepartments();
        $roles          = $this->role_repo->getRole();
        $users          = $this->user_repo->all();

        return view('leave::all-leave-request.create', compact('types', 'departments', 'roles', 'users'));
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        $result = $this->repo->store($request);
        if ($result['status']) {
            return redirect()->route('all-leave-request.index')->with('success', $result['message']);
        }
        return back()->with('danger', $result['message']);
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        $types           = $this->typeRepo->activeLeaveType();
        $departments     = $this->dept_repo->activeDepartments();
        $roles           = $this->role_repo->getRole();
        $users           = $this->user_repo->allGet();
        $leave_request   = $this->repo->find($id);

        return view('leave::all-leave-request.edit', compact('types', 'departments', 'leave_request', 'roles', 'users'));
    }
    // public function edit($id)
    // {
    //     $data = [
    //         'types'          => $this->typeRepo->activeLeaveType(),
    //         'departments'    => $this->dept_repo->activeDepartments(),
    //         'roles'          => $this->role_repo->getRole(),
    //         'users'          => $this->user_repo->all(),
    //         'leave_request'  => $this->repo->find($id),
    //     ];
    //     return view('leave::all-leave-request.edit', compact('data'));
    // }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        $result = $this->repo->update($request, $id);
        if ($result['status']) {
            return redirect()->route('all-leave-request.index')->with('success', $result['message']);
        }
        return back()->with('danger', $result['message']);
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
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
    public function getDepartments()
    {
        $departments     = $this->dept_repo->activeDepartments();
        return $departments;
    }
    public function getRoles()
    {
        $roles           = $this->role_repo->getRole();
        return $roles;
    }

    public function availableDaysCalc($id, $typeId)
    {
        $requestedUser  = LeaveRequest::find($id)->user_id;
        $userDepartment = User::find($requestedUser)->department_id;

        $departmentalAssignedLeavesByType = LeaveAssign::where('department_id', $userDepartment)->where('type_id', $typeId)->value('days');

        // Get the user's leave requests for the requested leave type
        $requestedUsersLeaveStoryByThatType = LeaveRequest::where('user_id', $requestedUser)
            ->where('type_id', $typeId)
            ->where('status', LeaveRequestStatus::APPROVED)
            ->pluck('days')
            ->toArray();


        $totalLeaveTaken = array_sum($requestedUsersLeaveStoryByThatType);

        $available_days = $departmentalAssignedLeavesByType - $totalLeaveTaken;

        return response()->json($available_days);
    }
}
