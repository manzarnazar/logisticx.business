<?php

namespace App\Http\Controllers\Backend\UserRole;

use App\Http\Controllers\Controller;
use App\Http\Requests\Department\StoreRequest;
use App\Http\Requests\Department\UpdateRequest;
use App\Repositories\Department\DepartmentInterface;

class DepartmentController extends Controller
{
    protected $repo;
    public function __construct(DepartmentInterface $repo)
    {
        $this->repo = $repo;
    }

    public function index()
    {
        $departments = $this->repo->all();
        return view('backend.department.index', compact('departments'));
    }

    public function create()
    {
        return view('backend.department.create');
    }

    public function store(StoreRequest $request)
    {
        $result = $this->repo->store($request);
        if ($result['status']) {
            return redirect()->route('departments')->with('success', $result['message']);
        }
        return back()->with('danger', $result['message']);
    }

    public function edit($id)
    {
        $department = $this->repo->get($id);
        return view('backend.department.edit', compact('department'));
    }

    public function update(UpdateRequest $request)
    {
        $result = $this->repo->update($request);
        if ($result['status']) {
            return redirect()->route('departments')->with('success', $result['message']);
        }
        return back()->with('danger', $result['message']);
    }

    public function delete($id)
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
