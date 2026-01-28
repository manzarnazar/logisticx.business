<?php

namespace App\Http\Controllers\Backend\Payroll;

use App\Enums\UserType;
use App\Http\Controllers\Controller;
use App\Http\Requests\Payroll\AutoGenerateRequest;
use App\Http\Requests\Salary\StoreRequest;
use App\Models\Subscribe;
use App\Models\User;
use App\Repositories\Account\AccountInterface;
use App\Repositories\Salary\SalaryInterface;
use Illuminate\Http\Request;

class SalaryController extends Controller
{
    protected $repo, $accounts;

    public function __construct(SalaryInterface $repo, AccountInterface $accounts)
    {
        $this->repo      = $repo;
        $this->accounts  = $accounts;
    }

    public function index()
    {
        $salaries   = $this->repo->all(paginate: settings('paginate_value'));
        return view('backend.salary.index', compact('salaries'));
    }

    public function create()
    {
        return view('backend.salary.create');
    }

    public function store(StoreRequest $request)
    {
        $result = $this->repo->store($request);
        if ($result['status']) {
            return redirect()->route('salary.index')->with('success', $result['message']);
        }

        return back()->with('danger', $result['message'])->withInput();
    }

    public function storeAutoGenerate(AutoGenerateRequest $request)
    {
        $result = $this->repo->autogenerate($request);
        if ($result['status']) {
            return redirect()->route('salary.index')->with('success', $result['message']);
        }
        return back()->with('danger', $result['message']);
    }

    public function edit($id)
    {
        $salary   = $this->repo->get($id);
        return view('backend.salary.edit', compact('salary'));
    }

    public function update(StoreRequest $request)
    {
        $result = $this->repo->update($request);
        if ($result['status']) {
            return redirect()->route('salary.index')->with('success', $result['message']);
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

    public function payInitialize($id)
    {
        // $accounts    = $this->accounts->all();
        $salary    = $this->repo->get($id);
        return view('backend.salary.pay', compact('salary'));
    }

    public function payProcess(Request $request)
    {
        $request->validate([
            'salary_generate_id' => 'required|exists:salary_generates,id',
            'account_id'        => 'required|exists:accounts,id',
            'note'              => 'nullable|string|max:255',
        ]);

        $result = $this->repo->pay($request);
        if ($result['status']) {
            return redirect()->route('salary.index')->with('success', $result['message']);
        }
        return back()->with('danger', $result['message']);
    }

    public function reverseSalaryPay(Request $request)
    {
        $request->validate([
            'id'                => 'required|exists:salary_generates,id',
            'note'              => 'nullable|string|max:255',
        ]);

        $result = $this->repo->reverseSalaryPay($request);
        if ($result['status']) {
            return redirect()->route('salary.index')->with('success', $result['message']);
        }
        return back()->with('danger', $result['message']);
    }

    public function payslip($id)
    {
        $salary      = $this->repo->get($id);
        return view('backend.salary.pay_slip', compact('salary'));
    }

    public function Users(Request $request)
    {
        if ($request->ajax()) :
            $users = User::where('name', 'like', '%' . $request->search . '%')->whereNot('user_type', UserType::MERCHANT)->paginate(settings('paginate_value'));
            $response = [];
            foreach ($users as  $user) {
                $response[] = [
                    'id'  => $user->id,
                    'text' => $user->name
                ];
            }
            return response()->json($response);
        endif;
    }

    public function getBasicSalary(Request $request)
    {
        if (!request()->ajax()) {
            return response()->json(['message' => ___('alert.invalid_request')], 422);
        }

        $user = User::find($request->input('user_id'));
        if ($user) {
            return response()->json(['basic_salary' => $user->salary]);
        }

        return response()->json(['message' => 'No User found.'], 404);
    }

    public function salaryFilter(Request $request)
    {
        $salaries  = $this->repo->salaryFilter($request);
        return view('backend.salary.index', compact('salaries', 'request'));
    }


    // =================================================

    public function subscribe()
    {
        $subscribes   = Subscribe::orderBy('id', 'desc')->paginate(settings('paginate_value'));
        return view('backend.subscribe', compact('subscribes'));
    }
}
