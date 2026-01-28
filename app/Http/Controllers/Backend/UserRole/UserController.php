<?php

namespace App\Http\Controllers\Backend\UserRole;

use App\Enums\Status;
use App\Enums\UserType;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\User\StoreUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Models\User;
use App\Repositories\Role\RoleInterface;
use App\Repositories\User\UserInterface;

class UserController extends Controller
{
    protected $repo, $role;

    public function __construct(UserInterface $repo, RoleInterface $role)
    {
        $this->repo = $repo;
        $this->role = $role;
    }

    public function index(Request $request)
    {
        $users = $this->repo->all(userType: [UserType::ADMIN, UserType::INCHARGE, UserType::HUB], paginate: settings('paginate_value'));
        return view('backend.user.index', compact('users'));
    }

    public function filter(Request $request)
    {
        $users = $this->repo->filter($request);
        return view('backend.user.index', compact('users'));
    }

    public function create()
    {
        $hubs         = $this->repo->hubs();
        $departments  = $this->repo->departments();
        $designations = $this->repo->designations();
        $roles        = $this->role->getRole();
        return view('backend.user.create', compact('roles', 'hubs', 'designations', 'departments'));
    }

    public function store(StoreUserRequest $request)
    {
        $result = $this->repo->store($request);
        if ($result['status']) {
            return redirect()->route('users')->with('success', $result['message']);
        }
        return back()->with('danger', $result['message'])->withInput();
    }

    public function edit($id)
    {
        $user         = $this->repo->get($id);
        $hubs         = $this->repo->hubs();
        $departments  = $this->repo->departments();
        $designations = $this->repo->designations();
        $roles        = $this->role->getRole();
        return view('backend.user.edit', compact('user', 'hubs', 'departments', 'designations', 'roles'));
    }

    public function update(UpdateUserRequest $request)
    {
        $result = $this->repo->update($request);
        if ($result['status']) {
            return redirect()->route('users')->with('success', $result['message']);
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
    //user permissions
    public function permission($id)
    {
        $user        = User::where('id', $id)->first();
        $permissions = $this->role->permissions($user->role->slug);
        return view('backend.user.permissions', compact('user', 'permissions'));
    }

    public function permissionsUpdate(Request $request)
    {
        $result = $this->repo->permissionUpdate($request->id, $request);
        if ($result['status']) {
            return redirect()->route('users')->with('success', $result['message']);
        }
        return redirect()->back()->with('danger', $result['message']);
    }

    public function getUser(Request $request)
    {
        if (!request()->ajax()) {
            return response()->json(['error' => ___('alert.invalid_request')], 422);
        }

        if ($request->search == null) {
            return response()->json(['error' => 'Search parameter can not be null.'], 422);
        }

        $request->merge(['status' => Status::ACTIVE]);

        $users = $this->repo->filter($request);

        // $users = User::where('status', Status::ACTIVE)->where('name', 'like', '%' . $request->search . '%')->orderby('name', 'asc')->select('id', 'name')->limit(10)->get();

        if ($users->isEmpty()) {
            return response()->json(['message' => 'No user Found'], 404);
        }

        $users = $users->map(fn($user) =>  ["id" => $user->id, "text" => $user->name]);

        return response()->json($users);
    }


    // ajax call 
    public function getUsersByHub(Request $request)
    {
        if (!request()->ajax()) {
            return response()->json(['error' => ___('alert.invalid_request')], 422);
        }

        if ($request->hub_id == null) {
            return response()->json(['error' => 'Hub id can not be null.'], 422);
        }

        $users = $this->repo->getWithFilter(['hub_id' => $request->hub_id], ['id', 'name']);
        if ($users) {
            return response()->json(['users' => $users]);
        }

        return response()->json(['error' => 'No user found.'], 422);
    }

    public function cookieConsent(Request $request)
    {
        $request->validate(['cookie_consent' => 'required|boolean',]);

        $result = $this->repo->cookieConsent($request);

        return response()->json($result, $result['status_code']);
    }
}
