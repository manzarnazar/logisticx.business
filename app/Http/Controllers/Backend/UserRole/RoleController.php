<?php

namespace App\Http\Controllers\Backend\UserRole;

use App\Http\Controllers\Controller;
use App\Http\Requests\Role\StoreRoleRequest;
use App\Http\Requests\Role\UpdateRoleRequest;
use App\Repositories\Role\RoleInterface;

class RoleController extends Controller
{
    protected $repo;

    public function __construct(RoleInterface $repo)
    {
        $this->repo = $repo;
    }

    public function index()
    {
        $roles = $this->repo->all();
        return view('backend.role.index', compact('roles'));
    }
    public function create()
    {
        $permissions = $this->repo->permissions(null);
        return view('backend.role.create', compact('permissions'));
    }

    public function store(StoreRoleRequest $request)
    {
        $result = $this->repo->store($request);
        if ($result['status']) {
            return redirect()->route('roles')->with('success', $result['message']);
        }
        return back()->with('danger', $result['message']);
    }

    public function edit($id)
    {
        $role = $this->repo->get($id);
        $permissions = $this->repo->permissions($role->slug);
        return view('backend.role.edit', compact('role', 'permissions'));
    }

    public function update(UpdateRoleRequest $request)
    {
        $result = $this->repo->update($request);
        if ($result['status']) {
            return redirect()->route('roles')->with('success', $result['message']);
        }
        return back()->with('danger', $result['message']);
    }

    public function delete($id)
    {
        if ($this->repo->delete($id)) :
            $response[0] = ___('alert.successfully_deleted');
            $response[1] = 'success';
            $response[2] = ___('delete.deleted');
            return response()->json($response);
        else :
            $response[0] = ___('alert.something_went_wrong');
            $response[1] = 'error';
            $response[2] = ___('delete.oops');
            return response()->json($response);
        endif;
    }
}
