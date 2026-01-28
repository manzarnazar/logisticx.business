<?php

namespace Modules\Attendance\Http\Controllers;

use App\Enums\Status;
use App\Enums\UserType;
use App\Models\User;
use App\Repositories\Department\DepartmentInterface;
use App\Repositories\Designation\DesignationInterface;
use App\Repositories\Role\RoleInterface;
use App\Repositories\User\UserInterface;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Contracts\Support\Renderable;
use Modules\Attendance\Http\Requests\AttendanceStoreRequest;
use Modules\Attendance\Http\Requests\AttendanceUpdateRequest;
use Modules\Attendance\Repositories\Attendance\AttendanceInterface;

class AttendanceController extends Controller
{
    private $repo, $designationRepo, $departmentRepo, $userRepo;

    public function __construct(
        AttendanceInterface $repo,
        DesignationInterface $designationRepo,
        DepartmentInterface $departmentRepo,
        UserInterface $userRepo
    ) {
        $this->repo = $repo;
        $this->designationRepo = $designationRepo;
        $this->departmentRepo = $departmentRepo;
        $this->userRepo = $userRepo;
    }

    public function index()
    {
        $attendances =   $this->repo->all(paginate: settings('paginate_value'));
        return view('attendance::attendance.index', compact('attendances'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        $data['departments'] =   $this->departmentRepo->activeDepartments();
        $data['designations'] =   $this->designationRepo->activeDesignations();
        return view('attendance::attendance.create',  $data);
    }

    public function store(AttendanceStoreRequest $request)
    {
        $result = $this->repo->store($request);
        if ($result['status']) {
            return redirect()->route('attendance.index')->with('success', $result['message']);
        }
        return back()->with('danger', $result['message'])->withInput();
    }

    public function edit($id)
    {
        $attendance = $this->repo->get($id);
        return view('attendance::attendance.edit', compact('attendance'));
    }

    public function update(AttendanceUpdateRequest $request)
    {
        $result = $this->repo->update($request);
        if ($result['status']) {
            return redirect()->route('attendance.index')->with('success', $result['message']);
        }
        return redirect()->back()->withInput()->with('danger', $result['message']);
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


    public function getUsers(Request $request)
    {
        if (!request()->ajax()) {
            return response()->json(['error' => ___('alert.invalid_request')], 422);
        }

        $where = [];

        if ($request->input('department_id')) {
            $where['department_id'] = $request->input('department_id');
        }
        if ($request->input('designation_id')) {
            $where['designation_id'] = $request->input('designation_id');
        }
        if ($request->input('user_id')) {
            $where['id'] = $request->input('user_id');
        }

        $users  = $this->userRepo->getWithFilter($where);

        if (count($users) == 0) {
            return response()->json(['error' => 'No User found.'], 404);
        }

        $date = $request->input('date');
        $view = view('attendance::attendance.users', compact('users', 'date'))->render();
        return response()->json($view);

        // return view('attendance::attendance.users', compact('users', 'date'));
    }


    public function getUser(Request $request)
    {
        if (!request()->ajax()) {
            return response()->json(['error' => ___('alert.invalid_request')], 422);
        }

        if ($request->search == null) {
            return response()->json(['error' => 'Search parameter can not be null.'], 422);
        }

        $users = User::where('status', Status::ACTIVE)->whereNot('user_type', UserType::MERCHANT)->where('name', 'like', "%$request->search%")->orderby('name', 'asc')->select('id', 'name')->limit(10)->get();

        if ($users->isEmpty()) {
            return response()->json(['message' => 'No user Found'], 404);
        }

        $users = $users->map(fn ($user) =>  ["id" => $user->id, "text" => $user->name]);

        return response()->json($users);
    }
}
