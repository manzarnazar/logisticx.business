<?php

namespace App\Http\Controllers\Backend\Account;

use App\Enums\Status;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\Bank\BankInterface;
use App\Http\Requests\Account\StoreRequest;
use App\Http\Requests\Account\UpdateRequest;
use App\Models\Backend\Account;
use App\Models\User;
use App\Repositories\Account\AccountInterface;
use App\Repositories\Hub\HubInterface;

class AccountController extends Controller
{
    protected $repo, $bankRepo, $hubRepo;

    public function __construct(AccountInterface $repo, BankInterface $bankRepo, HubInterface $hubRepo)
    {
        $this->repo     = $repo;
        $this->bankRepo = $bankRepo;
        $this->hubRepo  = $hubRepo;
    }

    public function index(Request $request)
    {
        $accounts = $this->repo->all();
        $banks    = $this->bankRepo->all(Status::ACTIVE);
        return view('backend.account.index', compact('accounts', 'banks', 'request'));
    }

    public function filter(Request $request)
    {
        $accounts = $this->repo->filter($request);
        $banks = $this->bankRepo->all(Status::ACTIVE);
        return view('backend.account.index', compact('accounts', 'banks', 'request'));
    }

    public function create()
    {
        $hubs  = $this->hubRepo->all(status: Status::ACTIVE);
        $banks = $this->bankRepo->all(status: Status::ACTIVE);
        return view('backend.account.create', compact('hubs', 'banks'));
    }

    public function store(StoreRequest $request)
    {
        $result = $this->repo->store($request);
        if ($result['status']) {
            return redirect()->route('accounts.index')->with('success', $result['message']);
        }
        return back()->with('danger', $result['message']);
    }

    public function edit($id)
    {
        $account    = $this->repo->get($id);
        $hubs       = $this->hubRepo->all(status: Status::ACTIVE);
        $banks      = $this->bankRepo->all(Status::ACTIVE);
        $user       = User::findOrFail($account->user_id);
        return view('backend.account.edit', compact('account', 'hubs', 'banks', 'user'));
    }

    public function update($id, UpdateRequest $request)
    {
        $result = $this->repo->update($id, $request);
        if ($result['status']) {
            return redirect()->route('accounts.index')->with('success', $result['message']);
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

    public function currentBalance(Request $data)
    {
        return $this->repo->currentBalance($data);
    }

    // ajax calls

    public function searchByHub(Request $request)
    {
        if (!request()->ajax()) {
            return response()->json(['message' => ___('alert.invalid_request')], 422);
        }

        if ($request->hub_id == null) {
            return response()->json(['message' => 'Hub_id can not be null.'], 422);
        }

        $accounts = $this->repo->getAccounts($request);

        if ($accounts->isEmpty()) {
            return response()->json(['message' => 'No account Found'], 404);
        }

        if ($request->input('select2')) {
            $accounts = $accounts->map(fn ($account) => $account->only(['id', 'text']));
        }

        return response()->json($accounts);
    }


    public function searchByUser(Request $request)
    {
        if (!request()->ajax()) {
            return response()->json(['error' => ___('alert.invalid_request')], 422);
        }

        if ($request->search == null && $request->user_id == null) {
            return response()->json(['error' => 'Required field can not be null.'], 422);
        }

        $accounts = $this->repo->getAccounts($request);

        if ($accounts->isEmpty()) {
            return response()->json(['message' => 'No account Found'], 404);
        }

        if ($request->input('select2')) {
            $accounts = $accounts->map(fn ($account) => $account->only(['id', 'text']));
        }

        return response()->json($accounts);
    }


    public function searchAccount(Request $request)
    {
        if (!request()->ajax()) {
            return response()->json(['message' => ___('alert.invalid_request')], 422);
        }

        $accounts =   $this->repo->getAccounts($request);

        if (empty($accounts)) {
            return response()->json(['message' => 'No account Found'], 404);
        }

        if ($request->input('select2')) {
            $accounts = $accounts->map(fn ($account) => $account->only(['id', 'text']));
        }

        return response()->json($accounts);
    }
}
