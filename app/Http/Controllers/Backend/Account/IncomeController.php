<?php

namespace App\Http\Controllers\Backend\Account;

use App\Enums\AccountHeads;
use App\Models\User;
use App\Http\Controllers\Controller;
use App\Repositories\Hub\HubInterface;
use App\Repositories\Income\IncomeInterface;
use App\Repositories\Parcel\ParcelInterface;
use App\Repositories\Account\AccountInterface;
use App\Http\Requests\Income\StoreIncomeRequest;
use App\Repositories\Merchant\MerchantInterface;
use App\Models\Backend\IncomeParcelPivot;
use App\Models\Backend\Parcel;
use App\Repositories\AccountHeads\AccountHeadsInterface;
use App\Repositories\DeliveryMan\DeliveryManInterface;
use Illuminate\Http\Request;

class IncomeController extends Controller
{
    protected $repo, $account, $hub, $parcel, $merchant, $deliveryman, $accountHeadsRepo;

    public function __construct(
        IncomeInterface $repo,
        ParcelInterface $parcel,
        MerchantInterface $merchant,
        DeliveryManInterface $deliveryman,
        AccountInterface $account,
        HubInterface $hub,
        AccountHeadsInterface $accountHeadsRepo,
    ) {
        $this->repo                 = $repo;
        $this->parcel               = $parcel;
        $this->merchant             = $merchant;
        $this->deliveryman          = $deliveryman;
        $this->account              = $account;
        $this->hub                  = $hub;
        $this->accountHeadsRepo     = $accountHeadsRepo;
    }


    public function index(Request $request)
    {
        $incomes        = $this->repo->all();
        $accounts       = $this->account->all();
        $accountHeads   = $this->accountHeadsRepo->getActive(head: AccountHeads::INCOME);
        return view('backend.income.index', compact('incomes', 'accounts', 'request', 'accountHeads'));
    }

    public function filter(Request $request)
    {
        $incomes        = $this->repo->filter($request);
        $accounts       = $this->account->all();
        $accountHeads   = $this->accountHeadsRepo->getActive();
        return view('backend.income.index', compact('incomes', 'accounts', 'request', 'accountHeads'));
    }

    public function create()
    {
        $accountHeads   = $this->accountHeadsRepo->getActive(head: AccountHeads::INCOME);
        $hubs           = hasPermission('income_hub_read_all') ? $this->hub->all() : [];
        $accounts       = $this->account->all();
        $hubAccounts    = $this->account->getHubAccounts();

        return view('backend.income.create', compact('accountHeads', 'hubs', 'hubs', 'accounts'));
    }

    public function store(StoreIncomeRequest $request)
    {
        $result = $this->repo->store($request);

        if ($request->wantsJson()) {
            return response()->json($result, $result['data']['status_code']);
        }

        if ($result['status']) {
            return redirect()->route('income.index')->with('success', $result['message']);
        }

        return back()->with('danger', $result['message']);
    }

    public function edit($id)
    {
        $income          = $this->repo->get($id);
        $accountHeads    = $this->accountHeadsRepo->getActive(head: AccountHeads::INCOME);
        $userAccounts    = $this->account->userAccount($income->user_id);
        $hubAccounts     = $this->account->getHubAccounts($income->hub_id);
        $hubs            = hasPermission('income_hub_read_all') ? $this->hub->all() : [];
        $pivotParcelsIds = IncomeParcelPivot::where('income_id', $income->id)->pluck('parcel_id');
        $parcels         = Parcel::with('parcelTransaction:parcel_id,cash_collection,total_charge')->whereIn('id', $pivotParcelsIds)->get(['id', 'tracking_id', 'delivery_date', 'status',]);

        return view('backend.income.edit', compact('income', 'accountHeads', 'hubs', 'userAccounts', 'hubAccounts', 'parcels'));
    }

    public function update(StoreIncomeRequest $request)
    {
        $result = $this->repo->update($request);

        if ($request->wantsJson()) {
            return response()->json($result, $result['data']['status_code']);
        }

        if ($result['status']) {
            return redirect()->route('income.index')->with('success', $result['message']);
        }

        return back()->with('danger', $result['message']);
    }

    public function destroy($id)
    {
        $result = $this->repo->delete($id);
        if ($result['status']) :
            $success[0] =  $result['message'];
            $success[1] = 'success';
            $success[2] = ___('delete.deleted');
            return response()->json($success);
        else :
            $success[0] =  $result['message'];
            $success[1] = 'error';
            $success[2] = ___('delete.oops');
            return response()->json($success);
        endif;
    }


    public function view($id)
    {
        $income         = $this->repo->get($id);
        return view('backend.income.view', compact('income'));
    }

    // ajax  calls
    public function IncomeUsers(Request $request)
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

    public function searchAccount($id, Request $request)
    {

        return $this->account->get($request);
    }

    public function balanceCheck(Request $request)
    {

        $marchenHubDeliveryman = $this->repo->hubCheck($request);
        $users = $this->repo->hubUsers($marchenHubDeliveryman->id);

        return ['mhd' => $marchenHubDeliveryman, 'users' => $users];
    }

    public function hubUserAccounts(Request $request)
    {
        return $this->repo->hubUserAccounts($request);
    }
}
