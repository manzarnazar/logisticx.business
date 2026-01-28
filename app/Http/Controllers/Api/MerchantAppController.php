<?php

namespace App\Http\Controllers\Api;

use Throwable;
use Svg\Tag\Rect;
use App\Models\User;
use App\Enums\Status;
use App\Enums\UserType;
use Mockery\Expectation;
use App\Enums\ParcelStatus;
use Illuminate\Http\Request;
use App\Models\MerchantShops;
use App\Models\Backend\Parcel;

use App\Models\Backend\Payment;
use App\Models\Backend\Merchant;
use App\Http\Controllers\Controller;
use App\Traits\ApiReturnFormatTrait;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Repositories\Hub\HubInterface;
use App\Repositories\Bank\BankInterface;
use App\Models\Backend\ParcelTransaction;
use Illuminate\Contracts\Mail\Attachable;
use Illuminate\Support\Facades\Validator;
use function PHPUnit\Framework\returnSelf;
use App\Http\Resources\ParcelEventResource;
use App\Http\Resources\Merchant\HubResource;
use App\Http\Resources\Merchant\VASResource;
use App\Repositories\Charge\ChargeInterface;
use App\Repositories\Parcel\ParcelInterface;
use App\Http\Resources\Merchant\BankResource;
use App\Repositories\Profile\ProfileInterface;
use App\Models\Backend\Charges\ProductCategory;
use App\Http\Requests\Merchant\PaymentInfoStore;
use App\Http\Resources\HeroNotificationResource;
use App\Repositories\Coverage\CoverageInterface;
use App\Http\Resources\Merchant\ShopInfoResource;
use App\Repositories\MerchantShops\ShopsInterface;
use App\Http\Requests\Profile\ProfileUpdateRequest;
use App\Http\Resources\Merchant\DepartmentResource;
use App\Http\Requests\Profile\PasswordUpdateRequest;
use App\Http\Resources\Merchant\ServiceTypeResource;
use App\Http\Resources\Merchant\SupportChatResource;
use App\Repositories\ValueAddedService\VASInterface;
use App\Http\Resources\Merchant\CoverageAreaResource;
use App\Http\Resources\Merchant\MerchantShopResource;
use App\Repositories\MerchantPayment\PaymentInterface;
use App\Repositories\ServiceType\ServiceTypeInterface;
use App\Http\Resources\Merchant\MerchantParcelResource;
use App\Http\Requests\MerchantPanel\Parcel\StoreRequest;
use App\Http\Resources\Merchant\MerchantPaymentResource;
use App\Http\Resources\Merchant\MerchantProfileResource;
use App\Http\Resources\Merchant\MerchantSupportResource;
use App\Http\Resources\Merchant\ProductCategoryResource;
use App\Http\Requests\MerchantPanel\Parcel\UpdateRequest;
use App\Repositories\MerchantPanel\Support\SupportInterface;
use App\Http\Resources\Merchant\MerchantSingleParcelResource;
use App\Repositories\MerchantPanel\MerchantParcel\MerchantParcelInterface;

class MerchantAppController extends Controller
{
    use ApiReturnFormatTrait;

    protected $profileRepo, $parcelRepo, $merchantParcelRepo, $shopRepo, $coverageRepo, $vasRepo, $chargeRepo, $serviceRepo, $hubRepo, $paymentRepo, $bankRepo, $supportRepo;

    public function __construct(
        ProfileInterface $profileRepo,
        ParcelInterface $parcelRepo,
        MerchantParcelInterface $merchantParcelRepo,
        ShopsInterface $shopRepo,
        CoverageInterface $coverageRepo,
        VASInterface $vasRepo,
        ChargeInterface $chargeRepo,
        ServiceTypeInterface $serviceRepo,
        HubInterface $hubRepo,
        PaymentInterface $paymentRepo,
        BankInterface $bankRepo,
        SupportInterface $supportRepo
    ) {
        $this->profileRepo         = $profileRepo;
        $this->parcelRepo          = $parcelRepo;
        $this->merchantParcelRepo  = $merchantParcelRepo;
        $this->shopRepo            = $shopRepo;
        $this->coverageRepo        = $coverageRepo;
        $this->vasRepo             = $vasRepo;
        $this->chargeRepo          = $chargeRepo;
        $this->serviceRepo         = $serviceRepo;
        $this->hubRepo             = $hubRepo;
        $this->bankRepo            = $bankRepo;
        $this->paymentRepo         = $paymentRepo;
        $this->supportRepo         = $supportRepo;
    }

    private $statusSlug = [
        'pending'                   => ParcelStatus::PENDING,
        'pickup-assign'             => ParcelStatus::PICKUP_ASSIGN,
        'received-by-pickup-man'    => ParcelStatus::RECEIVED_BY_PICKUP_MAN,
        'received-warehouse'        => ParcelStatus::RECEIVED_WAREHOUSE,
        'delivery-man-assign'       => ParcelStatus::DELIVERY_MAN_ASSIGN,
        'delivered'                 => ParcelStatus::DELIVERED,
        'partial-delivered'         => ParcelStatus::PARTIAL_DELIVERED,
        'return-assign-to-merchant' => ParcelStatus::RETURN_ASSIGN_TO_MERCHANT,
    ];

    public function profile()
    {
        $user = User::where('id', auth()->id())->first();

        if (!$user) {
            return $this->responseWithError(___('alert.user_not_found'), []);
        }

        $data = new MerchantProfileResource($user);

        return $this->responseWithSuccess(___('alert.success'), $data);
    }

    public function merchantPassUpdate(PasswordUpdateRequest $request)
    {
        try {
            $user   = User::find(auth()->user()->id);
            if (Hash::check($request->old_password, $user->password)) {
                $user->password = Hash::make($request->new_password);
                $user->save();
                return $this->responseWithSuccess(___('alert.password_updated'));
            }
            return $this->responseWithError(___('alert.old_password_not_match')); // 400 for bad request
        } catch (\Throwable $th) {
            return $this->responseWithError(___('alert.something_went_wrong'));
        }
    }

    public function updateMerchantProfile(ProfileUpdateRequest $request)
    {
        $result = $this->profileRepo->update($request);

        if ($result['status']) {

            $data = new MerchantProfileResource($result['data']['user']);

            return $this->responseWithSuccess($result['message'], $data);
        }

        return $this->responseWithError($result['message'], []);
    }

    public function merchantParcelList(Request $request, $slug =  null)
    {

        $merchant_id = Auth::user()->merchant->id;
        $paginate = isset($request->page) ? true : false;

        $parcels = $this->merchantParcelRepo->all(
            merchant_id: $merchant_id,
            paginate: $paginate
        );

        if ($paginate) {
            $data = [
                'parcels' => MerchantSingleParcelResource::collection($parcels),
                'meta'  => [
                    'current_page' => $parcels->currentPage(),
                    'last_page'    => $parcels->lastPage(),
                    'per_page'     => $parcels->perPage(),
                    'total'        => $parcels->total(),
                ],
            ];
        } else {
            $data = [
                'parcels' => MerchantSingleParcelResource::collection($parcels),
            ];
        }

        return $this->responseWithSuccess(data: $data);
    }

    private function mid()  // mid = Merhchant User-Id 
    {
        return Auth::user()->merchant->id;
    }

    public function parcelBank()
    {
        $parcels = $this->merchantParcelRepo->parcelBank($this->mid());

        $data = [
            'parcels' => MerchantSingleParcelResource::collection($parcels),
            'meta'  => [
                'current_page' => $parcels->currentPage(),
                'last_page'    => $parcels->lastPage(),
                'per_page'     => $parcels->perPage(),
                'total'        => $parcels->total(),
            ],
        ];
    
        return $this->responseWithSuccess(data: $data);

    }

    // Pass merchant_id for any specific merchant otherwise it will give auth()->user->merchants shops/pickup points
    


    public function pickupPointNumAndAddress($shopID)
    {
        $info = MerchantShops::where('merchant_id', $this->mid())->where('id', $shopID)->first();

        if (!$info) {
            return $this->responseWithError(___('alert.no_record_found_for_this_merchant'));
        }

        $data = new MerchantShopResource($info);
        return $this->responseWithSuccess(___('alert.successful'), data: $data);
    }
    public function coverages(Request $request)
    {
        $coverages = $this->coverageRepo->getWithActiveChild($request);
        $data = CoverageAreaResource::collection($coverages);

        return $this->responseWithSuccess(___('alert.successful'), data: $data);
    }
    public function valueAddedService()
    {
        $ValueAddedServices = $this->vasRepo->all(Status::ACTIVE, ['id', 'name', 'price']);

        $data = VASResource::collection($ValueAddedServices);
        return $this->responseWithSuccess(___('alert.successful'), data: $data);
    }
    public function productCategories()
    {
        $productCategories  = $this->chargeRepo->getWithFilter(with: 'productCategory:id,name', columns: ['product_category_id']);

        $data = ProductCategoryResource::collection($productCategories);
        return $this->responseWithSuccess(___('alert.successful'), data: $data);
    }
    public function serviceTypes(Request $request)
    {
        $types  = $this->serviceRepo->getServiseTypes($request);

        $data = ServiceTypeResource::collection($types);
        return $this->responseWithSuccess(___('alert.successful'), data: $data);
    }

    public function getCharge(Request $request)
    {
        $result = $this->parcelRepo->getCharge($request);

        if($result['status']){
            return $this->responseWithSuccess(___('alert.successful'), data: $result['data']);
        }

        return $this->responseWithError($result['message']);
        
    }

    public function parcelDetails($id)
    {
        $parcel = $this->parcelRepo->get($id);


        $data = new MerchantSingleParcelResource($parcel);
        return $this->responseWithSuccess(___('alert.successful'), data: $data);
        
    }

    public function parcelEvents($id)
    {
        $events = $this->parcelRepo->parcelEvents($id);

        $data = ParcelEventResource::collection($events);
        return $this->responseWithSuccess(___('alert.successful'), data: $data);
        
    }



    public function createParcel(StoreRequest $request)
    {
        $result = $this->parcelRepo->store($request);

        if ($result['status']) {
            return $this->responseWithSuccess($result['message']);
        }
        return $this->responseWithError($result['message']);
    }

    public function updateParcel(UpdateRequest $request)
    {
        $result = $this->parcelRepo->update($request);

        if ($result['status']) {
            return $this->responseWithSuccess($result['message']);
        }
        return $this->responseWithError($result['message']);
    }
    public function editParcel($id)
    {
        $parcel = $this->parcelRepo->get($id);


        $data = new MerchantSingleParcelResource($parcel);
        return $this->responseWithSuccess(___('alert.successful'), data: $data);
    }

    public function deleteParcel($id)
    {
        $result = $this->parcelRepo->delete($id);
        if ($result['status']) {
            return $this->responseWithSuccess($result['message']);
        }
        return $this->responseWithError($result['message']);
    }

    public function parcels(Request $request, $status = null)
    {
        $merchant_id = Auth::user()->merchant->id;
        $paginate = $request->boolean('paginate', true);

        $parcels = $this->merchantParcelRepo->all(
            merchant_id: $merchant_id,
            status: $status,
            paginate: $paginate
        );

        if ($paginate) {
            $data = [
                'parcels' => MerchantSingleParcelResource::collection($parcels),
                'meta'  => [
                    'current_page' => $parcels->currentPage(),
                    'last_page'    => $parcels->lastPage(),
                    'per_page'     => $parcels->perPage(),
                    'total'        => $parcels->total(),
                ],
            ];
        } else {
            $data = [
                'parcels' => MerchantSingleParcelResource::collection($parcels),
            ];
        }

        return $this->responseWithSuccess(data: $data);
    }


    public function hubList(Request $request)
    {
        if ($request->has('page')) {
            // 👉 Paginated response
            $hubs = $this->hubRepo->all(
                status: Status::ACTIVE,
                orderBy: 'name',
                sortBy: 'asc',
                paginate: settings('paginate_value')
            );

            return $this->responseWithSuccess(
                ___('alert.successful'),
                data: [
                    'hubs' => HubResource::collection($hubs),
                    'meta' => [
                        'current_page' => $hubs->currentPage(),
                        'last_page'    => $hubs->lastPage(),
                        'per_page'     => $hubs->perPage(),
                        'total'        => $hubs->total(),
                    ],
                ]
            );
        }

        // 👉 Without ?page → return all hubs
        $hubs = $this->hubRepo->all(
            status: Status::ACTIVE,
            orderBy: 'name',
            sortBy: 'asc'
        );

        return $this->responseWithSuccess(
            ___('alert.successful'),
            data: [
                'hubs' => HubResource::collection($hubs),
            ]
        );
    }

    public function notifications()
    {
        $notifications = auth()->user()->notifications()->latest()->paginate(settings('paginate_value'));

        $data = HeroNotificationResource::collection($notifications);

        return $this->responseWithSuccess(
            ___('alert.successful'),
            data: [
                'notifications' => $data,
                'meta' => [
                    'current_page' => $notifications->currentPage(),
                    'last_page'    => $notifications->lastPage(),
                    'per_page'     => $notifications->perPage(),
                    'total'        => $notifications->total(),
                ],
            ]
        );

    }

    public function notificationMarkAsRead(Request $request, $id)
    {
        $notification = $request->user()->notifications()->findOrFail($id);

        if ($notification->read_at !== null) {
            return $this->responseWithError(___('alert.already_marked_as_read'), 400);
        }

        $notification->markAsRead();
        return $this->responseWithSuccess(___('alert.successfully_updated'));
    }


    public function notificationMarkAllAsRead(Request $request)
    {
        if ($request->user()->unreadNotifications->count() === 0) {
            return $this->responseWithError(___('alert.already_marked_as_read'), 400);
        }

        $request->user()->unreadNotifications->markAsRead();
        return $this->responseWithSuccess(___('alert.successfully_updated'));
    }

    public function unreadNotificationCount(Request $request)
    {
        $count = $request->user()->unreadNotifications()->count();
        $data  = ['count' => $count];

        return $this->responseWithSuccess(___('alert.successful'), data: $data);

    }


    public function homeStats(Request $request)
    {
        $merchantID = Auth::user()->merchant->id;

        // 🔹 Parcel Transactions (cash collection & payable)
        $transactionQuery = ParcelTransaction::whereHas('parcel', function ($q) use ($merchantID) {
            $q->where('merchant_id', $merchantID);
        });

        $totalCashCollection = $transactionQuery->sum('cash_collection');
        $totalPayable        = $transactionQuery->sum('current_payable');

        // 🔹 Payments (paid & unpaid)
        $totalPaid = Payment::where('merchant_id', $merchantID)
            ->where('status', \App\Enums\ApprovalStatus::APPROVED) // only approved payments count
            ->sum('amount');

        $unpaid = $totalPayable - $totalPaid;

        // 🔹 Parcel Status Counts
        $pendingParcels = Parcel::where('merchant_id', $merchantID)
            ->where('status', ParcelStatus::PENDING)
            ->count();

        $deliveredParcels = Parcel::where('merchant_id', $merchantID)
            ->where('status', ParcelStatus::DELIVERED)
            ->count();

        $partialParcels = Parcel::where('merchant_id', $merchantID)
            ->where('status', ParcelStatus::PARTIAL_DELIVERED)
            ->count();

        $returnedParcels = Parcel::where('merchant_id', $merchantID)
            ->where('status', ParcelStatus::RETURN_RECEIVED_BY_MERCHANT)
            ->count();

            $data    = [
                'cash_collection' => settings('currency') .' ' .$totalCashCollection,
                'total_payable'   => settings('currency') .' ' .$totalPayable,
                'total_paid'      => settings('currency') .' ' .$totalPaid,
                'unpaid'          => settings('currency') .' ' .$unpaid,

                'parcels' => [
                    'pending'   => $pendingParcels,
                    'delivered' => $deliveredParcels,
                    'partial'   => $partialParcels,
                    'returned'  => $returnedParcels,
                ],
            ];
   


        return $this->responseWithSuccess(___('alert.successful'), data: $data);

    }




    
}
