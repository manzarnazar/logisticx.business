<?php

namespace App\Repositories\Role;

use App\Enums\Status;
use App\Traits\ReturnFormatTrait;
use App\Models\Backend\Role;
use App\Models\Permission;
use App\Repositories\Role\RoleInterface;

class RoleRepository implements RoleInterface
{
    use ReturnFormatTrait;

    private $model;

    public function __construct(Role $model)
    {
        $this->model = $model;
    }

    public function all(string $orderBy = 'id', string $sortBy = 'desc')
    {
        return $this->model::orderBy($orderBy, $sortBy)->paginate(settings('paginate_value'));
    }

    public function getRole(string $orderBy = 'id', string $sortBy = 'desc')
    {
        return $this->model::where('status', Status::ACTIVE)->orderBy($orderBy, $sortBy)->get();
    }

    public function get($id)
    {
        return $this->model::find($id);
    }

    public function store($request)
    {
        try {
            $role               = new $this->model;
            $role->name         = $request->name;
            $role->permissions  = $request->permissions;
            $role->status       = $request->status;
            $role->slug         = str_replace(' ', '-',  strtolower($request->name));
            $role->save();
            return $this->responseWithSuccess(___('alert.successfully_added'), []);
        } catch (\Throwable $th) {
            return $this->responseWithError(___('alert.something_went_wrong'), []);
        }
    }

    public function update($request)
    {
        try {
            $role               = $this->model::find($request->id);
            $role->name         = $request->name;
            $role->permissions  = $request->permissions;
            $role->status       = $request->status;
            $role->slug         = str_replace(' ', '-',  strtolower($request->name));
            $role->save();

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

    public function permissions($role)
    {
        if ($role == 'admin' || $role == 'super-admin') {
            $ownerBlockedPermission[]['attribute'] = 'hub_payments_request';
            $ownerBlockedPermission[]['attribute'] = 'cash_received_from_delivery_man';
            return Permission::whereNotIn('attribute', $ownerBlockedPermission)->orderBy('id', 'asc')->get();
        } else {
            return Permission::orderBy('id', 'asc')->get();
        }
    }
}
