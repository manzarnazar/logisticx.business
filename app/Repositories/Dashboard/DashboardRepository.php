<?php

namespace App\Repositories\Dashboard;

use App\Enums\UserType;
use App\Models\Backend\Expense;
use App\Models\Backend\Parcel;
use App\Repositories\Dashboard\DashboardInterface;
use Carbon\Carbon;

class DashboardRepository implements DashboardInterface
{
    protected $parcel;

    public function __construct(Parcel $parcel)
    {
        $this->parcel        = $parcel;
    }

    public function parcels(string $status = null, int $take = null, string $orderBy = 'updated_at', string $sortBy = 'desc')
    {
        $query = $this->parcel::query();

        if ($status) {
            $query->where('status', $status);
        }

        $query->with('parcelTransaction', 'merchant', 'parcelEvent');

        if (auth()->user()->user_type == UserType::MERCHANT) {
            $query->where('merchant_id', auth()->user()->merchant->id);
        }

        if ((auth()->user()->user_type == UserType::INCHARGE || auth()->user()->user_type == UserType::HUB) && auth()->user()->hub_id) {
            $query->whereHas('parcelEvent', fn ($query) => $query->where('hub_id', auth()->user()->hub_id));
        }

        if (auth()->user()->user_type == UserType::DELIVERYMAN) {
            $hero_id = auth()->user()->deliveryman->id;
            $query->whereHas('parcelEvent', fn ($query) => $query->where('delivery_man_id', $hero_id)->orWhere('pickup_man_id', $hero_id));
        }

        $query->orderBy($orderBy, $sortBy);

        if ($take !== null) {
            $query->take($take);
        }

        return $query->get();
    }
}
