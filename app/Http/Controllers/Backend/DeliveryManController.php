<?php

namespace App\Http\Controllers\Backend;

use App\Enums\Status;
use App\Enums\UserType;
use App\Http\Controllers\Controller;
use App\Repositories\DeliveryMan\DeliveryManInterface;
use Illuminate\Http\Request;
use App\Http\Requests\DeliveryMan\DeliveryManRequest;
use App\Repositories\Coverage\CoverageInterface;
use App\Repositories\PickupSlot\PickupSlotInterface;

class DeliveryManController extends Controller
{
    protected $repo, $coverageRepo, $PickupSlotRepo;

    public function __construct(DeliveryManInterface $repo, CoverageInterface $coverageRepo, PickupSlotInterface $PickupSlotRepo)
    {
        $this->repo = $repo;
        $this->coverageRepo = $coverageRepo;
        $this->PickupSlotRepo = $PickupSlotRepo;
    }

    public function index(Request $request)
    {
        $deliveryMans = $this->repo->all(paginate: settings('paginate_value'));
        return view('backend.deliveryman.index', compact('deliveryMans'));
    }
    public function filter(Request $request)
    {
        $deliveryMans = $this->repo->filter($request);
        return view('backend.deliveryman.index', compact('deliveryMans'));
    }

    public function create()
    {
        $hubs       = $this->repo->hubs();
        $coverages  = $this->coverageRepo->getWithActiveChild();
        $pickupSlots = $this->PickupSlotRepo->all(Status::ACTIVE);
        return view('backend.deliveryman.create', compact('hubs', 'coverages', 'pickupSlots'));
    }


    public function store(DeliveryManRequest $request)
    {

        $result = $this->repo->store($request);

        if ($result['status']) {
            return redirect()->route('deliveryman.index')->with('success', $result['message']);
        }
        return back()->with('danger', $result['message'])->withInput();
    }

    public function edit($id)
    {
        $hubs           = $this->repo->hubs();
        $deliveryman    = $this->repo->get($id);
        $coverages      = $this->coverageRepo->getWithActiveChild();
        $pickupSlots    = $this->PickupSlotRepo->all(Status::ACTIVE);

        return view('backend.deliveryman.edit', compact('deliveryman', 'hubs', 'coverages', 'pickupSlots'));
    }

    public function update(DeliveryManRequest $request)
    {
        $result = $this->repo->update($request->id, $request);

        if ($result['status']) {
            return redirect()->route('deliveryman.index')->with('success', $result['message']);
        }
        return back()->with('danger', $result['message'])->withInput();
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



    // ajax calls

    public function searchDeliveryMan(Request $request)
    {
        if (!request()->ajax()) {
            return response()->json(['message' => ___('alert.invalid_request')], 422);
        }

        $heros = $this->repo->searchHero($request);

        if ($heros->isEmpty()) {
            return response()->json(['message' => 'No Delivery Hero Found'], 422);
        }

        if ($request->input('select2')) {
            $heros = $heros->map(fn ($hero) => ['id' => $hero->id, 'text' => $hero->user->name,])->toArray();
            usort($heros, fn ($a, $b) => strcmp($a['text'], $b['text'])); // Sort the array by the 'text' field
        }

        return response()->json($heros);
    }
}
