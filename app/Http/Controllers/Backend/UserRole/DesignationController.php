<?php

namespace App\Http\Controllers\Backend\UserRole;

use App\Http\Controllers\Controller;
use App\Http\Requests\Designation\StoreRequest;
use App\Http\Requests\Designation\UpdateRequest;
use App\Repositories\Designation\DesignationInterface;

class DesignationController extends Controller
{
    protected $repo;
    public function __construct(DesignationInterface $repo)
    {
        $this->repo = $repo;
    }

    public function index()
    {
        $designations = $this->repo->all();
        return view('backend.designation.index', compact('designations'));
    }

    public function create()
    {
        return view('backend.designation.create');
    }

    public function store(StoreRequest $request)
    {
        $result = $this->repo->store($request);
        if ($result['status']) {
            return redirect()->route('designations')->with('success', $result['message']);
        }
        return back()->with('danger', $result['message']);
    }

    public function edit($id)
    {
        $designation = $this->repo->get($id);
        return view('backend.designation.edit', compact('designation'));
    }

    public function update(UpdateRequest $request)
    {
        $result = $this->repo->update($request);
        if ($result['status']) {
            return redirect()->route('designations')->with('success', $result['message']);
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
