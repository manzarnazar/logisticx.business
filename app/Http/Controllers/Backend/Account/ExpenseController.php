<?php

namespace App\Http\Controllers\Backend\Account;

use App\Enums\AccountHeads;
use App\Enums\FixedAccountHeads;
use App\Enums\Status;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Expense\StoreExpenseRequest;
use App\Models\Backend\AccountHead;
use App\Repositories\Expense\ExpenseInterface;
use App\Repositories\Parcel\ParcelInterface;
use App\Repositories\Merchant\MerchantInterface;
use App\Repositories\DeliveryMan\DeliveryManInterface;
use App\Repositories\Account\AccountInterface;
use App\Repositories\AccountHeads\AccountHeadsInterface;
use App\Models\User;
use App\Repositories\Hub\HubInterface;

class ExpenseController extends Controller
{
    protected $repo, $parcel, $merchant, $deliveryman, $account, $accountHeadsRepo, $hubRepo;

    public function __construct(
        ExpenseInterface $repo,
        ParcelInterface $parcel,
        MerchantInterface $merchant,
        DeliveryManInterface $deliveryman,
        AccountInterface $account,
        AccountHeadsInterface $accountHeadsRepo,
        HubInterface $hubRepo,
    ) {
        $this->repo        = $repo;
        $this->parcel      = $parcel;
        $this->merchant    = $merchant;
        $this->deliveryman = $deliveryman;
        $this->account     = $account;
        $this->accountHeadsRepo = $accountHeadsRepo;
        $this->hubRepo = $hubRepo;
    }

    public function index(Request $request)
    {
        $expenses       = $this->repo->all();
        $accounts       = $this->account->all();
        $accountHeads   = $this->accountHeadsRepo->getActive(head: AccountHeads::EXPENSE);

        return view('backend.expense.index', compact('expenses', 'request', 'accounts', 'accountHeads'));
    }
    public function filter(Request $request)
    {
        $expenses       = $this->repo->filter($request);
        $accounts       = $this->account->all();
        $accountHeads   = $this->accountHeadsRepo->getActive(head: AccountHeads::EXPENSE);
        return view('backend.expense.index', compact('expenses', 'request', 'accounts', 'accountHeads'));
    }

    public function create()
    {
        $skipHeads     = [FixedAccountHeads::PayToHub, FixedAccountHeads::PaidToAdmin, FixedAccountHeads::PaidToMerchant];
        $account_heads = $this->accountHeadsRepo->getActive(head: AccountHeads::EXPENSE);
        $hubs          = $this->hubRepo->all();
        return view('backend.expense.create', compact('account_heads', 'hubs'));
    }

    public function searchAccount($id)
    {
        return $this->account->get($id);
    }

    public function store(StoreExpenseRequest $request)
    {
        $result = $this->repo->store($request);

        if ($request->wantsJson()) {
            return response()->json($result, $result['data']['status_code']);
        }

        if ($result['status']) {
            return redirect()->route('expense.index')->with('success', $result['message']);
        }
        return back()->with('danger', $result['message']);
    }

    public function edit($id)
    {
        $expense         = $this->repo->get($id);
        $account_heads   = $this->accountHeadsRepo->getActive(head: AccountHeads::EXPENSE);
        $hubs            = $this->hubRepo->all();
        return view('backend.expense.edit', compact('expense', 'account_heads', 'hubs'));
    }

    public function update(StoreExpenseRequest $request)
    {
        $result = $this->repo->update($request);

        if ($request->wantsJson()) {
            return response()->json($result, $result['data']['status_code']);
        }

        if ($result['status']) {
            return redirect()->route('expense.index')->with('success', $result['message']);
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

    public function view($id)
    {
        $expense         = $this->repo->get($id);
        return view('backend.expense.view', compact('expense'));
    }


    public function ExpenseUsers(Request $request)
    {
        if ($request->ajax()) :
            $users = User::where('name', 'like', '%' . $request->search . '%')->paginate(settings('paginate_value'));
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
}
