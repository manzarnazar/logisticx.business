<?php

namespace Database\Seeders;

use App\Enums\UserType;
use App\Models\Backend\DeliveryMan;
use App\Models\Backend\Hub;
use App\Models\Backend\Parcel;
use App\Models\User;
use App\Repositories\Parcel\ParcelInterface;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Auth;
use stdClass;

class EventSeeder extends Seeder
{
    protected $repo;

    public function __construct(ParcelInterface $repo)
    {
        $firstUser = User::where('user_type', UserType::ADMIN)->first();
        Auth::login($firstUser);

        $this->repo                 = $repo;
    }

    public function run(): void
    {
        $ridersIds  = DeliveryMan::whereIn('id', [1])->pluck('id');

        $parcels = Parcel::orderByDesc('id')->get();

        foreach ($parcels as $key => $parcel) {

            if ($key > 4) {
                $this->assignPickup($parcel->id, $ridersIds->random());
            }

            if ($key == 5) {
                $this->assignPickupReschedule($parcel->id, $ridersIds->random());
            }

            if ($key > 23) {
                $this->receivedWareHouse($parcel->id, $parcel->hub_id);
            }

            if ($key > 24  &&  $key < 27) {
                $hub_id = Hub::whereNot('id', $parcel->hub_id)->first()->id;
                $this->transferHub($parcel->id, $hub_id);
            }

            if ($key == 26) {
                $this->receivedByHub($parcel->id);
            }

            if ($key > 26) {
                $this->assignDelivery($parcel->id, $ridersIds->random());
            }

            if ($key == 27) {
                $this->parcelPartialDelivered($parcel->id);
            }

            if ($key > 28) {
                $this->parcelDelivered($parcel->id);
            }
        }

        Auth::logout();
    }


    private function assignPickup($parcel_id, $hero_id): void
    {
        $request = new stdClass();
        $request->parcel_id = $parcel_id;
        $request->delivery_man_id = $hero_id;
        $request->note =  fake()->sentence();
        $this->repo->pickupManAssign($request);
    }

    private function assignPickupReschedule($parcel_id, $hero_id): void
    {
        $request                    = new stdClass();
        $request->parcel_id         = $parcel_id;
        $request->date              = Carbon::now()->addDays(2)->toDateString();
        $request->delivery_man_id   = $hero_id;
        $request->note              =  fake()->sentence();

        $this->repo->PickupReSchedule($request);
    }

    private function receivedWareHouse($parcel_id, $hub_id): void
    {
        $request = new stdClass();
        $request->parcel_id = $parcel_id;
        $request->hub_id = $hub_id;
        $request->note =  fake()->sentence();
        $this->repo->receivedWarehouse($request);
    }

    private function transferHub($parcel_id, $hub_id): void
    {
        $request = new stdClass();
        $request->parcel_id = $parcel_id;
        $request->hub_id = $hub_id;
        $request->delivery_man_id = 1;
        $request->note =  fake()->sentence();
        $this->repo->transferToHub($request);
    }

    private function receivedByHub($parcel_id): void
    {
        $request            = new stdClass();
        $request->parcel_id = $parcel_id;
        $request->note      = fake()->sentence();
        $this->repo->transferToHub($request);
    }

    private function assignDelivery($parcel_id, $hero_id): void
    {
        $request = new stdClass();
        $request->parcel_id = $parcel_id;
        $request->delivery_man_id = $hero_id;
        $request->note =  fake()->sentence();
        $this->repo->deliverymanAssign($request);
    }

    private function parcelDelivered($parcel_id): void
    {
        $request = new stdClass();
        $request->parcel_id = $parcel_id;
        $request->note =  fake()->sentence();
        $this->repo->parcelDelivered($request);
    }

    private function parcelPartialDelivered($parcel_id): void
    {
        $request                    = new stdClass();
        $request->parcel_id         = $parcel_id;
        $request->quantity          = 1;
        $request->cash_collection   = 100;
        $request->note              = fake()->sentence();
        $this->repo->parcelPartialDelivered($request);
    }
}
