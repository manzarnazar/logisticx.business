<?php

namespace App\Http\Controllers\Backend;

use App\Enums\Status;
use App\Enums\UserType;
use Illuminate\Http\Request;
use App\Models\Backend\Merchant;
use App\Models\Backend\HubInCharge;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use App\Http\Requests\HubInCharge\HubInChargeRequest;
use App\Repositories\HubInCharge\HubInChargeInterface;
use Psy\CodeCleaner\ReturnTypePass;

class HubInChargeController extends Controller
{
    protected $repo;
    public function __construct(HubInChargeInterface $repo)
    {
        $this->repo = $repo;
    }

    public function index($hubID)
    {
        $hubInCharges = $this->repo->all($hubID);
        $hub          = $this->repo->hub($hubID);
        return view('backend.hubincharge.index', compact('hubInCharges', 'hub'));
    }

    public function create($hubID)
    {
        $hub    = $this->repo->hub($hubID);
        $users  = $this->repo->users();
        return view('backend.hubincharge.create', compact('hub', 'users'));
    }

    public function store(HubInChargeRequest $request, $hubID)
    {
        $result = $this->repo->store($hubID, $request);
        if ($result['status']) {
            return redirect()->route('hub-incharge.index', $hubID)->with('success', $result['message']);
        }
        return back()->with('danger', $result['message']);
    }

    public function edit($hubID, $id)
    {
        $hub        = $this->repo->hub($hubID);
        $users      = $this->repo->users();
        $inCharge   = $this->repo->get($hubID, $id);
        return view('backend.hubincharge.edit', compact('inCharge', 'hub', 'users'));
    }

    public function update($hubID, $id, HubInChargeRequest $request)
    {
        $result = $this->repo->update($hubID, $id, $request);
        if ($result['status']) {
            return redirect()->route('hub-incharge.index', $hubID)->with('success', $result['message']);
        }
        return back()->with('danger', $result['message']);
    }

    public function destroy($hubID, $id)
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

    public function assigned($hubID, $id)
    {
        $inCharge                   = $this->repo->get($hubID, $id);
        $queryArray['user_id']      = $inCharge->user_id;
        $queryArray['status']       = Status::ACTIVE;
        $hubInCharge                = HubInCharge::where($queryArray)->where('id', '!=', $id)->first();

        if (!blank($hubInCharge)) {
            return redirect()->back()->with('danger', ___('validation.attributes.user_assigned'));
        }
        $queryHubArray['user_id']      = $inCharge->user_id;
        $queryHubArray['hub_id']       = $hubID;
        $userHubUnique = HubInCharge::where($queryHubArray)->where('id', '!=', $id)->first();

        if (!blank($userHubUnique)) {
            return redirect()->back()->with('danger', ___('validation.attributes.user_exists'));
        }

        $result = $this->repo->assignedHub($hubID, $inCharge);
        if ($result['status']) {
            return redirect()->route('hub-incharge.index', $hubID)->with('success', $result['message']);
        }
        return back()->with('danger', $result['message']);
    }


    public function hubInchargeSearch(Request $request)
    {
        if ($request->search === null || $request->search === '') {
            return response()->json([]);
        }

        $search = $request->search;

        $users = HubInCharge::with(['user' => function ($query) use ($search) {
            $query->select('id', 'name');
            $query->where('user_type', UserType::INCHARGE);
        }])
            ->where('status', Status::ACTIVE)
            ->where('hub_id', $request->hub_id)
            ->whereHas('user', function ($query) use ($search) {
                $query->where('name', 'like', '%' . $search . '%');
            })
            ->get();

        if ($users != null) {
            $response = [];

            foreach ($users as $user) {

                // $response[] = $user;

                $response[] = array(
                    'id'   => $user->id,
                    'text' => $user->user->name,
                );
            }

            return response()->json($response);
        }

        return response()->json('No hub charge exists');
    }
}
