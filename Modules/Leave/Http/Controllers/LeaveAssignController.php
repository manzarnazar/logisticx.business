<?php

namespace Modules\Leave\Http\Controllers;

use Illuminate\Routing\Controller;
use App\Repositories\Department\DepartmentInterface;
use Modules\Leave\Repositories\LeaveType\LeaveTypeInterface;
use Modules\Leave\Repositories\LeaveAssign\LeaveAssignInterface;
use Modules\Leave\Http\Requests\LeaveAssign\LeaveAssignStoreRequest;
use Modules\Leave\Http\Requests\LeaveAssign\LeaveAssignUpdateRequest;

class LeaveAssignController extends Controller
{
    private $repo, $dept, $type;

    public function __construct(LeaveAssignInterface $repo, DepartmentInterface $dept, LeaveTypeInterface $type)
    {
        $this->repo = $repo;
        $this->dept = $dept;
        $this->type = $type;
    }

    public function index()
    {
        $leave_assigns = $this->repo->all(paginate: settings('paginate_value'));
        return view('leave::leave-assign.index', compact('leave_assigns'));
    }

    public function create()
    {
        $departments = $this->dept->all();
        $types       = $this->type->activeLeaveType();
        return view('leave::leave-assign.create', compact('departments', 'types'));
    }

    public function store(LeaveAssignStoreRequest $request)
    {
        $result = $this->repo->store($request);
        if ($result['status']) {
            return redirect()->route('leave.assign.index')->with('success', $result['message']);
        }
        return back()->with('danger', $result['message'])->withInput();
    }

    public function edit($id)
    {
        $departments = $this->dept->all();
        $types       = $this->type->activeLeaveType();
        $leave_assign = $this->repo->find($id);
        return view('leave::leave-assign.edit', compact('leave_assign', 'departments', 'types'));
    }

    public function update(LeaveAssignUpdateRequest $request)
    {
        $result = $this->repo->update($request);
        if ($result['status']) {
            return redirect()->route('leave.assign.index')->with('success', $result['message']);
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
}
