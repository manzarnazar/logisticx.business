<?php

namespace App\Repositories\User;

use App\Enums\ImageSize;
use App\Enums\Status;
use App\Models\User;
use App\Models\Backend\Hub;
use App\Models\Backend\Department;
use App\Models\Backend\Designation;
use App\Traits\ReturnFormatTrait;
use Illuminate\Support\Facades\Hash;
use App\Repositories\User\UserInterface;
use App\Models\Backend\Role;
use App\Repositories\Upload\UploadInterface;
use Illuminate\Support\Facades\DB;

class UserRepository implements UserInterface
{
    use ReturnFormatTrait;
    protected $model, $upload;

    public function __construct(User $model, UploadInterface $upload)
    {
        $this->model    = $model;
        $this->upload   = $upload;
    }

    // get all rows in User model with Upload & Hub model row same as foreign key.
    public function all(bool $status = null, $userType = null, string $orderBy = 'id', string $sortBy = 'desc', int $paginate = null)
    {
        $query =  $this->model::query();

        $query->with('upload', 'hub');

        if ($status != null) {
            $query->where('status', $status);
        }

        if ($userType != null) {
            is_array($userType) ?  $query->whereIn('user_type', $userType) : $query->where('user_type', $userType);
        }

        $query->orderBy($orderBy, $sortBy);

        if ($paginate != null) {
            return $query->paginate($paginate);
        }

        return $query->get();
    }

    public function allGet()
    {
        return $this->model::orderByDesc('id', 'desc')->get();
    }

    public function filter($request)
    {
        $query =  $this->model::query();

        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        if ($request->name) {
            $query->where('name', 'like', '%' . $request->name . '%');
        }

        if ($request->email) {
            $query->where('email', 'like', '%' . $request->email . '%');
        }

        if ($request->phone) {
            $query->where('mobile', 'like', '%' . $request->phone . '%');
        }

        if ($request->skip_user_type) {
            $query->where('user_type', '!=', $request->skip_user_type);
        }

        $query->orderByDesc('id');

        $user = $query->paginate(settings('paginate_value'));

        return $user;
    }

    // get all rows in Hub model
    public function hubs()
    {
        return Hub::orderBy('name')->get();
    }

    // get all rows in Department model
    public function departments()
    {
        return Department::active()->orderBy('title')->get();
    }

    // get all rows in Designation model
    public function designations()
    {
        return Designation::active()->orderBy('title')->get();
    }

    // get single row in User model with Upload model row same as foreign key.
    public function get($id)
    {
        return $this->model::with('upload', 'role')->find($id);
    }

    public function store($request)
    {
        try {
            DB::beginTransaction();

            $user                   = new User();
            $user->name             = $request->name;
            $user->email            = $request->email;
            $user->password         = Hash::make($request->password);
            $user->mobile           = $request->mobile;
            $user->nid_number       = $request->nid_number;
            $user->designation_id   = $request->designation_id;
            $user->department_id    = $request->department_id;
            $user->hub_id           = $request->hub_id;

            $user->image_id         = $this->upload->uploadImage($request->image, 'users/', [ImageSize::IMAGE_80x80, ImageSize::IMAGE_370x240], null);

            $user->joining_date     = $request->joining_date;
            $user->address          = $request->address;
            $user->salary           = $request->salary !== "" ? $request->salary : 0;

            $user->role_id          = $request->role_id;
            $role                   = Role::find($user->role_id);
            if ($role && $role->permissions != null) {
                $user->permissions  = $role->permissions;
            }

            $user->status           = $request->status;
            $user->save();

            DB::commit();

            return $this->responseWithSuccess(___('alert.successfully_added'), []);
        } catch (\Throwable $th) {
            DB::rollBack();
            return $this->responseWithError(___('alert.something_went_wrong'), []);
        }
    }

    public function update($request)
    {
        try {
            DB::beginTransaction();

            $user                       = $this->model::find($request->id);
            $user->name                 = $request->name;
            $user->email                = $request->email;
            $user->mobile               = $request->mobile;
            $user->nid_number           = $request->nid_number;

            if ($request->id != 1) {
                $user->hub_id           = $request->hub_id;
                $user->designation_id   = $request->designation_id;
                $user->department_id    = $request->department_id;
                $user->status           = $request->status;
            }

            $user->joining_date         = $request->joining_date;
            $user->address              = $request->address;

            if ($request->password != null) {
                $user->password         = Hash::make($request->password);
            }

            $user->image_id             = $this->upload->uploadImage($request->image, 'users/', [ImageSize::IMAGE_80x80, ImageSize::IMAGE_370x240], $user->image_id);
            $user->salary               = $request->salary !== "" ? $request->salary : 0;

            $user->role_id              = $request->role_id;
            $role                       = Role::find($user->role_id);
            if ($role && $role->permissions != null) {
                $user->permissions      = $role->permissions;
            }

            $user->save();

            DB::commit();

            return $this->responseWithSuccess(___('alert.successfully_updated'), []);
        } catch (\Throwable $th) {
            DB::rollBack();
            return $this->responseWithError(___('alert.something_went_wrong'), []);
        }
    }

    // Delete single row in User Model with Delete single row in Upload model and delete image in public/upload/user folder..
    public function delete($id)
    {
        try {
            $item  = $this->model::findOrFail($id);

            $this->upload->deleteImage($item->image_id, 'delete');

            $item->delete();

            return $this->responseWithSuccess(___('alert.successfully_deleted'), []);
        } catch (\Throwable $th) {
            return $this->responseWithError(___('alert.something_went_wrong'), []);
        }
    }

    public function permissionUpdate($id, $request)
    {
        try {
            $user = $this->model::where('id', $id)->first();
            if ($request->permissions !== null) {
                $user->permissions = $request->permissions;
            } else {
                $user->permissions = [];
            }
            $user->save();

            return $this->responseWithSuccess(___('alert.successfully_updated'), []);
        } catch (\Throwable $th) {
            return $this->responseWithError(___('alert.something_went_wrong'), []);
        }
    }


    public function getWithFilter(array $where = [], array $columns = ['*'],  int $paginate = null)
    {
        $query = $this->model::query();

        $where['status'] = $where['status'] ?? Status::ACTIVE;

        $query->where($where);

        // Select the specified columns
        $query->select($columns);

        $query->orderBy('name', 'asc');
        // $query->orderBy('name', 'desc');

        if ($paginate !== null) {
            return  $query->paginate($paginate);
        } else {
            return $query->get();
        }
    }

    public function cookieConsent($request)
    {
        try {
            $user                   = auth()->user();
            $user->cookie_consent   = $request->cookie_consent;
            $user->save();

            $message = $request->cookie_consent ? ___('alert.cookie_accepted') : ___('alert.cookie_declined');

            return $this->responseWithSuccess($message);
        } catch (\Throwable $th) {
            return $this->responseWithError(___('alert.something_went_wrong'));
        }
    }
}
