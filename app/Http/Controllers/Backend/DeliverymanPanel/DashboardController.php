<?php

namespace App\Http\Controllers\Backend\DeliverymanPanel;

use App\Enums\ParcelStatus;
use Illuminate\Http\Request;
use App\Models\Backend\Parcel;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Repositories\Hub\HubInterface;
use Illuminate\Support\Facades\Validator;
use App\Repositories\Parcel\ParcelInterface;
use App\Repositories\DeliveryMan\DeliveryManInterface;

class DashboardController extends Controller
{
    protected $parcelRepo, $deliveryman, $hub;
    public function __construct(
        ParcelInterface $parcelRepo,
        DeliveryManInterface $deliveryman,
        HubInterface $hub,
    ) {
        $this->parcelRepo = $parcelRepo;

        $this->hub                  = $hub;
    }

    public function parcelList(Request $request)
    {

        $hubs           = $this->hub->all();
        $parcels =  Parcel::with('parcelEvent')->where(function ($query) use ($request) {

            $query->whereHas('parcelEvent', function ($queryParcelEvent) {
                $queryParcelEvent->where(['delivery_man_id' => Auth::user()->deliveryman->id]);
                $queryParcelEvent->orWhere(['pickup_man_id' => Auth::user()->deliveryman->id]);
            });

            if ($request->delivered) :
                $query->whereNotIn('status', [
                    ParcelStatus::PICKUP_ASSIGN,
                    ParcelStatus::PICKUP_RE_SCHEDULE,
                    ParcelStatus::DELIVERY_MAN_ASSIGN,
                    ParcelStatus::DELIVERY_RE_SCHEDULE,
                    ParcelStatus::RETURN_ASSIGN_TO_MERCHANT,
                    ParcelStatus::RETURN_MERCHANT_RE_SCHEDULE,
                    ParcelStatus::PENDING
                ]);
            else :
                $query->whereIn('status', [
                    ParcelStatus::PICKUP_ASSIGN,
                    ParcelStatus::PICKUP_RE_SCHEDULE,
                    ParcelStatus::DELIVERY_MAN_ASSIGN,
                    ParcelStatus::DELIVERY_RE_SCHEDULE,
                    ParcelStatus::RETURN_ASSIGN_TO_MERCHANT,
                    ParcelStatus::RETURN_MERCHANT_RE_SCHEDULE,
                ]);
            endif;
        })->orderByDesc('id')->paginate(settings('paginate_value'));
        if ($request->delivered) :
            return view('backend.deliveryman_panel.delivered_parcels', compact('parcels', 'request', 'hubs'));
        endif;
        return view('backend.deliveryman_panel.pending_parcels', compact('parcels', 'request', 'hubs'));
    }




    public function receivedWarehouse(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'hub_id' => 'required'
        ]);

        if ($validator->fails()) :
            return redirect()->back()->with('danger', ___('alert.something_went_wrong'));
        endif;
        $result = $this->parcelRepo->receivedWarehouse($request);
        if ($result['status']) {
            return redirect()->back()->with('success', $result['message']);
        }
        return redirect()->back()->with('danger', $result['message']);
    }

    public function delivered(Request $request)
    {
        $result = $this->parcelRepo->parcelDelivered($request->parcel_id, $request);
        if ($result['status']) {
            return redirect()->back()->with('success', $result['message']);
        }
        return redirect()->back()->with('danger', $result['message']);
    }
    public function partialDelivered(Request $request)
    {

        $validator = Validator::make($request->all(), ['cash_collection' => 'required']);
        if ($validator->fails()) {
            return redirect()->back()->with('danger', ___('alert.something_went_wrong'));
        }
        $result = $this->parcelRepo->parcelPartialDelivered($request->parcel_id, $request);
        if ($result['status']) {
            return redirect()->back()->with('success', $result['message']);
        }
        return redirect()->back()->with('danger', $result['message']);
    }


    public function returnToCourier(Request $request)
    {
        $result = $this->parcelRepo->returnToCourier($request->parcel_id, $request);
        if ($result['status']) {
            return redirect()->back()->with('success', $result['message']);
        }
        return redirect()->back()->with('danger', $result['message']);
    }
}
