<?php

namespace App\Http\Controllers\Backend\Setting;

use App\Http\Controllers\Controller;
use App\Http\Requests\Setting\PickupSlotStoreRequest;
use App\Http\Requests\Setting\PickupSlotUpdateRequest;
use App\Repositories\PickupSlot\PickupSlotInterface;

class PickupSlotController extends Controller
{
    private $repo;

    public function __construct(PickupSlotInterface $repo)
    {
        $this->repo = $repo;
    }

    public function index()
    {
        $pickups = $this->repo->all(paginate: settings('paginate_value'));
        return view('backend.setting.pickup.index', compact('pickups'));
    }

    public function create()
    {
        return view('backend.setting.pickup.create');
    }

    public function store(PickupSlotStoreRequest $request)
    {
        $result = $this->repo->store($request);
        if ($result['status']) {
            return redirect()->route('pickup.index')->with('success', $result['message']);
        }
        return back()->with('danger', $result['message']);
    }

    public function edit($id)
    {
        $pickup = $this->repo->get($id);
        return view('backend.setting.pickup.edit', compact('pickup'));
    }

    public function update(PickupSlotUpdateRequest $request)
    {
        $result = $this->repo->update($request);
        if ($result['status']) {
            return redirect()->route('pickup.index')->with('success', $result['message']);
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
}
