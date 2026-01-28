<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Enums\UserType;
use App\Enums\ParcelStatus;
use App\Enums\ApprovalStatus;
use App\Enums\CashCollectionStatus;
use App\Enums\PaymentStatus;
use App\Models\User;
use App\Enums\Status;
use App\Models\Backend\Account;
use App\Models\Backend\DeliveryHeroCommission;
use App\Models\Backend\DeliveryMan;
use App\Models\Backend\Hub;
use App\Models\Backend\Merchant;
use App\Models\Backend\Parcel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Repositories\Dashboard\DashboardInterface;
use App\Repositories\Parcel\ParcelInterface;
use App\Repositories\Reports\ReportsInterface;
use stdClass;

class DashboardController extends Controller
{
    protected $repo, $parcelRepo, $reportRepo;

    protected $data = [];

    public function __construct(DashboardInterface $repo, ParcelInterface $parcelRepo, ReportsInterface $reportRepo)
    {
        $this->repo         = $repo;
        $this->parcelRepo   = $parcelRepo;
        $this->reportRepo   = $reportRepo;
    }

    public function index(Request $request)
    {
        if (Auth::user()->user_type == UserType::ADMIN) {
            $this->adminDashboardData();
            return view('backend.dashboard', $this->data);
        }

        if (Auth::user()->user_type == UserType::INCHARGE) {
            $report = $this->reportRepo->hubReport($request);
            return view('backend.hub.dashboard', compact('report'));
        }

        if (Auth::user()->user_type == UserType::MERCHANT) {
            $this->merchantDashboardData();
            return view('backend.merchant_panel.dashboard', $this->data);
        }

        if (Auth::user()->user_type == UserType::DELIVERYMAN) {
            $this->heroDashboardData();
            return view('backend.deliveryman_panel.dashboard', $this->data);
        }
    }

    private function adminDashboardData()
    {
        $startDate  = Carbon::now()->subDays(7)->startOfDay();
        $endDate    = Carbon::now()->endOfDay();

        $parcels = $this->parcelRepo->all();

        $this->data['total_parcel']             = $parcels->count(); //total parcel
        $this->data['total_hero_assigned']      = $parcels->where('status', ParcelStatus::DELIVERY_MAN_ASSIGN)->count();
        $this->data['total_delivered']          = $parcels->where('status', ParcelStatus::DELIVERED)->count();
        $this->data['total_partial_delivered']  = $parcels->where('status', ParcelStatus::PARTIAL_DELIVERED)->count();

        $this->data['pendingParcels']           = $this->parcelRepo->all(status: ParcelStatus::PENDING,  paginate: settings('paginate_value'), orderBy: 'updated_at');
        $this->data['deliveredParcels']         = $this->parcelRepo->all(orderBy: 'updated_at')->whereIn('status', [ParcelStatus::DELIVERED, ParcelStatus::PARTIAL_DELIVERED])->take(10);

        $this->data['total_user']               = User::where('status', Status::ACTIVE)->count(); //total user
        $this->data['total_merchant']           = Merchant::where('status', Status::ACTIVE)->count(); //total merchant
        $this->data['total_delivery_man']       = DeliveryMan::where('status', Status::ACTIVE)->count(); //total delivery man
        $this->data['total_hubs']               = Hub::where('status', Status::ACTIVE)->count(); //total hubs
        $this->data['total_accounts']           = Account::where('status', Status::ACTIVE)->count(); //total accounts 

        $this->data['hero_paid_commission']     = DeliveryHeroCommission::where('payment_status', PaymentStatus::PAID)->whereBetween('updated_at', [$startDate, $endDate])->sum('amount');
        $this->data['hero_unpaid_commission']   = DeliveryHeroCommission::where('payment_status', PaymentStatus::UNPAID)->whereBetween('updated_at', [$startDate, $endDate])->sum('amount');

        $last7DayParcels                        = $parcels->whereBetween('updated_at', [$startDate, $endDate]);

        $this->data['charge_paid']              = $last7DayParcels->where('is_charge_paid', true)->sum(fn ($parcel) => $parcel->parcelTransaction->total_charge ?? 0);
        $this->data['charge_unpaid']            = $last7DayParcels->where('is_charge_paid', '!=', true)->sum(fn ($parcel) => $parcel->parcelTransaction->total_charge ?? 0);

        $this->data['cod_pending']              = $last7DayParcels->where('cash_collection_status', CashCollectionStatus::PENDING->value)->sum(fn ($parcel) => $parcel->parcelTransaction->cash_collection ?? 0);
        $this->data['cod_received_hub']         = $last7DayParcels->where('cash_collection_status', CashCollectionStatus::RECEIVED_BY_HUB->value)->sum(fn ($parcel) => $parcel->parcelTransaction->cash_collection ?? 0);
        $this->data['cod_received_admin']       = $last7DayParcels->where('cash_collection_status', CashCollectionStatus::RECEIVED_BY_ADMIN->value)->sum(fn ($parcel) => $parcel->parcelTransaction->cash_collection ?? 0);
        $this->data['cod_received_merchant']    = $last7DayParcels->where('cash_collection_status', CashCollectionStatus::PAID_TO_MERCHANT->value)->sum(fn ($parcel) => $parcel->parcelTransaction->cash_collection ?? 0);
        $this->data['merchant_current_payable'] = $last7DayParcels->where('cash_collection_status', '!=', CashCollectionStatus::PAID_TO_MERCHANT->value)->whereIn('status', [ParcelStatus::DELIVERED, ParcelStatus::PARTIAL_DELIVERED])->sum(fn ($parcel) => $parcel->parcelTransaction->current_payable ?? 0);

        if (config('app.app_demo')) {
            $this->data['hero_paid_commission'] = rand(500, 2000);
            $this->data['hero_unpaid_commission'] = rand(800, 2500);
            $this->data['cod_received_hub'] = rand(800, 2500);
            $this->data['cod_received_admin'] = rand(500, 2000);
            $this->data['cod_received_merchant'] = rand(800, 2500);
        }
    }

    private function merchantDashboardData()
    {
        $parcels    = $this->parcelRepo->all();

        $this->data['total_parcel']             = $parcels->count(); //total parcel
        $this->data['total_hero_assigned']      = $parcels->where('status', ParcelStatus::DELIVERY_MAN_ASSIGN)->count();
        $this->data['total_delivered']          = $parcels->where('status', ParcelStatus::DELIVERED)->count();
        $this->data['total_partial_delivered']  = $parcels->where('status', ParcelStatus::PARTIAL_DELIVERED)->count();
        $this->data['total_return']             = $parcels->where('status', ParcelStatus::RETURN_RECEIVED_BY_MERCHANT)->count();
        $this->data['total_charge_paid']        = $parcels->where('is_charge_paid', true)->sum(fn ($parcel) => $parcel->parcelTransaction->total_charge ?? 0);
        $this->data['total_vat']                = $parcels->sum(fn ($parcel) => $parcel->parcelTransaction->vat ?? 0);

        $this->data['pendingParcels']           = $this->parcelRepo->all(status: ParcelStatus::PENDING,  paginate: settings('paginate_value'), orderBy: 'updated_at');
        $this->data['deliveredParcels']         = $this->parcelRepo->all(status: ParcelStatus::DELIVERED,  paginate: settings('paginate_value'), orderBy: 'updated_at');

        $merchant                               = Merchant::with(['shops:id,merchant_id', 'payments:id,merchant_id,amount'])->select(['id'])->findOrFail(Auth::user()->merchant->id);

        $this->data['total_shop']               = $merchant->shops->count();
        $this->data['pending_payments']         = $merchant->payments->where('status', ApprovalStatus::PENDING)->sum('amount');
        $this->data['processed_payments']       = $merchant->payments->where('status', ApprovalStatus::PENDING)->sum('amount');

        $startDate                              = Carbon::now()->subDays(7)->startOfDay();
        $endDate                                = Carbon::now()->endOfDay();
        $last7DayParcels                        = $parcels->whereBetween('updated_at', [$startDate, $endDate]);

        $this->data['charge_paid']              = $last7DayParcels->where('is_charge_paid', true)->sum(fn ($parcel) => $parcel->parcelTransaction->total_charge ?? 0);
        $this->data['charge_unpaid']            = $last7DayParcels->where('is_charge_paid', '!=', true)->sum(fn ($parcel) => $parcel->parcelTransaction->total_charge ?? 0);

        $this->data['last7DayCod']              = $last7DayParcels->whereIn('status', [ParcelStatus::DELIVERED, ParcelStatus::PARTIAL_DELIVERED])->sum(fn ($parcel) => $parcel->parcelTransaction->cash_collection ?? 0);
        $this->data['last7DayCodReceived']      = $last7DayParcels->where('cash_collection_status', CashCollectionStatus::PAID_TO_MERCHANT->value)->sum(fn ($parcel) => $parcel->parcelTransaction->cash_collection ?? 0);

        $last7Day = new stdClass();

        $last7Day->chargePaid                   = $last7DayParcels->where('is_charge_paid', true)->sum(fn ($parcel) => $parcel->parcelTransaction->total_charge ?? 0);
        $last7Day->chargeUnpaid                 = $last7DayParcels->where('is_charge_paid', '!=', true)->sum(fn ($parcel) => $parcel->parcelTransaction->total_charge ?? 0);
        $last7Day->codPending                   = $last7DayParcels->whereIn('status', [ParcelStatus::DELIVERED, ParcelStatus::PARTIAL_DELIVERED])->sum(fn ($parcel) => $parcel->parcelTransaction->cash_collection ?? 0);
        $last7Day->codReceived                  = $last7DayParcels->where('cash_collection_status', CashCollectionStatus::PAID_TO_MERCHANT->value)->sum(fn ($parcel) => $parcel->parcelTransaction->cash_collection ?? 0);

        $last7Day->parcelPending                = $last7DayParcels->where('status', ParcelStatus::PENDING)->count();
        $last7Day->parcelDelivered              = $last7DayParcels->where('status', ParcelStatus::DELIVERED)->count();
        $last7Day->parcelReturned               = $last7DayParcels->where('status', ParcelStatus::RETURN_RECEIVED_BY_MERCHANT)->count();
        $last7Day->parcelInTransit              = $last7DayParcels->whereNotIn('status', [ParcelStatus::PENDING, ParcelStatus::DELIVERED, ParcelStatus::PARTIAL_DELIVERED])->count();

        $this->data['last7Day']                 =  $last7Day;
    }

    private function heroDashboardData()
    {
        $parcels        = $this->parcelRepo->all(orderBy: 'updated_at');
        $heroId         = auth()->user()->deliveryMan->id;
        $commissions    = DeliveryHeroCommission::where('delivery_hero_id', $heroId)->orWhere('pickup_hero_id', $heroId)->get();

        $assign         = [ParcelStatus::PICKUP_ASSIGN, ParcelStatus::PICKUP_RE_SCHEDULE, ParcelStatus::DELIVERY_MAN_ASSIGN, ParcelStatus::DELIVERY_RE_SCHEDULE,];

        $this->data['total_parcel']             = $parcels->count(); //total parcel
        $this->data['total_assigned']           = $parcels->whereIn('status', $assign)->count();
        $this->data['total_delivered']          = $parcels->where('status', ParcelStatus::DELIVERED)->count();
        $this->data['total_partial_delivered']  = $parcels->where('status', ParcelStatus::PARTIAL_DELIVERED)->count();
        $this->data['total_commission_paid']    = $commissions->where('payment_status', PaymentStatus::PAID)->sum('amount');
        $this->data['total_commission_unpaid']  = $commissions->where('payment_status', PaymentStatus::UNPAID)->sum('amount');

        $this->data['pendingParcels']           = $parcels->whereIn('status', $assign)->take(10);
        $this->data['deliveredParcels']         = $parcels->whereIn('status', [ParcelStatus::DELIVERED, ParcelStatus::PARTIAL_DELIVERED])->take(10);

        // last seven day data 
        $startDate      = Carbon::now()->subDays(7)->startOfDay();
        $endDate        = Carbon::now()->endOfDay();

        $parcels        = $parcels->whereBetween('updated_at', [$startDate, $endDate]);
        $commissions    = $commissions->whereBetween('updated_at', [$startDate, $endDate]);

        $last7Day = new stdClass();

        $last7Day->codPayToHub          = $parcels->where('cash_collection_status', CashCollectionStatus::RECEIVED_BY_HUB->value)->sum(fn ($parcel) => $parcel->parcelTransaction->cash_collection ?? 0);
        $last7Day->codPayableToHub      = $parcels->where('cash_collection_status', CashCollectionStatus::PENDING->value)->whereIn('status', [ParcelStatus::DELIVERED, ParcelStatus::PARTIAL_DELIVERED])->sum(fn ($parcel) => $parcel->parcelTransaction->cash_collection ?? 0);
        $last7Day->commission_paid      = $commissions->where('payment_status', PaymentStatus::PAID)->sum('amount');
        $last7Day->commission_unpaid    = $commissions->where('payment_status', PaymentStatus::UNPAID)->sum('amount');

        $this->data['last7Day']         =  $last7Day;
    }

    // ======================================================== 

    public function hero7DayCommission(Request $request)
    {
        if (config('app.app_demo')) {
            $startDate = Carbon::now()->subDays(6)->startOfDay(); // Start date is 7 days ago from today
            $endDate = Carbon::now()->endOfDay(); // End date is today

            $dummyData = [];

            // Generate dummy data for each day within the last 7 days
            for ($date = $startDate; $date->lte($endDate); $date->addDay()) {
                $paid = rand(10, 50); // Random paid commission amount
                $unpaid = rand(5, 30); // Random unpaid commission amount

                $dummyData[] = [
                    'day' => $date->format('D'),
                    'paid' => $paid,
                    'unpaid' => $unpaid,
                    'total' => $paid + $unpaid,
                ];
            }

            return response()->json($dummyData);
        }

        if (!request()->ajax()) {
            return response()->json(['message' => ___('alert.invalid_request')], 422);
        }

        if ($request->hero_id == null && Auth::user()->user_type != UserType::DELIVERYMAN) {
            return response()->json(['message' => 'Hero id can not be null.'], 422);
        }

        $hero_id = Auth::user()->user_type == UserType::DELIVERYMAN ? Auth::user()->deliveryman->id : $request->hero_id;

        // last 30 day data 
        $startDate      = Carbon::now()->subDays(7)->startOfDay();
        $endDate        = Carbon::now()->endOfDay();

        $commissions    = DeliveryHeroCommission::query();
        $commissions->whereBetween('updated_at', [$startDate, $endDate]);
        $commissions->where(fn ($commission) => $commission->where('delivery_hero_id', $hero_id)->orWhere('pickup_hero_id', $hero_id));

        $commissions    = $commissions->get();

        if ($commissions->isEmpty()) {
            return response()->json(['message' => 'No commissions found'], 404);
        }

        // Group by day and calculate  
        $commissions = $commissions->groupBy(fn ($commission) => $commission->updated_at->format('D'));

        // Transform the grouped data into the desired format
        $formattedCommissions = $commissions->map(function ($commissions, $day) {
            $paid   = $commissions->where('payment_status', PaymentStatus::PAID)->sum('amount');
            $unpaid   = $commissions->where('payment_status', PaymentStatus::UNPAID)->sum('amount');
            return [
                'day'    => $day,
                'paid'   => $paid,
                'unpaid' => $unpaid,
                'total' =>  $paid + $unpaid

            ];
        });

        return response()->json($formattedCommissions->values());
    }

    public function courier7DayIncomeExpense(Request $request)
    {
        if (config('app.app_demo')) {
            $startDate = Carbon::now()->subDays(6)->startOfDay(); // Start date is 7 days ago from today
            $endDate = Carbon::now()->endOfDay(); // End date is today

            $dummyData = [];

            // Generate dummy data for each day within the last 7 days
            for ($date = $startDate; $date->lte($endDate); $date->addDay()) {
                $dummyData[] = [
                    'day' => $date->format('D'),
                    'charge' => rand(50, 150),
                    'commission' => rand(10, 30),
                ];
            }

            return response()->json($dummyData);
        }

        if (!request()->ajax()) {
            return response()->json(['message' => ___('alert.invalid_request')], 422);
        }

        // last 7 day data 
        $startDate      = Carbon::now()->subDays(7)->startOfDay();
        $endDate        = Carbon::now()->endOfDay();

        $parcels    = Parcel::query();

        if (auth()->user()->user_type == UserType::HUB || auth()->user()->user_type == UserType::INCHARGE) {
            $parcels->where('hub_id', auth()->user()->hub_id);
        }

        $parcels->whereIn('status', [ParcelStatus::DELIVERED, ParcelStatus::PARTIAL_DELIVERED]);
        $parcels->whereBetween('updated_at', [$startDate, $endDate]);
        $parcels->with(['parcelTransaction', 'deliveryHeroCommission']);
        $parcels    = $parcels->get();

        if ($parcels->isEmpty()) {
            return response()->json(['message' => 'No parcels found'], 404);
        }

        $parcels = $parcels->groupBy(fn ($parcels) => $parcels->updated_at->format('D'));
        $parcels = $parcels->map(function ($parcels, $day) {

            $totalCharge     = $parcels->where('is_charge_paid', true)->sum(fn ($parcel) => $parcel->parcelTransaction->total_charge ?? 0);
            $totalCommission = $parcels->sum(fn ($parcel) => $parcel->deliveryHeroCommission->where('payment_status', PaymentStatus::PAID)->sum('amount') ?? 0);

            return [
                'day'           => $day,
                'charge'        => $totalCharge,
                'commission'    => $totalCommission,

            ];
        });

        return response()->json($parcels->values());
    }

    public function dailyMerchantCharge()
    {
        if (config('app.app_demo')) {
            $startDate = Carbon::now()->subDays(6)->startOfDay(); // Start date is 7 days ago from today
            $endDate = Carbon::now()->endOfDay(); // End date is today

            $dummyData = [];

            // Generate dummy data for each day within the last 7 days
            for ($date = $startDate; $date->lte($endDate); $date->addDay()) {
                $paid = rand(100, 500); // Random paid charge amount
                $unpaid = rand(50, 300); // Random unpaid charge amount

                $dummyData[] = [
                    'day' => $date->format('D'),
                    'paid' => $paid,
                    'unpaid' => $unpaid,
                ];
            }

            return response()->json($dummyData);
        }

        if (!request()->ajax()) {
            return response()->json(['message' => ___('alert.invalid_request')], 422);
        }

        $startDate      = Carbon::now()->subDays(7)->startOfDay();
        $endDate        = Carbon::now()->endOfDay();

        $parcels    = Parcel::query();

        if (auth()->user()->user_type == UserType::MERCHANT) {
            $parcels->where('merchant_id', auth()->user()->merchant->id);
        }

        if (auth()->user()->user_type == UserType::HUB || auth()->user()->user_type == UserType::INCHARGE) {
            $parcels->where('hub_id', auth()->user()->hub_id);
        }

        $parcels->whereIn('status', [ParcelStatus::DELIVERED, ParcelStatus::PARTIAL_DELIVERED]);
        $parcels->whereBetween('updated_at', [$startDate, $endDate]);
        $parcels->with(['parcelTransaction']);
        $parcels    = $parcels->get();

        if ($parcels->isEmpty()) {
            return response()->json(['message' => 'No parcels found'], 404);
        }

        $parcels = $parcels->groupBy(fn ($parcel) => $parcel->updated_at->format('D'));

        $parcels = $parcels->map(function ($parcels, $day) {
            $paid   = $parcels->where('is_charge_paid', true)->sum(fn ($parcel) => $parcel->parcelTransaction->total_charge ?? 0);
            $unpaid = $parcels->where('is_charge_paid', '!=', true)->sum(fn ($parcel) => $parcel->parcelTransaction->total_charge ?? 0);

            return [
                'day'       => $day,
                'paid'    => $paid,
                'unpaid' => $unpaid,
            ];
        });

        return response()->json($parcels->values());
    }

    public function cod7day(Request $request)
    {
        if (config('app.app_demo')) {
            $startDate = Carbon::now()->subDays(6)->startOfDay(); // Start date is 7 days ago from today
            $endDate = Carbon::now()->endOfDay(); // End date is today

            $dummyData = [];

            // Generate dummy data for each day within the last 7 days
            for ($date = $startDate; $date->lte($endDate); $date->addDay()) {
                $dummyData[] = [
                    'day' => $date->format('D'),
                    'paid' => rand(10, 50),
                    'unpaid' => rand(5, 30),
                    'pending' => rand(0, 20),
                    'receivedByHub' => rand(0, 15),
                    'receivedByAdmin' => rand(0, 10),
                ];
            }

            return response()->json($dummyData);
        }

        if (!request()->ajax()) {
            return response()->json(['message' => ___('alert.invalid_request')], 422);
        }

        $startDate      = Carbon::now()->subDays(7)->startOfDay();
        $endDate        = Carbon::now()->endOfDay();

        $parcels    = Parcel::query();

        if (auth()->user()->user_type == UserType::MERCHANT || $request->merchant_id) {
            $merchant_id = auth()->user()->user_type == UserType::MERCHANT ?  auth()->user()->merchant->id : $request->merchant_id;
            $parcels->where('merchant_id', $merchant_id);
        }

        if (auth()->user()->user_type == UserType::INCHARGE || $request->hub_id) {
            $hub_id = auth()->user()->user_type == UserType::INCHARGE ? auth()->user()->hub_id : $request->hub_id;
            $parcels->where('hub_id', $hub_id);
        }

        $parcels->whereIn('status', [ParcelStatus::DELIVERED, ParcelStatus::PARTIAL_DELIVERED]);
        $parcels->whereBetween('updated_at', [$startDate, $endDate]);
        $parcels->with(['parcelTransaction']);

        $parcels    = $parcels->get();

        if ($parcels->isEmpty()) {
            return response()->json(['message' => 'No parcels found'], 404);
        }

        $parcels = $parcels->groupBy(fn ($parcel) => $parcel->updated_at->format('D'));

        $parcels = $parcels->map(function ($parcels, $day) {
            $paid   = $parcels->where('cash_collection_status', CashCollectionStatus::PAID_TO_MERCHANT->value)->sum(fn ($parcel) => $parcel->parcelTransaction->cash_collection ?? 0);
            $unpaid = $parcels->where('cash_collection_status', '!=',  CashCollectionStatus::PAID_TO_MERCHANT->value)->sum(fn ($parcel) => $parcel->parcelTransaction->cash_collection ?? 0);
            $pending = $parcels->where('cash_collection_status', CashCollectionStatus::PENDING->value)->sum(fn ($parcel) => $parcel->parcelTransaction->cash_collection ?? 0);
            $receivedByHub = $parcels->where('cash_collection_status', CashCollectionStatus::RECEIVED_BY_HUB->value)->sum(fn ($parcel) => $parcel->parcelTransaction->cash_collection ?? 0);
            $receivedByAdmin = $parcels->where('cash_collection_status', CashCollectionStatus::RECEIVED_BY_ADMIN->value)->sum(fn ($parcel) => $parcel->parcelTransaction->cash_collection ?? 0);

            return [
                'day'               => $day,
                'paid'              => $paid,
                'unpaid'            => $unpaid,
                'pending'           => $pending,
                'receivedByHub'     => $receivedByHub,
                'receivedByAdmin'   => $receivedByAdmin,
            ];
        });

        return response()->json($parcels->values());
    }

    public function parcel30DayStatus(Request $request)
    {
        if (config('app.app_demo')) {
            $startDate = Carbon::now()->subDays(29)->startOfDay(); // Start date is 30 days ago from today
            $endDate = Carbon::now()->endOfDay(); // End date is today

            $dummyData = [];

            // Generate dummy data for each day within the last 30 days
            for ($date = $startDate; $date->lte($endDate); $date->addDay()) {
                $dummyData[] = [
                    'day' => $date->format('j'),
                    'delivered' => rand(10, 50),
                    'partial_delivered' => rand(5, 30),
                    'in_transit' => rand(0, 20),
                    'pending' => rand(0, 15),
                    'returned' => rand(0, 10),
                ];
            }

            return response()->json($dummyData);
        }

        if (!request()->ajax()) {
            return response()->json(['message' => ___('alert.invalid_request')], 422);
        }

        $startDate      = Carbon::now()->subDays(30)->startOfDay();
        $endDate        = Carbon::now()->endOfDay();

        $parcels    = Parcel::query();

        if (auth()->user()->user_type == UserType::MERCHANT || $request->merchant_id) {
            $merchant_id = auth()->user()->user_type == UserType::MERCHANT ?  auth()->user()->merchant->id : $request->merchant_id;
            $parcels->where('merchant_id', $merchant_id);
        }

        if (auth()->user()->user_type == UserType::INCHARGE || $request->hub_id) {
            $hub_id = auth()->user()->user_type == UserType::INCHARGE ? auth()->user()->hub_id : $request->hub_id;
            $parcels->where('hub_id', $hub_id);
        }

        if (auth()->user()->user_type == UserType::DELIVERYMAN) {
            $hero_id = auth()->user()->deliveryman->id;
            $parcels->whereHas('parcelEvent', fn ($query) => $query->where('delivery_man_id', $hero_id)->orWhere('pickup_man_id', $hero_id));
        }

        $parcels->whereBetween('updated_at', [$startDate, $endDate]);
        $parcels    = $parcels->get();

        if ($parcels->isEmpty()) {
            return response()->json(['message' => 'No parcels found'], 404);
        }

        $parcels = $parcels->groupBy(fn ($parcel) => $parcel->updated_at->format('j'));

        $parcels = $parcels->map(function ($parcels, $day) {

            $pending            = $parcels->where('status', ParcelStatus::PENDING)->count();
            $delivered          = $parcels->where('status', ParcelStatus::DELIVERED)->count();
            $partial_delivered  = $parcels->where('status', ParcelStatus::PARTIAL_DELIVERED)->count();
            $in_transit         = $parcels->whereNotIn('status', [ParcelStatus::DELIVERED, ParcelStatus::PARTIAL_DELIVERED])->count();
            $returned           = $parcels->where('status', ParcelStatus::RETURN_RECEIVED_BY_MERCHANT)->count();

            return [
                'day'               => $day,
                'delivered'         => $delivered,
                'partial_delivered' => $partial_delivered,
                'in_transit'        => $in_transit,
                'pending'           => $pending,
                'returned'          => $returned,
            ];
        });

        return response()->json($parcels->values());
    }
}
