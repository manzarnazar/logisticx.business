<?php

namespace Modules\Leave\Http\Controllers;

use App\Enums\Status;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Leave\Entities\LeaveType;
use Illuminate\Contracts\Support\Renderable;
use Modules\Leave\Entities\LeaveAssign;
use Modules\Leave\Repositories\LeaveType\LeaveTypeInterface;
use Modules\Leave\Http\Requests\LeaveType\LeaveTypeStoreRequest;
use Modules\Leave\Http\Requests\LeaveType\LeaveTypeUpdateRequest;


class LeaveTypeController extends Controller
{
    private $repo;

    public function __construct(LeaveTypeInterface $repo)
    {
        $this->repo = $repo;
    }
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        // $leave_types = LeaveType::orderBy('id','asc')->paginate(8);
        $leave_types = $this->repo->all();
        return view('leave::leave-type.index', compact('leave_types'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('leave::leave-type.create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(LeaveTypeStoreRequest $request)
    {
        $result = $this->repo->store($request);
        if ($result['status']) {
            return redirect()->route('leave.type.index')->with('success', $result['message']);
        }
        return back()->with('danger', $result['message']);
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('leave::leave-type.show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        $leave_type = $this->repo->find($id);
        return view('leave::leave-type.edit', compact('leave_type'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(LeaveTypeUpdateRequest $request)
    {
        $result = $this->repo->update($request);
        if ($result['status']) {
            return redirect()->route('leave.type.index')->with('success', $result['message']);
        }
        return back()->with('danger', $result['message']);
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
