<?php

namespace App\Repositories\Parcel;

use Carbon\Carbon;
use App\Models\User;
use App\Enums\Status;
use App\Enums\UserType;
use App\Enums\CouponType;
use App\Enums\DeliveryTime;
use App\Enums\DeliveryType;
use App\Enums\DiscountType;
use App\Enums\ParcelStatus;
use Illuminate\Support\Str;
use App\Enums\BooleanStatus;
use App\Enums\PaymentStatus;
use App\Enums\SmsSendStatus;
use App\Models\MerchantShops;
use App\Notifications\Notify;
use App\Models\Backend\Coupon;
use App\Models\Backend\Parcel;
use App\Models\Backend\Merchant;
use App\Http\Services\SmsService;
use App\Traits\ReturnFormatTrait;
use Illuminate\Support\Facades\DB;
use App\Enums\CashCollectionStatus;
use App\Models\Backend\DeliveryMan;
use App\Models\Backend\ParcelEvent;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Models\Backend\Charges\Charge;
use App\Models\Backend\MerchantCharge;
use App\Notifications\StoreNotification;
use App\Models\Backend\ParcelTransaction;
use App\Models\Backend\ParcelStatusUpdate;
use App\Repositories\Charge\ChargeInterface;
use App\Repositories\Parcel\ParcelInterface;
use App\Http\Services\PushNotificationService;
use App\Models\Backend\DeliveryHeroCommission;
use App\Repositories\Coverage\CoverageInterface;
use App\Models\Backend\Charges\ValueAddedService;

class ParcelRepository implements ParcelInterface
{
    use ReturnFormatTrait;

    protected $model;
    protected $coverageRepo, $chargeRepo;

    public function __construct(Parcel $model, CoverageInterface $coverageRepo, ChargeInterface $chargeRepo)
    {
        $this->model        = $model;
        $this->coverageRepo = $coverageRepo;
        $this->chargeRepo   = $chargeRepo;
    }

    public function all(string $status = null, int $paginate = null, string $orderBy = 'id', string $sortBy = 'desc', array $select = [])
    {
        $query = $this->model::query();

        if ($status) {
            $query->where('status', $status);
        }

        $query->with('parcelTransaction', 'merchant', 'parcelEvent');

        if ($status) {
            $query->where('status', $status);
        }

        if (auth()->user()->user_type == UserType::MERCHANT) {
            $query->where('merchant_id', auth()->user()->merchant->id);
        }

        if ((auth()->user()->user_type == UserType::INCHARGE || auth()->user()->user_type == UserType::HUB) && auth()->user()->hub_id) {
            $query->whereHas('parcelEvent', fn($query) => $query->where('hub_id', auth()->user()->hub_id));
        }

        if (auth()->user()->user_type == UserType::DELIVERYMAN) {
            $hero_id = auth()->user()->deliveryman->id;
            $query->whereHas('parcelEvent', fn($query) => $query->where('delivery_man_id', $hero_id)->orWhere('pickup_man_id', $hero_id));
        }

        if (!empty($select)) {
            $query->select($select);
        }

        $query->orderBy($orderBy, $sortBy);

        if ($paginate !== null) {
            return  $query->paginate($paginate);
        }
        return $query->get();
    }

    public function deliveryManParcel()
    {
        return $this->model::orderByDesc('id')->where(function ($query) {
            if (auth()->user()->deliveryman) {
                $query->whereHas('parcelEvent', function ($queryParcelEvent) {
                    if (auth()->user()->deliveryman->id) {
                        $queryParcelEvent->where(['delivery_man_id' => auth()->user()->deliveryman->id]);
                        $queryParcelEvent->orWhere(['pickup_man_id' => auth()->user()->deliveryman->id]);
                    }
                });
            }
        })->get();
    }


    public function filter($request)
    {

        $userHubID = auth()->user()->hub_id;
        if ($request->parcel_date) {
            // $date = explode('to', $request->parcel_date); // case sensitive
            $date = preg_split('/\bto\b/i', $request->parcel_date); // case insensitive
            $from   = Carbon::parse(trim($date[0]))->startOfDay()->toDateTimeString();
            $to     = isset($date[1]) ? Carbon::parse(trim($date[1]))->endOfDay()->toDateTimeString() : $from;
        }
        if (!blank($userHubID)) {
            return $this->model::with('parcelEvent')->where('hub_id', $userHubID)->orderByDesc('id')->where(function ($query) use ($request) {
                if ($request->parcel_date) {
                    // $date = explode('to', $request->parcel_date); // case sensitive
                    $date = preg_split('/\bto\b/i', $request->parcel_date); // case insensitive
                    if (is_array($date)) {
                        $from   = Carbon::parse(trim($date[0]))->startOfDay()->toDateTimeString();
                        $to     = isset($date[1]) ? Carbon::parse(trim($date[1]))->endOfDay()->toDateTimeString() : $from;
                        $query->whereBetween('created_at', [$from, $to]);
                    }
                }

                if ($request->parcel_status) {
                    if ($request->parcel_status == ParcelStatus::DELIVERY_MAN_ASSIGN) {
                        $query->whereIn('status',   [$request->parcel_status, ParcelStatus::DELIVERY_RE_SCHEDULE]);
                    } else {
                        $query->where('status', $request->parcel_status);
                    }
                }

                if ($request->parcel_merchant_id) {
                    $query->where(['merchant_id' => $request->parcel_merchant_id]);
                }

                if ($request->parcel_deliveryman_id || $request->parcel_pickupman_id) {

                    $query->whereHas('parcelEvent', function ($queryParcelEvent) use ($request) {

                        if ($request->parcel_deliveryman_id) {
                            $queryParcelEvent->where(['delivery_man_id' => $request->parcel_deliveryman_id]);
                        }

                        if ($request->parcel_pickupman_id) {
                            $queryParcelEvent->where(['pickup_man_id' => $request->parcel_pickupman_id]);
                        }
                    });
                }
                if ($request->invoice_id) {
                    $query->where('invoice_no', 'like', '%' . $request->invoice_id . '%');
                }
            })->paginate(settings('paginate_value'));
        } else {
            return $this->model::with('parcelEvent')->orderByDesc('id')->where(function ($query) use ($request) {

                if ($request->parcel_date) {
                    // $date = explode('to', $request->parcel_date); // case sensitive
                    $date = preg_split('/\bto\b/i', $request->parcel_date); // case insensitive
                    if (is_array($date)) {
                        $from   = Carbon::parse(trim($date[0]))->startOfDay()->toDateTimeString();
                        $to     = isset($date[1]) ? Carbon::parse(trim($date[1]))->endOfDay()->toDateTimeString() : $from;
                        $query->whereBetween('created_at', [$from, $to]);
                    }
                }

                if ($request->parcel_status) {
                    if ($request->parcel_status == ParcelStatus::DELIVERY_MAN_ASSIGN) {
                        $query->whereIn('status',   [$request->parcel_status, ParcelStatus::DELIVERY_RE_SCHEDULE]);
                    } else {
                        $query->where('status', $request->parcel_status);
                    }
                }

                if ($request->parcel_merchant_id) {
                    $query->where(['merchant_id' => $request->parcel_merchant_id]);
                }

                if ($request->parcel_deliveryman_id || $request->parcel_pickupman_id) {
                    $query->whereHas('parcelEvent', function ($queryParcelEvent) use ($request) {

                        if ($request->parcel_deliveryman_id) {
                            $queryParcelEvent->where(['delivery_man_id' => $request->parcel_deliveryman_id]);
                        }

                        if ($request->parcel_pickupman_id) {
                            $queryParcelEvent->where(['pickup_man_id' => $request->parcel_pickupman_id]);
                        }
                    });
                }
                if ($request->invoice_id) {
                    $query->where('invoice_no', 'like', '%' . $request->invoice_id . '%');
                }
            })->paginate(settings('paginate_value'));
        }
    }




    public function filterPrint($request)
    {
        $userHubID = auth()->user()->hub_id;
        if (!blank($userHubID)) {
            return $this->model::with('parcelEvent')->where('hub_id', $userHubID)->orderByDesc('id')->where(function ($query) use ($request) {
                if ($request->parcel_date) {
                    // $date = explode('to', $request->parcel_date); // case sensitive
                    $date = preg_split('/\bto\b/i', $request->parcel_date); // case insensitive
                    if (is_array($date)) {
                        $from   = Carbon::parse(trim($date[0]))->startOfDay()->toDateTimeString();
                        $to     = isset($date[1]) ? Carbon::parse(trim($date[1]))->endOfDay()->toDateTimeString() : $from;
                        $query->whereBetween('created_at', [$from, $to]);
                    }
                }
                if ($request->parcel_status) {
                    if ($request->parcel_status == ParcelStatus::DELIVERY_MAN_ASSIGN) {
                        $query->whereIn('status',   [$request->parcel_status, ParcelStatus::DELIVERY_RE_SCHEDULE]);
                    } else {
                        $query->where('status', $request->parcel_status);
                    }
                }

                if ($request->pickup_date) {
                    $query->where(['pickup_date' => date('Y-m-d', strtotime($request->pickup_date))]);
                }

                if ($request->delivery_date) {
                    $query->where(['delivery_date' => date('Y-m-d', strtotime($request->delivery_date))]);
                }

                if ($request->parcel_merchant_id) {
                    $query->where(['merchant_id' => $request->parcel_merchant_id]);
                }

                if ($request->parcel_deliveryman_id || $request->parcel_pickupman_id) {
                    $query->whereHas('parcelEvent', function ($queryParcelEvent) use ($request) {
                        if ($request->parcel_deliveryman_id) {
                            $queryParcelEvent->where(['delivery_man_id' => $request->parcel_deliveryman_id]);
                        }
                        if ($request->parcel_pickupman_id) {
                            $queryParcelEvent->where(['pickup_man_id' => $request->parcel_pickupman_id]);
                        }
                    });
                }
            })->get();
        } else {
            return $this->model::with('parcelEvent')->orderByDesc('id')->where(function ($query) use ($request) {
                if ($request->parcel_date) {
                    // $date = explode('to', $request->parcel_date); // case sensitive
                    $date = preg_split('/\bto\b/i', $request->parcel_date); // case insensitive
                    if (is_array($date)) {
                        $from   = Carbon::parse(trim($date[0]))->startOfDay()->toDateTimeString();
                        $to     = isset($date[1]) ? Carbon::parse(trim($date[1]))->endOfDay()->toDateTimeString() : $from;
                        $query->whereBetween('created_at', [$from, $to]);
                    }
                }

                if ($request->parcel_status) {
                    if ($request->parcel_status == ParcelStatus::DELIVERY_MAN_ASSIGN) {
                        $query->whereIn('status',   [$request->parcel_status, ParcelStatus::DELIVERY_RE_SCHEDULE]);
                    } else {
                        $query->where('status', $request->parcel_status);
                    }
                }
                if ($request->pickup_date) {
                    $query->where(['pickup_date' => date('Y-m-d', strtotime($request->pickup_date))]);
                }

                if ($request->delivery_date) {
                    $query->where(['delivery_date' => date('Y-m-d', strtotime($request->delivery_date))]);
                }

                if ($request->parcel_merchant_id) {
                    $query->where(['merchant_id' => $request->parcel_merchant_id]);
                }

                if ($request->parcel_deliveryman_id || $request->parcel_pickupman_id) {
                    $query->whereHas('parcelEvent', function ($queryParcelEvent) use ($request) {

                        if ($request->parcel_deliveryman_id) {
                            $queryParcelEvent->where(['delivery_man_id' => $request->parcel_deliveryman_id]);
                        }

                        if ($request->parcel_pickupman_id) {
                            $queryParcelEvent->where(['pickup_man_id' => $request->parcel_pickupman_id]);
                        }
                    });
                }
            })->get();
        }
    }

    public function get($id)
    {
        return $this->model::findOrFail($id);
    }

    public function parcelEvents($id)
    {
        return ParcelEvent::with(['deliveryMan', 'pickupman', 'transferDeliveryman', 'hub', 'user'])->where('parcel_id', $id)->orderBy('created_at', 'desc')->get();
    }

    public function details($id)
    {
        if (auth()->user()->user_type == UserType::MERCHANT) {
            return $this->model::where('id', $id)->where('merchant_id', auth()->user()->merchant->id)->with('parcelTransaction', 'merchant', 'parcelEvent')->firstOrFail();
        }
        return  $this->model::with('parcelTransaction', 'merchant', 'parcelEvent')->findOrFail($id);
    }

    public function store($request)
    {
        \Log::info('test repo' . json_encode($this->all()));
        // try {
        DB::beginTransaction();

        $merchant                       = Merchant::with('user')->find($request->merchant_id);
        $shop                           = MerchantShops::find($request->shop_id);

        $parcel                         = new $this->model();

        $parcel->merchant_id            = $merchant->id;
        $parcel->merchant_shop_id       = $shop->id;
        $parcel->pickup_phone           = $request->pickup_phone;
        $parcel->pickup_address         = $request->pickup_address;
        $parcel->invoice_no             = $request->invoice_no;

        $parcel->pickup                 = $shop->coverage_id;
        $parcel->destination            = $request->destination;

        $parcel->customer_name          = $request->customer_name;
        $parcel->customer_phone         = $request->customer_phone;
        $parcel->customer_address       = $request->customer_address;
        $parcel->note                   = $request->note;


        $parcel->quantity               = $request->quantity;
        $parcel->product_category_id    = $request->product_category;
        $parcel->service_type_id        = $request->service_type;
        $parcel->area                   = $this->coverageRepo->detectArea($parcel->pickup, $parcel->destination);

        $where  = ['product_category_id' => $parcel->product_category_id, 'service_type_id' => $parcel->service_type_id, 'area' => $parcel->area, 'status' => Status::ACTIVE];
        $charge = MerchantCharge::where($where)->first();

        if (!$charge) {
            $charge = Charge::where($where)->first();
        }

        if (!$charge) {
            DB::rollBack();
            return $this->responseWithError(___('alert.no_charge_found'), ['status_code' => '400']);
        }

        $parcel->is_parcel_bank             =  isset($request->is_parcel_bank) ? 1 : 0;
        $parcel->charge_id                  =  $charge->id;

        $parcel->vas                    = [];
        if ($request->filled('vas')) {
            $vas                        = ValueAddedService::whereIn('id', $request->vas)->get(['id', 'price']);
            $parcel->vas                = $vas->toArray();
        }

        $parcel->vat                    = $merchant->vat;
        $parcel->first_hub_id           = $shop->hub_id;
        $parcel->hub_id                 = $parcel->first_hub_id;
        $parcel->tracking_id            = $this->generateUniqueTrackingId($parcel->merchant_id) . 'C';

        if ($request->input('cash_collection') > 0) {
            $parcel->cash_collection_status = CashCollectionStatus::PENDING;
        }

        $transaction                        = new ParcelTransaction();
        $transaction->cash_collection       = $request->input('cash_collection', 0);
        $transaction->selling_price         = $request->input('selling_price', 0);
        $transaction->charge                = $request->input('charge', 0);

        if (auth()->user()->user_type == UserType::MERCHANT) {
            $additional                     = ($parcel->quantity - 1) * $charge->additional_charge;
            $transaction->charge            = $charge->charge + $additional;
        }

        $transaction->cod_charge            = $request->cash_collection > 0 ? ($merchant->codCharges[$parcel->area] * $transaction->cash_collection) / 100 : 0;
        $transaction->liquid_fragile_charge = isset($request->fragileLiquid) ? ($merchant->liquidFragileRate *  $transaction->charge) / 100 : 0;
        $transaction->vas_charge            = isset($vas) ? $vas->sum('price') : 0;
        $transaction->total_charge          = $transaction->charge + $transaction->cod_charge + $transaction->liquid_fragile_charge +  $transaction->vas_charge; // total charge without vat

        if ($request->filled('coupon')) {
            $transaction->discount          = $this->couponDiscount($request->input('coupon'), $parcel->merchant_id, $transaction->total_charge);
            $transaction->total_charge      = $transaction->total_charge - $transaction->discount;
            $parcel->coupon                 = $transaction->discount > 0 ? $request->input('coupon')  :  null;
        } else {
            $parcel->coupon                 = null;
            $transaction->discount          = 0;
        }

        $transaction->vat_amount            = ($transaction->total_charge * $parcel->vat) / 100;
        $transaction->total_charge          = $transaction->total_charge + $transaction->vat_amount; // total charge with vat
        $transaction->current_payable       = $transaction->cash_collection - $transaction->total_charge;

        // save parcel
        $parcel->save();

        $transaction->parcel_id             = $parcel->id;
        $transaction->save(); // save parcel transaction

        // Parcel event
        $event                              = new ParcelEvent();
        $event->parcel_id                   = $parcel->id;
        $event->note                        = 'Parcel created';
        $event->parcel_status               = ParcelStatus::PENDING;
        $event->created_by                  = auth()->user()->id;
        $event->save();

        DB::commit();


        $message    = 'Create a Parcel';
        $url        = route('parcel.details', $parcel->id);

        if (auth()->user()->user_type == UserType::MERCHANT) {
            $user = User::where('user_type', UserType::INCHARGE)->where('hub_id', $parcel->hub_id)->first();
            if ($user) {
                $user->notify(new Notify($message, $url));
            }
        } else {
            $parcel->merchant->user->notify(new Notify($message, $url));
        }


        // try {
        //     app(PushNotificationService::class)->sendStatusPushNotification($parcel, $parcel->merchant->user->email);
        // } catch (\Exception $exception) {
        // }


        if (SmsSendSettingHelper(SmsSendStatus::PARCEL_CREATE)) {
            if (session()->has('locale') && session()->get('locale') == 'bn') :
                $msg = 'প্রিয় ' . $parcel->customer_name . ', আপনার পার্সেল সফলভাবে তৈরি করা হয়েছে । আপনার পার্সেলের আইডি ' . $parcel->tracking_id . ' পার্সেল পাঠিয়েছেন ' . $parcel->merchant->business_name . ' (' . $parcel->cash_collection . ' টাকা)';

            else :
                $msg = 'Dear ' . $parcel->customer_name . ', Your parcel is successfully created. Your parcel with ID ' . $parcel->tracking_id . ' parcel from ' . $parcel->merchant->business_name . ' (' . $parcel->cash_collection . ')';
            endif;
            $response = app(SmsService::class)->sendSms($parcel->customer_phone, $msg);
        }


        return $this->responseWithSuccess(___('alert.successfully_added'), ['redirect_url' => route('parcel.index'), 'status_code' => '201']);
        // } catch (\Throwable $th) {
        //     DB::rollBack();
        //     return $this->responseWithError(___('alert.something_went_wrong'), ['status_code' => '500']);
        // }
    }

    public function getCharge($request) 
    {
        try {

            $merchant                   = auth()->user()->merchant;
            $vas                        = ValueAddedService::whereIn('id', $request->vas)->get(['id', 'price']);

            $area   = $this->coverageRepo->detectArea($request->pickup_id, $request->destination);

            $where  = ['product_category_id' => $request->product_category_id, 'service_type_id' => $request->service_type_id, 'area' => $area, 'status' => Status::ACTIVE];
            $charge = MerchantCharge::where($where)->first();

            if (!$charge) {
                $charge = Charge::where($where)->first();
            }

            Log::info('Charge found: ', ['charge' => $charge]);

            $additional_charge     = $charge->charge;
            $charge                = $charge->charge;
            if (auth()->user()->user_type == UserType::MERCHANT) {
                $additional                     = ($request->quantity - 1) * $additional_charge;
                $charge                         = $charge + $additional;
            }

            $cod_charge            = $request->cash_collection > 0 ? ($merchant->codCharges[$area] * $request->cash_collection) / 100 : 0;
            $liquid_fragile_charge = $request->fragileLiquid == 1? ($merchant->liquidFragileRate *  $charge) / 100 : 0;
            $vas_charge            = isset($vas) ? $vas->sum('price') : 0;
            $total_charge          = $charge + $cod_charge + $liquid_fragile_charge +  $vas_charge; // total charge without vat

            if ($request->filled('coupon')) {
                $discount          = $this->couponDiscount($request->input('coupon'), $merchant->id, $total_charge);
                $total_charge      = $total_charge - $discount;
                $coupon            = $discount > 0 ? $request->input('coupon')  :  null;
            } else {
                $coupon            = null;
                $discount          = 0;
            }

            $vat_amount            = ($total_charge * $merchant->vat) / 100;
            $total_charge          = $total_charge + $vat_amount; // total charge with vat


            $data = [
                'charge'                => number_format($charge, 2),
                'cod_charge'            => number_format($cod_charge, 2),
                'liquid_fragile_charge' => number_format($liquid_fragile_charge, 2),
                'vas_charge'            => number_format($vas_charge, 2),
                'total_charge'          => number_format($total_charge, 2),
                'vat_amount'            => number_format($vat_amount, 2),
                'discount'              => number_format($discount, 2),
                'coupon'                => $coupon,
            ];

            return $this->responseWithSuccess('', $data);

        } catch (\Throwable $th) {
            $data = [
                'charge'                => 0,
                'cod_charge'            => 0,
                'liquid_fragile_charge' => 0,
                'vas_charge'            => 0,
                'total_charge'          => 0,
                'vat_amount'            => 0,
                'discount'              => 0,
                'coupon'                => null,
            ];
            return $this->responseWithSuccess('', $data);
        }
        

    }



    public function update($request)
    {
        try {
            DB::beginTransaction();

            $merchant                       = Merchant::with('user')->find($request->merchant_id);
            $shop                           = MerchantShops::find($request->shop_id);

            if ($request->filled('id')) {
                // ✅ Update Flow
                $parcel = $this->model::findOrFail($request->id);
            } else {
                // ✅ Clone Flow (new parcel)
                $parcel = new $this->model();
            }

            $parcel->merchant_id            = $merchant->id;
            $parcel->merchant_shop_id       = $shop->id;
            $parcel->pickup_phone           = $request->pickup_phone;
            $parcel->pickup_address         = $request->pickup_address;
            $parcel->pickup                 = $shop->coverage_id;
            $parcel->destination            = $request->destination;
            $parcel->customer_name          = $request->customer_name;
            $parcel->customer_phone         = $request->customer_phone;
            $parcel->customer_address       = $request->customer_address;
            $parcel->note                   = $request->note;
            $parcel->invoice_no             = $request->invoice_no;
            $parcel->quantity               = $request->quantity;
            $parcel->product_category_id    = $request->product_category;
            $parcel->service_type_id        = $request->service_type;
            $parcel->area                   =  $this->coverageRepo->detectArea($parcel->pickup, $parcel->destination);

            $where  = ['product_category_id' => $parcel->product_category_id, 'service_type_id' => $parcel->service_type_id, 'area' => $parcel->area, 'status' => Status::ACTIVE];
            $charge = MerchantCharge::where($where)->first();

            if (!$charge) {
                $charge = Charge::where($where)->first();
            }

            if (!$charge) {
                DB::rollBack();
                return $this->responseWithError(___('alert.no_charge_found'), ['status_code' => '400']);
            }

            $parcel->is_parcel_bank         =  isset($request->is_parcel_bank) ? 1 : 0;
            $parcel->charge_id              =  $charge->id;

            $parcel->vas                    = [];
            if ($request->filled('vas')) {
                $vas                        = ValueAddedService::whereIn('id', $request->vas)->get(['id', 'price']);
                $existingVAS                = collect($parcel->vas)->map(fn($item) => (object) $item); // get this parcel's VAS's

                $vas->transform(function ($vas) use ($existingVAS) {
                    $existing = $existingVAS->where('id', $vas->id)->first();
                    if ($existing) {
                        $vas->price = $existing->price;
                    }
                    return $vas;
                });

                $parcel->vas                = $vas->toArray();
            }

            $parcel->vat                    = $merchant->vat;
            $parcel->first_hub_id           = $shop->hub_id;
            $parcel->hub_id                 = $parcel->first_hub_id;

            $parcel->cash_collection_status = null;
            if ($request->input('cash_collection') > 0) {
                $parcel->cash_collection_status = CashCollectionStatus::PENDING;
            }

            $transaction                        = ParcelTransaction::where('parcel_id', $parcel->id)->first();
            $transaction->cash_collection       = $request->input('cash_collection', 0);
            $transaction->selling_price         = $request->input('selling_price', 0);
            $transaction->charge                = $request->input('charge', 0);

            if (auth()->user()->user_type == UserType::MERCHANT) {
                $additional = ($parcel->quantity - 1) * $charge->additional_charge;
                $transaction->charge            = $charge->charge + $additional;
            }

            $transaction->cod_charge            = $transaction->cash_collection > 0 ? ($merchant->codCharges[$parcel->area] * $transaction->cash_collection) / 100 : 0;
            $transaction->liquid_fragile_charge = isset($request->fragileLiquid) ? ($merchant->liquidFragileRate *  $transaction->charge) / 100 : 0;
            $transaction->vas_charge            = isset($vas) ? $vas->sum('price') : 0;
            $transaction->total_charge          = $transaction->charge + $transaction->cod_charge + $transaction->liquid_fragile_charge +  $transaction->vas_charge;

            if ($request->filled('coupon')) {
                $transaction->discount          = $this->couponDiscount($request->input('coupon'), $parcel->merchant_id, $transaction->total_charge);
                $transaction->total_charge      = $transaction->total_charge - $transaction->discount;
                $parcel->coupon                 = $transaction->discount > 0 ? $request->input('coupon')  :  null;
            } else {
                $parcel->coupon                 = null;
                $transaction->discount          = 0;
            }

            $transaction->vat_amount            = ($transaction->total_charge * $parcel->vat) / 100;
            $transaction->total_charge          = $transaction->total_charge + $transaction->vat_amount; // total charge with vat
            $transaction->current_payable       = $transaction->cash_collection - $transaction->total_charge;

            // save parcel
            $parcel->save();

            $transaction->parcel_id             = $parcel->id;

            // save parcel  transaction
            $transaction->save();

            DB::commit();

            $message    = 'Update a Parcel';
            $url        = route('parcel.details', $parcel->id);

            if (auth()->user()->user_type == UserType::MERCHANT) {
                $user = User::where('user_type', UserType::INCHARGE)->where('hub_id', $parcel->hub_id)->first();
                if ($user) {
                    $user->notify(new Notify($message, $url));
                }
            } else {
                $parcel->merchant->user->notify(new Notify($message, $url));
            }

            return $this->responseWithSuccess(___('alert.successfully_updated'), ['redirect_url' => route('parcel.index'), 'status_code' => '201',]);
        } catch (\Throwable $th) {
            DB::rollBack();
            return $this->responseWithError(___('alert.something_went_wrong'), ['status_code' => '500']);
        }
    }

    public function delete($id)
    {
        try {
            $parcel =  $this->model::find($id);

            if (!$parcel) {
                return $this->responseWithError(___('parcel.no_parcel_found'), []);
            }

            if (auth()->user()->user_type == UserType::MERCHANT && $parcel->merchant_id != auth()->user()->merchant->id) {
                return $this->responseWithError(___('alert.unauthorized'), []);
            }

            if ($parcel->status != ParcelStatus::PENDING) {
                return $this->responseWithError(___('parcel.not_delete_msg'), []);
            }

            $parcel->delete();
            return $this->responseWithSuccess(___('alert.successfully_deleted'), []);
        } catch (\Throwable $th) {
            return $this->responseWithError(___('alert.something_went_wrong'), []);
        }
    }

    //parcel events
    public function pickupManAssign($request)
    {
        try {
            DB::beginTransaction();

            $parcel                 = $this->model::find($request->parcel_id);
            $parcel->status         = ParcelStatus::PICKUP_ASSIGN;
            $parcel->save();

            $event                  = new ParcelEvent();
            $event->parcel_id       = $parcel->id;
            $event->pickup_man_id   = $request->delivery_man_id;
            $event->note            = $request->note;
            $event->parcel_status   = ParcelStatus::PICKUP_ASSIGN;
            $event->created_by      = Auth::user()->id;
            $event->save();

            $data = [
                'message'   => 'Pickup assigned has been successfully',
                'parcel_id' => $parcel->id,
                // 'url'       => route('parcel.details', $parcel->id),
            ];

            $event->pickupman->user->notify(new StoreNotification($data));


            // 🔹 Merchant Notification
            $dataMerchant = [
                'message'   => 'Pickup man has been assigned for parcel ID ' . $parcel->tracking_id,
                'parcel_id' => $parcel->id,
                'url'       => route('parcel.details', $parcel->id),
            ];
            $parcel->merchant->user->notify(new StoreNotification($dataMerchant));


            if (@$request->send_sms_pickuman == 'on') {
                if (session()->has('locale') && session()->get('locale') == 'bn') :
                    $msg = 'প্রিয় ' . $event->pickupman->user->name . ', ' . dateFormat($parcel->pickup_date) . ' তারিখের মধ্যে ' . 'পার্সেল পিকআপ করুন । পার্সেল আইডি ' . $parcel->tracking_id . ' । পার্সেল পাঠিয়েছে (' . $parcel->merchant->business_name . ',' . $parcel->merchant->user->mobile . ',' . $parcel->merchant->address . ') - ' . settings('name');
                else :
                    $msg = 'Dear ' . $event->pickupman->user->name . ', Please pickup parcel with ID ' . $parcel->tracking_id . ' parcel from (' . $parcel->merchant->business_name . ',' . $parcel->merchant->user->mobile . ',' . $parcel->merchant->address . ') within ' . dateFormat($parcel->pickup_date) . ' -' . settings('name');
                endif;
                $response =  app(SmsService::class)->sendSms($event->pickupman->user->mobile, $msg);
            }

            try {
                $msgNotification = 'Dear ' . $event->pickupman->user->name . ', Please pickup parcel with ID ' . $parcel->tracking_id . ' parcel from (' . $parcel->merchant->business_name . ',' . $parcel->merchant->user->mobile . ',' . $parcel->merchant->address . ') within ' . dateFormat($parcel->pickup_date) . ' -' . settings('name');
                app(PushNotificationService::class)->sendStatusPushNotification($parcel, $event->pickupman->user->email, $msgNotification, 'deliveryMan');
            } catch (\Exception $exception) {
            }


            if (@$request->send_sms_merchant  == 'on') {
                if (session()->has('locale') && session()->get('locale') == 'bn') :
                    $msg = 'সম্মানিত ' . $parcel->merchant->business_name . ',  আপনার পার্সেল আইডি -' . $parcel->tracking_id . ' । ' . settings('name') . ' থেকে পিকআপ ম্যান নিয়োগ করা হয়েছে । প্রয়োজনে  পিকআপ ম্যান এর সাথে যোগাযোগ করুন । নিয়োগ দিয়েছেন ' . $event->pickupman->user->name . ', ' . $event->pickupman->user->mobile . ' । ট্র্যাক করুন: ' . url('/') . ' -' . settings('name');
                    $response =  app(SmsService::class)->sendSms($parcel->merchant->user->mobile, $msg);
                else :
                    $msg = 'Dear ' . $parcel->merchant->business_name . ', your  parcel with ID ' . $parcel->tracking_id . ' Pickup man assign from ' . settings('name') . '. Assign by ' . $event->pickupman->user->name . ', ' . $event->pickupman->user->mobile . ' Track here: ' . url('/') . ' -' . settings('name');
                    $response =  app(SmsService::class)->sendSms($parcel->merchant->user->mobile, $msg);
                endif;
            }
            try {

                $msgNotification = 'Dear ' . $parcel->merchant->business_name . ', your  parcel with ID ' . $parcel->tracking_id . ' Pickup man assign from ' . settings('name') . '. Assign by ' . $event->pickupman->user->name . ', ' . $event->pickupman->user->mobile . ' Track here: ' . url('/') . ' -' . settings('name');
                app(PushNotificationService::class)->sendStatusPushNotification($parcel, $parcel->merchant->user->email, $msgNotification, 'merchant');
            } catch (\Exception $exception) {
            }

            DB::commit();
            return $this->responseWithSuccess(___('parcel.pickup_man_assigned'), []);
        } catch (\Throwable $th) {
            DB::rollBack();
            return $this->responseWithError(___('alert.something_went_wrong'), []);
        }
    }

    public function PickupReSchedule($request)
    {
        try {

            DB::beginTransaction();

            $date                            = Carbon::parse($request->date);

            $parcel                          = $this->model::find($request->parcel_id);
            $parcel->pickup_date             = $request->date;

            //Pickup & Delivery Time
            if ($parcel->delivery_type_id == DeliveryType::SAMEDAY) {
                if (date('H') < DeliveryTime::LAST_TIME) {
                    $parcel->delivery_date    = $request->date;
                } else {
                    $parcel->delivery_date    = $date->add(1, 'day')->format('Y-m-d');
                }
            } elseif ($parcel->delivery_type_id == DeliveryType::NEXTDAY) {
                if (date('H') < DeliveryTime::LAST_TIME) {
                    $parcel->delivery_date    = $date->add(1, 'day')->format('Y-m-d');
                } else {
                    $parcel->delivery_date    = $date->add(2, 'day')->format('Y-m-d');;
                }
            } elseif ($parcel->delivery_type_id == DeliveryType::SUBCITY) {
                if (date('H') < DeliveryTime::LAST_TIME) {
                    $parcel->delivery_date    = $date->add(DeliveryTime::SUBCITY, 'day')->format('Y-m-d');
                } else {
                    $parcel->delivery_date    = $date->add(DeliveryTime::SUBCITY + 1, 'day')->format('Y-m-d');
                }
            } elseif ($parcel->delivery_type_id == DeliveryType::OUTSIDECITY) {
                if (date('H') < DeliveryTime::LAST_TIME) {
                    $parcel->delivery_date    = $date->add(DeliveryTime::OUTSIDECITY, 'day')->format('Y-m-d');
                } else {
                    $parcel->delivery_date    = $date->add(DeliveryTime::OUTSIDECITY + 1, 'day')->format('Y-m-d');
                }
            }

            // End Pickup & Delivery Time
            $parcel->status = ParcelStatus::PICKUP_RE_SCHEDULE;
            $parcel->save();

            $event                = new ParcelEvent();
            $event->parcel_id     = $parcel->id;
            $event->pickup_man_id = $request->delivery_man_id;
            $event->note          = $request->note;
            $event->parcel_status = ParcelStatus::PICKUP_RE_SCHEDULE;
            $event->created_by    = Auth::user()->id;
            $event->save();

            $data = [
                'message'    => 'Assign Pickup',
                'parcel_id'  => $parcel->id,
                // 'url'        => route('parcel.details', $parcel->id),
            ];

            $event->pickupman->user->notify(new StoreNotification($data));

            if (@$request->send_sms_pickuman == 'on') {
                if (session()->has('locale') && session()->get('locale') == 'bn') :
                    $msg = 'প্রিয় ' . $event->pickupman->user->name . ', ' . dateFormat($parcel->pickup_date) . ' তারিখের মধ্যে ' . 'পার্সেল পিকআপ করুন । পার্সেল আইডি - ' . $parcel->tracking_id . ' । পার্সেল পাঠিয়েছে (' . $parcel->merchant->business_name . ',' . $parcel->merchant->user->mobile . ',' . $parcel->merchant->address . ')' . ' - ' . settings('name');
                    $response =  app(SmsService::class)->sendSms($event->pickupman->user->mobile, $msg);
                else :
                    $msg = 'Dear ' . $event->pickupman->user->name . ', Please pickup parcel with ID ' . $parcel->tracking_id . ' parcel from (' . $parcel->merchant->business_name . ',' . $parcel->merchant->user->mobile . ',' . $parcel->merchant->address . ') within ' . dateFormat($parcel->pickup_date) . ' -' . settings('name');
                    $response =  app(SmsService::class)->sendSms($event->pickupman->user->mobile, $msg);
                endif;
            }

            if (@$request->send_sms_merchant  == 'on') {
                if (session()->has('locale') && session()->get('locale') == 'bn') :

                    $msg = 'সম্মানিত ' . $parcel->merchant->business_name . ', আপনার পার্সেল আইডি - ' . $parcel->tracking_id . ' , ' . settings('name') . ' থেকে পিকআপ ম্যান পুনরায় নিয়োগ করা হয়েছে । প্রয়োজনে  পিকআপ ম্যান এর সাথে যোগাযোগ করুন । নিয়োগ দিয়েছেন ' . $event->pickupman->user->name . ', ' . $event->pickupman->user->mobile . ' ট্র্যাক করুন: ' . url('/') . ' -' . settings('name');
                    $response =  app(SmsService::class)->sendSms($parcel->merchant->user->mobile, $msg);
                else :
                    $msg = 'Dear' . $parcel->merchant->business_name . ', your  parcel with ID ' . $parcel->tracking_id . ' Pickup man assign from ' . settings('name') . '. Assign by' . $event->pickupman->user->name . ', ' . $event->pickupman->user->mobile . ' Track here: ' . url('/') . ' -' . settings('name');
                    $response =  app(SmsService::class)->sendSms($parcel->merchant->user->mobile, $msg);
                endif;
            }

            try {
                $msgNotification = 'Dear ' . $event->pickupman->user->name . ', Please pickup parcel with ID ' . $parcel->tracking_id . ' parcel from (' . $parcel->merchant->business_name . ',' . $parcel->merchant->user->mobile . ',' . $parcel->merchant->address . ') within ' . dateFormat($parcel->pickup_date) . ' -' . settings('name');
                app(PushNotificationService::class)->sendStatusPushNotification($parcel, $event->pickupman->user->email, $msgNotification, 'deliveryMan');
            } catch (\Exception $exception) {
            }
            try {
                $msgNotification = 'Dear ' . $parcel->merchant->business_name . ', your  parcel with ID ' . $parcel->tracking_id . ' Pickup man assign from ' . settings('name') . '. Assign by ' . $event->pickupman->user->name . ', ' . $event->pickupman->user->mobile . ' Track here: ' . url('/') . ' -' . settings('name');
                app(PushNotificationService::class)->sendStatusPushNotification($parcel, $parcel->merchant->user->email, $msgNotification, 'merchant');
            } catch (\Exception $exception) {
            }
            DB::commit();
            return $this->responseWithSuccess(___('parcel.pickup_scheduled'), []);
        } catch (\Throwable $th) {
            DB::rollBack();
            return $this->responseWithError(___('alert.something_went_wrong'), []);
        }
    }

    public function receivedByPickupMan($id, $request)
    {
        try {
            DB::beginTransaction();

            $parcel               = $this->model::find($id);
            $parcel->status       = ParcelStatus::RECEIVED_BY_PICKUP_MAN;
            $parcel->save();

            $event                = new ParcelEvent();
            $event->parcel_id     = $parcel->id;
            $event->note          = $request->note;
            $event->parcel_status = $parcel->status;
            $event->created_by    = Auth::user()->id;
            $event->save();

            DB::commit();

            return $this->responseWithSuccess(___('parcel.received_by_pickup_success'), []);
        } catch (\Throwable $th) {
            DB::rollBack();
            return $this->responseWithError(___('alert.something_went_wrong'), []);
        }
    }


    public function receivedByHub($request)
    {
        try {
            DB::beginTransaction();

            $parcel                 = $this->model::find($request->parcel_id);
            $parcel->hub_id         = $parcel->transfer_hub_id;
            $parcel->status         = ParcelStatus::RECEIVED_BY_HUB;
            $parcel->save();

            $event                  = new ParcelEvent();
            $event->parcel_id       = $parcel->id;
            $event->hub_id          = $parcel->hub_id;
            $event->note            = $request->note;
            $event->parcel_status   = ParcelStatus::RECEIVED_BY_HUB;
            $event->created_by      = Auth::user()->id;
            $event->save();

            DB::commit();
            return $this->responseWithSuccess(___('parcel.received_by_hub'), []);
        } catch (\Throwable $th) {
            DB::rollBack();
            return $this->responseWithError(___('alert.something_went_wrong'), []);
        }
    }


    public function transferToHubMultipleParcel($request)
    {
        try {
            DB::beginTransaction();

            foreach ($request->parcel_ids as $id) {
                $transferToHub                           = new ParcelEvent();
                $transferToHub->parcel_id                = $id;
                $transferToHub->hub_id                   = $request->hub_id;
                $transferToHub->transfer_delivery_man_id = $request->delivery_man_id;
                $transferToHub->note                     = $request->note;
                $transferToHub->parcel_status            = ParcelStatus::TRANSFER_TO_HUB;
                $transferToHub->created_by               = Auth::user()->id;
                $transferToHub->save();

                $parcel                                  = $this->model::find($id);
                $parcel->transfer_hub_id                 = $request->hub_id;
                $parcel->status                          = ParcelStatus::TRANSFER_TO_HUB;
                $parcel->save();
            }

            DB::commit();
            return $this->responseWithSuccess(___('parcel.transfer_to_hub_success'), []);
        } catch (\Throwable $th) {
            DB::rollBack();
            return $this->responseWithError(___('alert.something_went_wrong'), []);
        }
    }

    public function deliveryManAssignMultipleParcel($request)
    {
        try {
            DB::beginTransaction();

            foreach ($request->parcel_ids_ as $id) {

                $parcel                 = $this->model::find($id);
                $parcel->status         = ParcelStatus::DELIVERY_MAN_ASSIGN;
                $parcel->save();

                $event                  = new ParcelEvent();
                $event->parcel_id       = $parcel->id;
                $event->delivery_man_id = $request->delivery_man_id;
                $event->note            = $request->note;
                $event->parcel_status   = ParcelStatus::DELIVERY_MAN_ASSIGN;
                $event->created_by      = Auth::user()->id;
                $event->save();

                if (@$request->send_sms == 'on') {
                    if (session()->has('locale') && session()->get('locale') == 'bn') :
                        $msg = 'প্রিয় ' . $parcel->customer_name . ', পার্সেল আইডি - ' . $parcel->tracking_id . ' ।  পার্সেলটি ডেলিভারির জন্য ডেলিভারি ম্যান  নিয়োগ করা হয়েছে (' . $event->deliveryMan->user->name . ', ' . $event->deliveryMan->user->mobile . ') । পার্সেল পাঠিয়েছেন (' . $parcel->merchant->business_name . ') পার্সেলের পরিষোদ মুল্য (' . $parcel->cash_collection . ') টাকা । ট্র্যাক করুন:' . url('/') . '  -' . settings('name');
                    else :
                        $msg = 'Dear ' . $parcel->customer_name . ', parcel with ID ' . $parcel->tracking_id . ' from (' . $parcel->merchant->business_name . ') TK(' . $parcel->cash_collection . ') delivery man assing by ' . $event->deliveryMan->user->name . ', ' . $event->deliveryMan->user->mobile . '. Track here:' . url('/') . '  -' . settings('name');
                    endif;
                    $response =  app(SmsService::class)->sendSms($parcel->customer_phone, $msg);
                }
            }

            DB::commit();
            return $this->responseWithSuccess(___('parcel.delivery_man_assign_success'), []);
        } catch (\Throwable $th) {
            DB::rollBack();
            return $this->responseWithError(___('alert.something_went_wrong'), []);
        }
    }


    public function transferToHub($request)
    {
        // dd($request);
        try {
            DB::beginTransaction();

            $parcel                          = $this->model::find($request->parcel_id);
            $parcel->transfer_hub_id         = $request->hub_id;
            $parcel->status                  = ParcelStatus::TRANSFER_TO_HUB;
            $parcel->save();

            $event                           = new ParcelEvent();
            $event->parcel_id                = $parcel->id;
            $event->hub_id                   = $parcel->hub_id;
            $event->transfer_delivery_man_id = $request->delivery_man_id;
            $event->note                     = $request->note;
            $event->parcel_status            = ParcelStatus::TRANSFER_TO_HUB;
            $event->created_by               = Auth::user()->id;
            $event->save();

            DB::commit();
            return $this->responseWithSuccess(___('parcel.transfer_to_hub_success'), []);
        } catch (\Throwable $th) {
            DB::rollBack();
            return $this->responseWithError(___('alert.something_went_wrong'), []);
        }
    }

    public function deliverymanAssign($request)
    {
        try {
            DB::beginTransaction();

            $parcel                 = $this->model::find($request->parcel_id);
            $parcel->status         = ParcelStatus::DELIVERY_MAN_ASSIGN;
            $parcel->save();

            $event                  = new ParcelEvent();
            $event->parcel_id       = $parcel->id;
            $event->delivery_man_id = $request->delivery_man_id;
            $event->note            = $request->note;
            $event->parcel_status   = ParcelStatus::DELIVERY_MAN_ASSIGN;
            $event->created_by      = Auth::user()->id;
            $event->save();

            $data = [
                'message'    => 'Delivery assigned has been successfully',
                'parcel_id'  => $parcel->id,
                // 'url'        => route('parcel.details', $parcel->id),
            ];

            $event->deliveryman->user->notify(new StoreNotification($data));

            if (@$request->send_sms == 'on') {

                if (session()->has('locale') && session()->get('locale') == 'bn') :
                    $msg = 'প্রিয় ' . $parcel->customer_name . ', পার্সেল আইডি - ' . $parcel->tracking_id . ' ।  পার্সেলটি ডেলিভারির জন্য ডেলিভারি ম্যান  নিয়োগ করা হয়েছে (' . $event->deliveryMan->user->name . ', ' . $event->deliveryMan->user->mobile . ') । পার্সেল পাঠিয়েছেন (' . $parcel->merchant->business_name . ') পার্সেলের পরিষোদ মুল্য (' . $parcel->cash_collection . ') টাকা । ট্র্যাক করুন:' . url('/') . '  -' . settings('name');
                else :
                    $msg = 'Dear ' . $parcel->customer_name . ', parcel with ID ' . $parcel->tracking_id . ' from (' . $parcel->merchant->business_name . ') TK(' . $parcel->cash_collection . ') delivery man assing by ' . $event->deliveryMan->user->name . ', ' . $event->deliveryMan->user->mobile . '. Track here:' . url('/') . '  -' . settings('name');
                endif;
                $response =  app(SmsService::class)->sendSms($parcel->customer_phone, $msg);
            }

            try {
                $msgNotification = 'Dear ' . $event->deliveryMan->user->name . ', your  parcel with ID ' . $parcel->tracking_id . ' Track here: ' . url('/') . ' -' . settings('name');
                app(PushNotificationService::class)->sendStatusPushNotification($parcel, $event->deliveryMan->user->email, $msgNotification, 'deliveryMan');
            } catch (\Exception $exception) {
            }

            DB::commit();
            return $this->responseWithSuccess(___('parcel.delivery_man_assign_success'), []);
        } catch (\Throwable $th) {
            DB::rollBack();
            return $this->responseWithError(___('alert.something_went_wrong'), []);
        }
    }


    public function deliveryReschedule($request)
    {
        try {
            DB::beginTransaction();

            ParcelEvent::where('parcel_id', $request->parcel_id)->whereIn('parcel_status', [parcelStatus::DELIVERY_MAN_ASSIGN, parcelStatus::DELIVERY_RE_SCHEDULE])->delete();

            $parcel                = $this->model::find($request->parcel_id);
            $parcel->delivery_date = $request->date;
            $parcel->status        = ParcelStatus::DELIVERY_RE_SCHEDULE;
            $parcel->save();

            $event                  = new ParcelEvent();
            $event->parcel_id       = $parcel->id;
            $event->delivery_man_id = $request->delivery_man_id;
            $event->note            = $request->note;
            $event->parcel_status   = ParcelStatus::DELIVERY_RE_SCHEDULE;
            $event->created_by      = Auth::user()->id;
            $event->save();



            $data = [
                'message'    => 'Assign Delivery',
                'parcel_id'  => $parcel->id,
                // 'url'        => route('parcel.details', $parcel->id),
            ];

            $event->deliveryman->user->notify(new StoreNotification($data));

            if (@$request->send_sms == 'on') {
                if (session()->has('locale') && session()->get('locale') == 'bn') :
                    $msg = 'প্রিয় ' . $parcel->customer_name . ', পার্সেল আইডি - ' . $parcel->tracking_id . ' ।  পার্সেলটি ডেলিভারির জন্য পূনরায় ডেলিভারি ম্যান  নিয়োগ করা হয়েছে (' . $event->deliveryMan->user->name . ', ' . $event->deliveryMan->user->mobile . ') । পার্সেল পাঠিয়েছেন (' . $parcel->merchant->business_name . ') পার্সেলের পরিষোদ মুল্য (' . $parcel->cash_collection . ') টাকা । ট্র্যাক করুন:' . url('/') . '  -' . settings('name');

                else :
                    $msg = 'Dear ' . $parcel->customer_name . ', Your  parcel with ID ' . $parcel->tracking_id . '  is re-schedule  from (' . $parcel->merchant->business_name . ') TK(' . $parcel->cash_collection . ') delivery man assign by ' . $event->deliveryMan->user->name . ', ' . $event->deliveryMan->user->mobile . '. Track here:' . url('/') . '  -' . settings('name');
                endif;
                $response =  app(SmsService::class)->sendSms($parcel->customer_phone, $msg);
            }
            try {
                $msgNotification = 'Dear ' . $event->deliveryMan->user->name . ', your  parcel with ID ' . $parcel->tracking_id . ' Track here: ' . url('/') . ' -' . settings('name');
                app(PushNotificationService::class)->sendStatusPushNotification($parcel, $event->deliveryMan->user->email, $msgNotification, 'deliveryMan');
            } catch (\Exception $exception) {
            }

            DB::commit();
            return $this->responseWithSuccess(___('parcel.delivery_reschedule_success'), []);
        } catch (\Throwable $th) {
            DB::rollBack();
            return $this->responseWithError(___('alert.something_went_wrong'), []);
        }
    }

    public function receivedWarehouse($request)
    {
        try {
            DB::beginTransaction();

            $parcel                             = $this->model::find($request->parcel_id);
            $parcel->hub_id                     = $request->hub_id;
            $parcel->status                     = ParcelStatus::RECEIVED_WAREHOUSE;
            $parcel->save();

            $receivedWarehouse                 = new ParcelEvent();
            $receivedWarehouse->parcel_id      = $parcel->id;
            $receivedWarehouse->hub_id         = $parcel->hub_id;
            $receivedWarehouse->note           = $request->note;
            $receivedWarehouse->parcel_status  = ParcelStatus::RECEIVED_WAREHOUSE;
            $receivedWarehouse->created_by     = Auth::user()->id;
            $receivedWarehouse->save();

            $event = ParcelEvent::where('parcel_id', $parcel->id)->where(fn($event) => $event->where('parcel_status', ParcelStatus::PICKUP_ASSIGN)->orWhere('parcel_status', ParcelStatus::PICKUP_RE_SCHEDULE))->latest()->first();

            $heroCommission                     = DeliveryHeroCommission::where('parcel_id', $parcel->id)->where('pickup_hero_id', $event->pickup_man_id)->where('payment_status', PaymentStatus::UNPAID)->first();
            if ($heroCommission) {
                $heroCommission->amount         = $heroCommission->amount + $this->chargeRepo->getHeroCharge($parcel->charge_id, $parcel->quantity);
            } else {
                $heroCommission                 = new DeliveryHeroCommission();
                $heroCommission->amount         = $this->chargeRepo->getHeroCharge($parcel->charge_id, $parcel->quantity);
            }

            $heroCommission->parcel_id          = $parcel->id;
            $heroCommission->pickup_hero_id     = $event->pickup_man_id;
            $heroCommission->payment_status     = PaymentStatus::UNPAID;
            $heroCommission->status             = Status::ACTIVE;
            $heroCommission->save();

            DB::commit();

            if (@$request->send_sms_customer == 'on') {
                if (session()->has('locale') && session()->get('locale') == 'bn') :
                    $msg = 'প্রিয় ' . $parcel->customer_name . ', আমরা আইডি সহ একটি পার্সেল পেয়েছি , পার্সেল আইডি - ' . $parcel->tracking_id . ', পার্সেল পাঠিয়েছেন (' . $parcel->merchant->business_name . ') এবং যত তাড়াতাড়ি সম্ভব বিতরণ করা হবে । ট্র্যাক করুন:' . url('/') . '  -' . settings('name');
                    $response =  app(SmsService::class)->sendSms($parcel->customer_phone, $msg);
                else :
                    $msg = 'Dear ' . $parcel->customer_name . ', we received a parcel with ID ' . $parcel->tracking_id . ' from (' . $parcel->merchant->business_name . ') and will deliver as soon as possible. Track here:' . url('/') . '  -' . settings('name');
                    $response =  app(SmsService::class)->sendSms($parcel->customer_phone, $msg);
                endif;
            }

            if (@$request->send_sms_merchant  == 'on') {
                if (session()->has('locale') && session()->get('locale') == 'bn') :
                    $msg = 'সম্মানিত ' . $parcel->merchant->business_name . ', আপনার পার্সেল ' . $receivedWarehouse->hub->name . ' হাবের ওয়্যারহাউসে গ্রহন করা হয়েছে , পার্সেল আইডি - ' . $parcel->tracking_id . ' ।  ট্র্যাক করুন: ' . url('/') . ' -' . settings('name');
                    $response =  app(SmsService::class)->sendSms($parcel->merchant->user->mobile, $msg);
                else :
                    $msg = 'Dear ' . $parcel->merchant->business_name . ', your  parcel with ID ' . $parcel->tracking_id . ' Received to Warehouse ' . $receivedWarehouse->hub->name . '. Track here: ' . url('/') . ' -' . settings('name');
                    $response =  app(SmsService::class)->sendSms($parcel->merchant->user->mobile, $msg);
                endif;
            }

            try {
                $msgNotification = 'Dear ' . $parcel->merchant->business_name . ', your  parcel with ID ' . $parcel->tracking_id . ' Received to Warehouse ' . $receivedWarehouse->hub->name . '. Track here: ' . url('/') . ' -' . settings('name');
                app(PushNotificationService::class)->sendStatusPushNotification($parcel, $parcel->merchant->user->email, $msgNotification, 'merchant');
            } catch (\Exception $exception) {
            }

            return $this->responseWithSuccess(___('parcel.received_warehouse_success'), []);
        } catch (\Throwable $th) {
            DB::rollBack();
            return $this->responseWithError(___('alert.something_went_wrong'), []);
        }
    }

    public function receivedWarehouseCancel($id)
    {
        try {
            DB::beginTransaction();

            $parcel = $this->model::find($id);

            if ($parcel->status == ParcelStatus::RECEIVED_WAREHOUSE) {
                $event  = ParcelEvent::where(['parcel_id' => $id, 'parcel_status' => $parcel->status])->first();
                ParcelEvent::destroy($event->id);
            }

            $event = ParcelEvent::where('parcel_id', $parcel->id)->where(fn($event) => $event->where('parcel_status', ParcelStatus::PICKUP_ASSIGN)->orWhere('parcel_status', ParcelStatus::PICKUP_RE_SCHEDULE))->latest()->first();

            $parcel->status = $event->parcel_status;
            $parcel->save();

            $heroCommission = DeliveryHeroCommission::where('parcel_id', $parcel->id)->where('pickup_hero_id', $event->pickup_man_id)->where('payment_status', PaymentStatus::UNPAID)->first();
            if ($heroCommission) {
                $heroCommission->amount     = $heroCommission->amount - $this->chargeRepo->getHeroCharge($parcel->charge_id, $parcel->quantity);
                $heroCommission->status     = Status::INACTIVE;
                $heroCommission->save();
            }

            DB::commit();
            return $this->responseWithSuccess(___('parcel.received_warehouse_cancel'), []);
        } catch (\Throwable $th) {
            DB::rollBack();
            return $this->responseWithError(___('alert.something_went_wrong'), []);
        }
    }

    public function returnToCourier($id, $request)
    {
        try {

            DB::beginTransaction();

            $parcel               = $this->model::find($id);
            $parcel->status       = ParcelStatus::RETURN_TO_COURIER;
            $parcel->save();

            $event                = new ParcelEvent();
            $event->parcel_id     = $id;
            $event->note          = $request->note;
            $event->parcel_status = ParcelStatus::RETURN_TO_COURIER;
            $event->created_by    = Auth::user()->id;
            $event->save();

            DB::commit();
            return $this->responseWithSuccess(___('parcel.return_to_qourier_success'), []);
        } catch (\Throwable $th) {
            DB::rollBack();
            return $this->responseWithError(___('alert.something_went_wrong'), []);
        }
    }


    public function returnToCourierCancel($id)
    {
        try {
            $parcel = $this->model::find($id);
            if ($parcel->status == ParcelStatus::RETURN_TO_COURIER) {
                $deliverymanReschedule = ParcelEvent::where(['parcel_id' => $id, 'parcel_status' => ParcelStatus::DELIVERY_RE_SCHEDULE])->get();
                ParcelEvent::where(['parcel_id' => $id, 'parcel_status' => $parcel->status])->latest()->delete();
            }
            if ($deliverymanReschedule) {
                $parcel->status     = ParcelStatus::DELIVERY_RE_SCHEDULE;
            } else {
                $parcel->status     = ParcelStatus::DELIVERY_MAN_ASSIGN;
            }
            $parcel->save();
            return $this->responseWithSuccess(___('parcel.received_warehouse_cancel'), []);
        } catch (\Throwable $th) {
            return $this->responseWithError(___('alert.something_went_wrong'), []);
        }
    }

    public function returnAssignToMerchant($id, $request)
    {
        try {
            DB::beginTransaction();

            $parcel                = $this->model::find($id);
            $parcel->delivery_date = $request->date;
            $parcel->status        = ParcelStatus::RETURN_ASSIGN_TO_MERCHANT;
            $parcel->save();

            $event                  = new ParcelEvent();
            $event->parcel_id       = $parcel->id;
            $event->delivery_man_id = $request->delivery_man_id;
            $event->note            = $request->note;
            $event->parcel_status   = ParcelStatus::RETURN_ASSIGN_TO_MERCHANT;
            $event->created_by      = Auth::user()->id;
            $event->save();

            DB::commit();

            if (@$request->send_sms == 'on') {
                if (session()->has('locale') && session()->get('locale') == 'bn') :
                    $msg = 'সম্মানিত ' . $parcel->merchant->business_name . ', পার্সেল আইডি - ' . $parcel->tracking_id . ', আপনার পার্সেলটি (' . $event->deliveryMan->user->name . ', ' . $event->deliveryMan->user->mobile . ') দ্বারা আপনার কাছে পূনরায়  পাঠানো হয়েছে  ' . ',' . 'পরিদর্শন করুন:' . url('/') . '  -' . settings('name');
                else :
                    $msg = 'Dear ' . $parcel->merchant->business_name . ', parcel with ID ' . $parcel->tracking_id . ' is return to you by ' . $event->deliveryMan->user->name . ', ' . $event->deliveryMan->user->mobile . '. visit:' . url('/') . '  -' . settings('name');
                endif;
                $response =  app(SmsService::class)->sendSms($parcel->merchant->user->mobile, $msg);
            }

            try {
                $msgNotification = 'Dear ' . $parcel->merchant->business_name . ', parcel with ID ' . $parcel->tracking_id . ' is return to you by ' . $event->deliveryMan->user->name . ', ' . $event->deliveryMan->user->mobile . '. visit:' . url('/') . '  -' . settings('name');
                app(PushNotificationService::class)->sendStatusPushNotification($parcel, $parcel->merchant->user->email, $msgNotification, 'merchant');
            } catch (\Exception $exception) {
            }

            DB::commit();
            return $this->responseWithSuccess(___('parcel.return_assign_to_merchant_success'), []);
        } catch (\Throwable $th) {
            DB::rollBack();
            return $this->responseWithError(___('alert.something_went_wrong'), []);
        }
    }

    public function returnAssignToMerchantCancel($id)
    {
        try {
            DB::beginTransaction();

            $parcel = $this->model::find($id);
            if ($parcel->status == ParcelStatus::RETURN_ASSIGN_TO_MERCHANT) {
                $event = ParcelEvent::where(['parcel_id' => $id, 'parcel_status' => ParcelStatus::RETURN_ASSIGN_TO_MERCHANT])->first();
                ParcelEvent::destroy($event->id);
            }
            $parcel->status = ParcelStatus::RETURN_TO_COURIER;
            $parcel->save();

            DB::commit();
            return $this->responseWithSuccess(___('parcel.return_assign_to_merchant_cancel_success'), []);
        } catch (\Throwable $th) {
            DB::rollBack();
            return $this->responseWithError(___('alert.something_went_wrong'), []);
        }
    }

    public function returnAssignToMerchantReschedule($id, $request)
    {
        try {

            DB::beginTransaction();

            $returnassigntomerchant                  = new ParcelEvent();
            $returnassigntomerchant->parcel_id       = $id;
            $returnassigntomerchant->delivery_man_id = $request->delivery_man_id;
            $returnassigntomerchant->note            = $request->note;
            $returnassigntomerchant->parcel_status   = ParcelStatus::RETURN_MERCHANT_RE_SCHEDULE;
            $returnassigntomerchant->created_by      = Auth::user()->id;
            $returnassigntomerchant->save();
            $parcel                = $this->model::find($id);
            $parcel->delivery_date = $request->date;
            $parcel->status        = ParcelStatus::RETURN_MERCHANT_RE_SCHEDULE;
            $parcel->save();

            if (@$request->send_sms == 'on') {
                if (session()->has('locale') && session()->get('locale') == 'bn') :
                    $msg = 'প্রিয় ' . $parcel->merchant->business_name . ', পার্সেল আইডি -  ' . $parcel->tracking_id . ', আপনার পার্সেলটি পূনরায় (' . $returnassigntomerchant->deliveryMan->user->name . ', ' . $returnassigntomerchant->deliveryMan->user->mobile . ') দ্বারা আপনার কাছে পাঠানো হয়েছে , পরিদর্শন করুন: ' . url('/') . '  -' . settings('name');
                else :
                    $msg = 'Dear ' . $parcel->merchant->business_name . ', parcel with ID ' . $parcel->tracking_id . ' is return to you by ' . $returnassigntomerchant->deliveryMan->user->name . ', ' . $returnassigntomerchant->deliveryMan->user->mobile . '. visit: ' . url('/') . '  -' . settings('name');
                endif;
                $response =  app(SmsService::class)->sendSms($parcel->merchant->user->mobile, $msg);
            }
            DB::commit();
            return $this->responseWithSuccess(___('parcel.return_assign_to_merchant_reschedule_success'), []);
        } catch (\Throwable $th) {
            DB::rollBack();
            return $this->responseWithError(___('alert.something_went_wrong'), []);
        }
    }

    public function returnAssignToMerchantRescheduleCancel($id)
    {
        try {
            $parcel = $this->model::find($id);
            if ($parcel->status == ParcelStatus::RETURN_MERCHANT_RE_SCHEDULE) {
                $merchantReschedule = ParcelEvent::where(['parcel_id' => $id, 'parcel_status' => $parcel->status])->delete();
            }
            $parcel->status  = ParcelStatus::RETURN_ASSIGN_TO_MERCHANT;
            $parcel->save();
            return $this->responseWithSuccess(___('parcel.return_assign_to_merchant_reschedule_cancel_success'), []);
        } catch (\Throwable $th) {
            return $this->responseWithError(___('alert.something_went_wrong'), []);
        }
    }


    public function returnReceivedByMerchant($id, $request)
    {
        // dd('here');
        try {

            DB::beginTransaction();

            $parcel                 = $this->model::with('charge:id,return_charge')->find($id);
            $parcel->status         = ParcelStatus::RETURN_RECEIVED_BY_MERCHANT;
            $parcel->save();

            $transaction                    = ParcelTransaction::where('parcel_id', $parcel->id)->first();
            $transaction->return_charges    = ($transaction->total_charge * $parcel->charge->return_charge) / 100;
            $vat                            = ($transaction->return_charges * $parcel->vat) / 100; // calculate return_charges vat
            $transaction->vat_amount        = $transaction->vat_amount + $vat; // update vat amount
            $transaction->total_charge      = $transaction->total_charge + $transaction->return_charges + $vat; // total charge with vat
            $transaction->current_payable   = $transaction->cash_collection - $transaction->total_charge;
            $transaction->save();

            $event = ParcelEvent::where('parcel_id', $parcel->id)->where(fn($event) => $event->where('parcel_status', ParcelStatus::DELIVERY_MAN_ASSIGN)->orWhere('parcel_status', ParcelStatus::DELIVERY_RE_SCHEDULE))->latest()->first();

            $heroCommission                     = DeliveryHeroCommission::where('parcel_id', $parcel->id)->where('delivery_hero_id', $event->delivery_man_id)->where('payment_status', PaymentStatus::UNPAID)->first();
            if ($heroCommission) {
                $heroCommission->amount         = $heroCommission->amount + $this->chargeRepo->getHeroCharge($parcel->charge_id, $parcel->quantity);
            } else {
                $heroCommission                 = new DeliveryHeroCommission();
                $heroCommission->amount         = $this->chargeRepo->getHeroCharge($parcel->charge_id, $parcel->quantity);
            }

            $heroCommission->parcel_id          = $parcel->id;
            $heroCommission->delivery_hero_id   = $event->delivery_man_id;
            $heroCommission->payment_status     = PaymentStatus::UNPAID;
            $heroCommission->status             = Status::ACTIVE;
            $heroCommission->save();


            $event                 = new ParcelEvent();
            $event->parcel_id      = $id;
            $event->note           = $request->note;
            $event->parcel_status  = ParcelStatus::RETURN_RECEIVED_BY_MERCHANT;
            $event->created_by     = Auth::user()->id;
            $event->save();

            DB::commit();
            return $this->responseWithSuccess(___('parcel.return_received_by_merchant'), []);
        } catch (\Throwable $th) {
            DB::rollBack();
            return $this->responseWithError(___('alert.something_went_wrong'), []);
        }
    }

    public function returnReceivedByMerchantCancel($id)
    {
        try {
            DB::beginTransaction();

            ParcelEvent::where(['parcel_id' => $id, 'parcel_status' => ParcelStatus::RETURN_RECEIVED_BY_MERCHANT])->delete();

            $event          = ParcelEvent::where('parcel_id', $id)->where(fn($event) => $event->where('parcel_status', ParcelStatus::RETURN_ASSIGN_TO_MERCHANT)->orWhere('parcel_status', ParcelStatus::RETURN_MERCHANT_RE_SCHEDULE))->latest()->first();

            $parcel         = $this->model::find($event->parcel_id);
            $parcel->status = $event->parcel_status;
            $parcel->save();

            $transaction                    = ParcelTransaction::where('parcel_id', $parcel->id)->first();
            $vat                            = ($transaction->return_charges * $parcel->vat) / 100; // calculate return_charges vat
            $transaction->vat_amount        = $transaction->vat_amount - $vat; // update vat amount
            $transaction->total_charge      = $transaction->total_charge - $transaction->return_charges - $vat; // total charge with vat
            $transaction->current_payable   = $transaction->cash_collection - $transaction->total_charge;
            $transaction->return_charges    = 0; // finally back to 0
            $transaction->save();

            $heroCommission                 = DeliveryHeroCommission::where('parcel_id', $parcel->id)->where('delivery_hero_id', $event->delivery_man_id)->where('payment_status', PaymentStatus::UNPAID)->first();
            if ($heroCommission) {
                $heroCommission->amount     = $heroCommission->amount - $this->chargeRepo->getHeroCharge($parcel->charge_id, $parcel->quantity);
                $heroCommission->status     = Status::INACTIVE;
                $heroCommission->save();
            }

            DB::commit();
            return $this->responseWithSuccess(___('parcel.return_received_by_merchant_cancel_success'), []);
        } catch (\Throwable $th) {
            DB::rollBack();
            return $this->responseWithError(___('alert.something_went_wrong'), []);
        }
    }

    public function parcelDelivered($request)
    {
        if (auth()->user()->user_type == UserType::DELIVERYMAN) {
            $check_otp = ParcelStatusUpdate::where('parcel_id', $request->parcel_id)->where('otp',  $request->otp)->first();
            if (!$check_otp) {
                return $this->responseWithError(___('alert.invalid_otp'));
            }
            $check_otp->delete();
        }

        $event    = ParcelEvent::where('parcel_id', $request->parcel_id)->whereIn('parcel_status', [ParcelStatus::DELIVERY_MAN_ASSIGN, ParcelStatus::DELIVERY_RE_SCHEDULE])->latest()->first();
        $hub_id   = ParcelEvent::where('parcel_id', $request->parcel_id)->where('parcel_status', ParcelStatus::RECEIVED_WAREHOUSE)->latest()->value('hub_id');



        try {

            DB::beginTransaction();

            $parcel                 = $this->model::find($request->parcel_id);
            if ($parcel->status !=  $event->parcel_status) {
                return $this->responseWithError(___('alert.something_went_wrong'), []);
            }
            $parcel->status         = ParcelStatus::DELIVERED;
            $parcel->delivery_date  = now();
            $parcel->save();

            $event                  = new ParcelEvent();
            $event->parcel_id       = $parcel->id;
            $event->delivery_man_id = $event->delivery_man_id;
            $event->hub_id          = $hub_id;
            $event->note            = $request->note;
            $event->parcel_status   = ParcelStatus::DELIVERED;
            $event->created_by      = Auth::user()->id;
            $event->save();


            // 🔹 Merchant Notification
            $data = [
                'message'   => 'Your parcel ID ' . $parcel->tracking_id . ' has been delivered successfully.',
                'parcel_id' => $parcel->id,
                'url'       => route('parcel.details', $parcel->id),
            ];

            $parcel->merchant->user->notify(new StoreNotification($data));



            if (@$request->send_sms_customer == 'on') {

                if (session()->has('locale') && session()->get('locale') == 'bn') :
                    $msg = 'প্রিয় ' . $parcel->customer_name . ', আপনার পার্সেল আইডি - ' . $parcel->tracking_id . ' সফলভাবে বিতরণ করা হয়েছে । টাকা প্রদান করেছেন ' . $parcel->cash_collection . ' টাকা । আপনার অভিজ্ঞতা রেট করুন । পরিদর্শন করুন:' . url('/') . '  -' . settings('name');
                else :
                    $msg = 'Dear Customer, Your parcel with ID ' . $parcel->tracking_id . ' is successfully delivered. To rate your experience visit:' . url('/') . '  -' . settings('name');
                endif;
                $response = app(SmsService::class)->sendSms($parcel->customer_phone, $msg);
            }
            if (@$request->send_sms_merchant  == 'on') {
                if (session()->has('locale') && session()->get('locale') == 'bn') :

                    $msg = 'সম্মানিত ' . $parcel->merchant->business_name . ', আপনার পার্সেল আইডি - ' . $parcel->tracking_id . ' সফলভাবে বিতরণ করা হয়েছে । ক্রেতা- ' . $parcel->customer_name . ', ' . $parcel->customer_phone . ' । এই পার্সেলটির ডেলিভারি ম্যান ' . $parcel->cash_collection . ' টাকা গ্রহন করেছেন । পরিদর্শন করুন: ' . url('/') . ' -' . settings('name');
                else :
                    $msg = 'Dear Merchant, your  parcel with ID ' . $parcel->tracking_id . ' is successfully delivered. Customer ' . $parcel->customer_name . ', ' . $parcel->customer_phone . ' Track here: ' . url('/') . ' -' . settings('name');
                endif;
                $response =  app(SmsService::class)->sendSms($parcel->merchant->user->mobile, $msg);
            }

            try {
                $msgNotification = 'Dear Merchant, your  parcel with ID ' . $parcel->tracking_id . ' is successfully delivered. Customer ' . $parcel->customer_name . ', ' . $parcel->customer_phone . ' Track here: ' . url('/') . ' -' . settings('name');
                app(PushNotificationService::class)->sendStatusPushNotification($parcel, $parcel->merchant->user->email, $msgNotification, 'merchant');
            } catch (\Exception $exception) {
            }

            DB::commit();

            return $this->responseWithSuccess(___('parcel.delivered_success'), ['redirect_url' => route('parcel.index')]);
        } catch (\Throwable $th) {
            DB::rollBack();
            return $this->responseWithError(___('alert.something_went_wrong'), []);
        }
    }



    public function parcelDeliveredCancel($id)
    {
        try {
            DB::beginTransaction();

            $parcel                 = $this->model::find($id);
            $parcel->delivery_date  = null;
            $parcel->status         = ParcelStatus::DELIVERY_MAN_ASSIGN;

            $reschedule             = ParcelEvent::where(['parcel_id' => $id, 'parcel_status' => ParcelStatus::DELIVERY_RE_SCHEDULE])->exists();
            if ($reschedule) {
                $parcel->status     = ParcelStatus::DELIVERY_RE_SCHEDULE;
            }

            $parcel->save();

            $event =  ParcelEvent::where(['parcel_id' => $id, 'parcel_status' => ParcelStatus::DELIVERED])->latest()->first();
            if ($event) {
                $event->delete();
            }


            if (SmsSendSettingHelper(SmsSendStatus::DELIVERED_CANCEL_CUSTOMER)) {
                if (session()->has('locale') && session()->get('locale') == 'bn') :
                    $msg = 'প্রিয় ' . $parcel->customer_name . ', আপনার পার্সেল আইডি - ' . $parcel->tracking_id . ' । ' . $parcel->merchant->business_name . ' থেকে বাতিল করা হবে । ট্র্যাক করুন: ' . url('/') . ' -' . settings('name');
                else :
                    $msg = 'Dear ' . $parcel->customer_name . ', Your parcel with ID ' . $parcel->tracking_id . ' from ' . $parcel->merchant->business_name . 'will be cancel. Track here: ' . url('/') . ' -' . settings('name');
                endif;
                $response = app(SmsService::class)->sendSms($parcel->customer_phone, $msg);
            }

            if (SmsSendSettingHelper(SmsSendStatus::DELIVERED_CANCEL_MERCHANT)) {
                if (session()->has('locale') && session()->get('locale') == 'bn') :
                    $msg = 'প্রিয় ' . $parcel->merchant->business_name . ', আপনার পার্সেল আইডি - ' . $parcel->tracking_id . ' বিতরণ করা বাতিল । ক্রেতা - ' . $parcel->customer_name . ', ' . $parcel->customer_phone . ' ট্র্যাক করুন: ' . url('/') . ' -' . settings('name');
                else :
                    $msg = 'Dear ' . $parcel->merchant->business_name . ', your  parcel with ID ' . $parcel->tracking_id . '  Delivered cancel. Customer ' . $parcel->customer_name . ', ' . $parcel->customer_phone . ' Track here: ' . url('/') . ' -' . settings('name');
                endif;
                $response =  app(SmsService::class)->sendSms($parcel->merchant->user->mobile, $msg);
            }

            try {
                $msgNotification = 'Dear ' . $parcel->merchant->business_name . ', your  parcel with ID ' . $parcel->tracking_id . '  Delivered cancel. Customer ' . $parcel->customer_name . ', ' . $parcel->customer_phone . ' Track here: ' . url('/') . ' -' . settings('name');
                app(PushNotificationService::class)->sendStatusPushNotification($parcel, $parcel->merchant->user->email, $msgNotification, 'merchant');
            } catch (\Exception $exception) {
            }

            DB::commit();
            return $this->responseWithSuccess(___('parcel.delivered_cancel'), []);
        } catch (\Throwable $th) {
            DB::rollBack();
            return $this->responseWithError(___('alert.something_went_wrong'), []);
        }
    }


    public function parcelPartialDelivered($request)
    {
        try {

            if (auth()->user()->user_type == UserType::DELIVERYMAN) {
                $check_otp = ParcelStatusUpdate::where('parcel_id', $request->parcel_id)->where('otp',  $request->otp)->first();
                if (!$check_otp) {
                    return $this->responseWithError(___('alert.invalid_otp'));
                }
                $check_otp->delete();
            }

            if (!$request->quantity || $request->quantity < 1) {
                return $this->responseWithError(___('alert.quantity_required'), []);
            }

            DB::beginTransaction();

            $event    = ParcelEvent::where('parcel_id', $request->parcel_id)->whereIn('parcel_status', [ParcelStatus::DELIVERY_MAN_ASSIGN, ParcelStatus::DELIVERY_RE_SCHEDULE])->latest()->first();

            $parcel                     = $this->model::find($request->parcel_id);

            if ($parcel->status !=  $event->parcel_status) {
                return $this->responseWithError(___('alert.something_went_wrong'), []);
            }

            $parcel->old_quantity       = $parcel->quantity;
            $parcel->quantity           = $request->quantity;
            $parcel->status             = ParcelStatus::PARTIAL_DELIVERED;
            $parcel->partial_delivered  = BooleanStatus::YES;
            $parcel->delivery_date      = now();
            $parcel->save();

            $transaction                        = ParcelTransaction::where('parcel_id', $parcel->id)->first();
            $transaction->old_cash_collection   = $transaction->cash_collection;
            $transaction->cash_collection       = $request->cash_collection;
            $transaction->cod_charge            = $transaction->cash_collection > 0 ? ($parcel->merchant->codCharges[$parcel->area] * $transaction->cash_collection) / 100 : 0; // reset cod charge
            $transaction->return_charges        = ($parcel->charge->charge * $parcel->charge->return_charge) / 100;

            $returnParcelQty                    = ($parcel->old_quantity - $parcel->quantity);
            if ($returnParcelQty > 1) {
                $additional                     = ($returnParcelQty - 1) * ($parcel->charge->additional_charge * $parcel->charge->return_charge) / 100;
                $transaction->return_charges    = $transaction->return_charges + $additional;
            }

            $transaction->liquid_fragile_charge += $transaction->liquid_fragile_charge > 0 ? ($parcel->merchant->liquidFragileRate *  $transaction->return_charges) / 100 : 0; // Add liquid_fragile_charge for return charge if any
            $transaction->total_charge          = $transaction->charge + $transaction->cod_charge + $transaction->liquid_fragile_charge +  $transaction->vas_charge + $transaction->return_charges;

            $transaction->vat_amount            = ($transaction->total_charge * $parcel->vat) / 100; // reset vat amount
            $transaction->total_charge          = $transaction->total_charge + $transaction->vat_amount; // total charge with vat
            $transaction->current_payable       = $transaction->cash_collection - $transaction->total_charge;
            $transaction->save();

            // apply hero commission
            $heroCommission                     = DeliveryHeroCommission::where('parcel_id', $parcel->id)->where('delivery_hero_id', $event->pickup_man_id)->where('payment_status', PaymentStatus::UNPAID)->first();
            if ($heroCommission) {
                $heroCommission->amount         = $heroCommission->amount + $this->chargeRepo->getHeroCharge($parcel->charge_id, $returnParcelQty);
            } else {
                $heroCommission                 = new DeliveryHeroCommission();
                $heroCommission->amount         = $this->chargeRepo->getHeroCharge($parcel->charge_id, $returnParcelQty);
            }
            $heroCommission->parcel_id          = $parcel->id;
            $heroCommission->delivery_hero_id   = $event->delivery_man_id;
            $heroCommission->payment_status     = PaymentStatus::UNPAID;
            $heroCommission->status             = Status::ACTIVE;
            $heroCommission->save();

            // Create new Parcel Event
            $event                  = new ParcelEvent();
            $event->parcel_id       = $parcel->id;
            $event->note            = $request->note;
            $event->parcel_status   = ParcelStatus::PARTIAL_DELIVERED;
            $event->created_by      = Auth::user()->id;
            $event->save();


            if (@$request->send_sms_customer == 'on') {

                if (session()->has('locale') && session()->get('locale') == 'bn') :

                    $msg = 'প্রিয় ' . $parcel->customer_name . ', আপনার পার্সেল আইডি - ' . $parcel->tracking_id . ' আংশিক বিতরণ করা হয় । টাকা প্রদান করুন (' . $parcel->cash_collection . ') টাকা এবং আপনার অভিজ্ঞতা রেট করুন । পরিদর্শন করুন:' . url('/') . '  -' . settings('name');
                else :
                    $msg = 'Dear ' . $parcel->customer_name . ', Your parcel with ID ' . $parcel->tracking_id . '  is Partials Delivered please giving amount(' . $parcel->cash_collection . ') by  To rate your experience visit:' . url('/') . '  -' . settings('name');
                endif;
                $response = app(SmsService::class)->sendSms($parcel->customer_phone, $msg);
            }

            if (@$request->send_sms_merchant  == 'on') {
                if (session()->has('locale') && session()->get('locale') == 'bn') :

                    $msg = 'প্রিয় ' . $parcel->merchant->business_name . ', আপনার পার্সেল আইডি - ' . $parcel->tracking_id . ' আংশিক বিতরণ করা হয় । ক্রেতা ' . $parcel->customer_name . ', ' . $parcel->customer_phone . ' । এই পার্সেলটির ডেলিভারি ম্যান ' . $parcel->cash_collection . ' টাকা গ্রহন করেছেন । পরিদর্শন করুন: ' . url('/') . ' -' . settings('name');
                else :
                    $msg = 'Dear ' . $parcel->merchant->business_name . ', your  parcel with ID ' . $parcel->tracking_id . ' is Partials Delivered. Customer ' . $parcel->customer_name . ', ' . $parcel->customer_phone . ' taking amount(' . $parcel->cash_collection . ')  Track here: ' . url('/') . ' -' . settings('name');
                endif;
                $response =  app(SmsService::class)->sendSms($parcel->merchant->user->mobile, $msg);
            }

            try {
                $msgNotification = 'Dear ' . $parcel->merchant->business_name . ', your  parcel with ID ' . $parcel->tracking_id . ' is Partials Delivered. Customer ' . $parcel->customer_name . ', ' . $parcel->customer_phone . ' taking amount(' . $parcel->cash_collection . ')  Track here: ' . url('/') . ' -' . settings('name');
                app(PushNotificationService::class)->sendStatusPushNotification($parcel, $parcel->merchant->user->email, $msgNotification, 'merchant');
            } catch (\Exception $exception) {
            }

            DB::commit();
            return $this->responseWithSuccess(___('parcel.delivered_success'), ['redirect_url' => route('parcel.index')]);
        } catch (\Throwable $th) {
            DB::rollBack();
            return $this->responseWithError(___('alert.something_went_wrong'), []);
        }
    }


    public function parcelPartialDeliveredCancel($id)
    {
        try {

            DB::beginTransaction();

            $parcel                 = $this->model::find($id);
            $event                  = ParcelEvent::where('parcel_id', $id)->whereIn('parcel_status', [ParcelStatus::DELIVERY_MAN_ASSIGN, ParcelStatus::DELIVERY_RE_SCHEDULE])->latest()->first();
            if ($event) {
                $parcel->status     = $event->parcel_status;
            }

            $returedQuantity            = $parcel->old_quantity - $parcel->quantity; // need for hero commission calculate
            $parcel->quantity           = $parcel->old_quantity;
            $parcel->old_quantity       = null;
            $parcel->partial_delivered  = null;
            $parcel->delivery_date      = null;
            $parcel->save();

            $transaction                        = ParcelTransaction::where('parcel_id', $parcel->id)->first();
            $transaction->current_payable       = ($transaction->current_payable + $transaction->old_cash_collection) - $transaction->cash_collection;
            $transaction->cash_collection       = $transaction->old_cash_collection;
            $transaction->old_cash_collection   = null;
            $transaction->cod_charge            = $transaction->cash_collection > 0 ? ($parcel->merchant->codCharges[$parcel->area] * $transaction->cash_collection) / 100 : 0; // recalculate cod charge
            $transaction->liquid_fragile_charge -= $transaction->liquid_fragile_charge > 0 ? ($parcel->merchant->liquidFragileRate *  $transaction->return_charges) / 100 : 0; // deduct liquid_fragile_charge for return charge if any
            $transaction->return_charges        = 0; // after calculate liquid_fragile_charge back to 0
            $transaction->total_charge          = $transaction->charge + $transaction->cod_charge + $transaction->liquid_fragile_charge +  $transaction->vas_charge; // total charge before apply vat
            $transaction->vat_amount            = ($transaction->total_charge * $parcel->vat) / 100; // reset vat amount
            $transaction->total_charge          = $transaction->total_charge + $transaction->vat_amount; // total charge with vat
            $transaction->current_payable       = $transaction->cash_collection - $transaction->total_charge;
            $transaction->save();

            $heroCommission                 = DeliveryHeroCommission::where('parcel_id', $parcel->id)->where('delivery_hero_id', $event->delivery_man_id)->where('payment_status', PaymentStatus::UNPAID)->first();
            if ($heroCommission) {
                $heroCommission->amount     = $heroCommission->amount - $this->chargeRepo->getHeroCharge($parcel->charge_id, $returedQuantity);
                $heroCommission->status     = Status::INACTIVE;
                $heroCommission->save();
            }

            // delete event
            ParcelEvent::where('parcel_id', $parcel->id)->where('parcel_status', ParcelStatus::PARTIAL_DELIVERED)->latest()->delete();

            DB::commit();
            return $this->responseWithSuccess(___('parcel.partial_delivered_cancel'), []);
        } catch (\Throwable $th) {
            DB::rollBack();
            return $this->responseWithError(___('alert.something_went_wrong'), []);
        }
    }

    public function pickupManAssignedCancel($id)
    {
        try {
            $parcel = $this->model::find($id);
            if ($parcel->status == ParcelStatus::PICKUP_ASSIGN) {
                ParcelEvent::where(['parcel_id' => $id, 'parcel_status' => $parcel->status])->delete();
            }
            $parcel->status   = ParcelStatus::PENDING;
            $parcel->save();
            return $this->responseWithSuccess(___('parcel.pickup_man_assigned'), []);
        } catch (\Throwable $th) {
            return $this->responseWithError(___('alert.something_went_wrong'), []);
        }
    }

    public function PickupReScheduleCancel($id)
    {
        try {
            $parcel = $this->model::find($id);
            if ($parcel->status == ParcelStatus::PICKUP_RE_SCHEDULE) {
                ParcelEvent::where(['parcel_id' => $id, 'parcel_status' => $parcel->status])->delete();
            }
            $parcel->status       = ParcelStatus::PICKUP_ASSIGN;
            $parcel->save();
            return $this->responseWithSuccess(___('parcel.pickup_reschedule_canceled'), []);
        } catch (\Throwable $th) {
            return $this->responseWithError(___('alert.something_went_wrong'), []);
        }
    }

    public function receivedByPickupManCancel($id)
    {
        try {
            $parcel = $this->model::find($id);
            if ($parcel->status == ParcelStatus::RECEIVED_BY_PICKUP_MAN) {
                $event = ParcelEvent::where(['parcel_id' => $id, 'parcel_status' => $parcel->status])->first();
                ParcelEvent::destroy($event->id);
            }
            $parcel->status    = ParcelStatus::PICKUP_ASSIGN;
            $parcel->save();
            return $this->responseWithSuccess(___('parcel.received_by_pickup_cancel_success'), []);
        } catch (\Throwable $th) {
            return $this->responseWithError(___('alert.something_went_wrong'), []);
        }
    }

    public function deliverymanAssignCancel($id)
    {
        try {
            $parcel = $this->model::find($id);
            if ($parcel->status == ParcelStatus::DELIVERY_MAN_ASSIGN) {
                ParcelEvent::where(['parcel_id' => $id, 'parcel_status' => $parcel->status])->delete();
                $receivedByhub        = ParcelEvent::where(['parcel_id' => $id, 'parcel_status' => ParcelStatus::RECEIVED_BY_HUB])->delete();
                if ($receivedByhub) {
                    $parcel->status   = ParcelStatus::RECEIVED_BY_HUB;
                } else {
                    $parcel->status   = ParcelStatus::RECEIVED_WAREHOUSE;
                }
            }
            $parcel->save();
            return $this->responseWithSuccess(___('parcel.deliveryman_assign_cancel'), []);
        } catch (\Throwable $th) {
            return $this->responseWithError(___('alert.something_went_wrong'), []);
        }
    }

    public function deliveryReScheduleCancel($id)
    {
        try {

            $parcel = $this->model::find($id);
            if ($parcel->status == ParcelStatus::DELIVERY_RE_SCHEDULE) {
                ParcelEvent::where(['parcel_id' => $id, 'parcel_status' => $parcel->status])->delete();
            }
            $parcel->status   = ParcelStatus::RECEIVED_WAREHOUSE;
            $parcel->save();
            return $this->responseWithSuccess(___('parcel.delivery_re_schedule_cancel'), []);
        } catch (\Throwable $th) {
            return $this->responseWithError(___('alert.something_went_wrong'), []);
        }
    }


    public function transferToHubCancel($id)
    {
        try {

            $parcel = $this->model::find($id);
            if ($parcel->status == ParcelStatus::TRANSFER_TO_HUB) {
                $transferToHub = ParcelEvent::where(['parcel_id' => $id, 'parcel_status' => $parcel->status])->delete();
            }
            $parcel->transfer_hub_id     = null;
            $parcel->status              = ParcelStatus::RECEIVED_WAREHOUSE;
            $parcel->save();

            return $this->responseWithSuccess(___('parcel.transfer_to_hub_canceled'), []);
        } catch (\Throwable $th) {
            return $this->responseWithError(___('alert.something_went_wrong'), []);
        }
    }

    public function receivedByHubCancel($id)
    {
        try {
            DB::beginTransaction();

            $parcel = $this->model::find($id);
            if ($parcel->status == ParcelStatus::RECEIVED_BY_HUB) {
                $transferEvent = ParcelEvent::where(['parcel_id' => $id, 'parcel_status' => ParcelStatus::TRANSFER_TO_HUB])->latest()->first();
                $lastEvent     = ParcelEvent::where(['parcel_id' => $id, 'parcel_status' => $parcel->status])->latest()->first();

                $parcel->hub_id             = $transferEvent->hub_id;
                $parcel->transfer_hub_id    = $lastEvent->hub_id;

                $lastEvent->delete();
            }

            $parcel->status  = ParcelStatus::TRANSFER_TO_HUB;
            $parcel->save();

            DB::commit();
            return $this->responseWithSuccess(___('parcel.received_by_hub_cancel'), []);
        } catch (\Throwable $th) {
            DB::rollBack();
            return $this->responseWithError(___('alert.something_went_wrong'), []);
        }
    }

    public function searchParcel($request)
    {
        $query = Parcel::query();
        $query->with('parcelTransaction', 'merchant', 'hub', 'productCategory', 'serviceType',);

        if ($request->tracking_id) {
            $query->where('tracking_id', $request->tracking_id);
        }

        if ($request->merchant_id) {
            $query->where('merchant_id', $request->merchant_id);
        }

        if ($request->hub_id) {
            $query->where('hub_id', $request->hub_id);
        }

        if ($request->transfer_hub_id) {
            $query->where('transfer_hub_id', $request->transfer_hub_id);
        }

        if ($request->skip_hub_id) {
            $query->whereNot('hub_id', $request->skip_hub_id);
        }

        if ($request->status) {
            is_array($request->status) ? $query->whereIn('status', $request->status) : $query->where('status', $request->status);
        }

        $parcel =  $query->first();

        return $parcel;
    }


    public function parcelReceivedByMultipleHub($request)
    {
        try {
            DB::beginTransaction();
            foreach ($request->parcel_ids as $parcel_id) {
                $parcel                 = $this->model::find($parcel_id);
                $parcel->hub_id         = $parcel->transfer_hub_id;
                $parcel->status         = ParcelStatus::RECEIVED_BY_HUB;
                $parcel->save();

                $event                  = new ParcelEvent();
                $event->parcel_id       = $parcel->id;
                $event->parcel_status   = ParcelStatus::RECEIVED_BY_HUB;
                $event->note            = $request->note;
                $event->created_by      = Auth::user()->id;
                $event->save();
            }
            DB::commit();
            return $this->responseWithSuccess(___('parcel.received_by_multiple_hub'), []);
        } catch (\Throwable $th) {
            DB::rollBack();
            return $this->responseWithError(___('alert.something_went_wrong'), []);
        }
    }


    public function bulkPickupManAssign($request)
    {
        try {
            DB::beginTransaction();

            foreach ($request->parcel_id as  $id) {

                $parcel                 = $this->model::find($id);
                $parcel->status         = ParcelStatus::PICKUP_ASSIGN;
                $parcel->save();

                $event                  = new ParcelEvent();
                $event->parcel_id       = $parcel->id;
                $event->pickup_man_id   = $request->delivery_man_id;
                $event->note            = $request->note;
                $event->parcel_status   = ParcelStatus::PICKUP_ASSIGN;
                $event->created_by      = Auth::user()->id;
                $event->save();

                $data = [
                    'message'   => 'Assign Pickup',
                    'parcel_id' => $parcel->id,
                    // 'url'       => route('parcel.details', $parcel->id),
                ];

                $event->pickupman->user->notify(new StoreNotification($data));


                if (@$request->send_sms_pickuman == 'on') {
                    if (session()->has('locale') && session()->get('locale') == 'bn') :
                        $msg = 'প্রিয় ' . $event->pickupman->user->name . ', ' . dateFormat($parcel->pickup_date) . ' তারিখের মধ্যে ' . 'পার্সেল পিকআপ করুন । পার্সেল আইডি ' . $parcel->tracking_id . ' । পার্সেল পাঠিয়েছে (' . $parcel->merchant->business_name . ',' . $parcel->merchant->user->mobile . ',' . $parcel->merchant->address . ') - ' . settings('name');
                    else :
                        $msg = 'Dear ' . $event->pickupman->user->name . ', Please pickup parcel with ID ' . $parcel->tracking_id . ' parcel from (' . $parcel->merchant->business_name . ',' . $parcel->merchant->user->mobile . ',' . $parcel->merchant->address . ') within ' . dateFormat($parcel->pickup_date) . ' -' . settings('name');
                    endif;
                    $response =  app(SmsService::class)->sendSms($event->pickupman->user->mobile, $msg);
                }

                try {
                    $msgNotification = 'Dear ' . $event->pickupman->user->name . ', Please pickup parcel with ID ' . $parcel->tracking_id . ' parcel from (' . $parcel->merchant->business_name . ',' . $parcel->merchant->user->mobile . ',' . $parcel->merchant->address . ') within ' . dateFormat($parcel->pickup_date) . ' -' . settings('name');
                    app(PushNotificationService::class)->sendStatusPushNotification($parcel, $event->pickupman->user->email, $msgNotification, 'deliveryMan');
                } catch (\Exception $exception) {
                }

                if (@$request->send_sms_merchant  == 'on') {
                    if (session()->has('locale') && session()->get('locale') == 'bn') :
                        $msg = 'সম্মানিত ' . $parcel->merchant->business_name . ',  আপনার পার্সেল আইডি -' . $parcel->tracking_id . ' । ' . settings('name') . ' থেকে পিকআপ ম্যান নিয়োগ করা হয়েছে । প্রয়োজনে  পিকআপ ম্যান এর সাথে যোগাযোগ করুন । নিয়োগ দিয়েছেন ' . $event->pickupman->user->name . ', ' . $event->pickupman->user->mobile . ' । ট্র্যাক করুন: ' . url('/') . ' -' . settings('name');
                    else :
                        $msg = 'Dear ' . $parcel->merchant->business_name . ', your  parcel with ID ' . $parcel->tracking_id . ' Pickup man assign from ' . settings('name') . '. Assign by' . $event->pickupman->user->name . ', ' . $event->pickupman->user->mobile . ' Track here: ' . url('/') . ' -' . settings('name');
                    endif;
                    $response =  app(SmsService::class)->sendSms($parcel->merchant->user->mobile, $msg);
                }
            }
            DB::commit();
            return $this->responseWithSuccess(___('parcel.pickup_man_assigned'), []);
        } catch (\Throwable $th) {
            DB::rollBack();
            return $this->responseWithError(___('alert.something_went_wrong'), []);
        }
    }

    public function AssignReturnToMerchantBulk($request)
    {
        try {

            DB::beginTransaction();

            foreach ($request->parcel_ids as $id) {

                $parcel                = $this->model::find($id);
                $parcel->delivery_date = $request->date;
                $parcel->status        = ParcelStatus::RETURN_ASSIGN_TO_MERCHANT;
                $parcel->save();

                $event                  = new ParcelEvent();
                $event->parcel_id       = $parcel->id;
                $event->delivery_man_id = $request->delivery_man_id;
                $event->note            = $request->note;
                $event->parcel_status   = ParcelStatus::RETURN_ASSIGN_TO_MERCHANT;
                $event->created_by      = Auth::user()->id;
                $event->save();

                if (@$request->send_sms == 'on') {
                    if (session()->has('locale') && session()->get('locale') == 'bn') :
                        $msg = 'সম্মানিত ' . $parcel->merchant->business_name . ', পার্সেল আইডি - ' . $parcel->tracking_id . ',  আপনার পার্সেলটি (' . $event->deliveryMan->user->name . ', ' . $event->deliveryMan->user->mobile . ') দ্বারা আপনার কাছে পূনরায় পাঠানো হয়েছে ' . ',' . 'পরিদর্শন করুন:' . url('/') . '  -' . settings('name');
                    else :
                        $msg = 'Dear ' . $parcel->merchant->business_name . ', parcel with ID ' . $parcel->tracking_id . ' is return to you by ' . $event->deliveryMan->user->name . ', ' . $event->deliveryMan->user->mobile . '. visit:' . url('/') . '  -' . settings('name');
                    endif;
                    $response =  app(SmsService::class)->sendSms($parcel->merchant->user->mobile, $msg);
                }
            }

            DB::commit();
            return $this->responseWithSuccess(___('parcel.return_assign_to_merchant_success'), []);
        } catch (\Throwable $th) {
            DB::rollBack();
            return $this->responseWithError(___('alert.something_went_wrong'), []);
        }
    }

    public function bulkParcels($ids)
    {
        return $this->model::whereIn('id', $ids)->get();
    }

    //app dashboard
    public function deliverymanStatusParcel($status)
    {

        if ($status == ParcelStatus::DELIVERED) :
            return $this->model::orderByDesc('id')->with(['merchant'])->whereIn('status', [ParcelStatus::DELIVERED, ParcelStatus::PARTIAL_DELIVERED])->where(function ($query) {
                $query->wherehas('parcelEvent', function ($eventquery) {
                    $eventquery->where('delivery_man_id', Auth::user()->deliveryman->id);
                });
            })->get();
        else :
            return $this->model::orderByDesc('id')->with(['merchant'])->where('status', $status)->where(function ($query) {
                $query->wherehas('parcelEvent', function ($eventquery) {
                    $eventquery->where('delivery_man_id', Auth::user()->deliveryman->id);
                });
            })->get();
        endif;
    }
    //end app dashboard

    public function parcelSearch($request)
    {
        return  $this->model::where('customer_name', 'Like', '%' . $request->search . '%')
            ->orWhere('customer_phone', 'Like', '%' . $request->search . '%')
            ->orWhere('customer_address', 'Like', '%' . $request->search . '%')
            ->orWhere('invoice_no', 'Like', '%' . $request->search . '%')
            ->orWhere('tracking_id', 'Like', '%' . $request->search . '%')
            ->orWhereHas('merchant', function ($query) use ($request) {
                $query->where('business_name', 'Like', '%' . $request->search . '%');
            })
            ->paginate(settings('paginate_value'));
    }

    public function deliverymanParcels($request)
    {
        $hero_id = Auth::user()->deliveryman->id;
        $parcels = $this->model::whereHas('parcelEvent', fn($event) => $event->where(['delivery_man_id' => $hero_id])->orWhere(['pickup_man_id' => $hero_id]))->orderByDesc('id');
        return $parcels;
    }


    private function couponDiscount($coupon_code, $merchant_id, $charge)
    {
        $coupon = Coupon::where('coupon', $coupon_code)->where('status', Status::ACTIVE)->where('end_date', '>=', now())->first();

        if ($coupon == null || ($coupon->type == CouponType::MERCHANT_WISE->value && !in_array($merchant_id, $coupon->mid))) {
            return 0;
        }

        if ($coupon->discount_type == DiscountType::PERCENT->value) {
            return ($charge * $coupon->discount) / 100;
        }

        return $coupon->discount;
    }

    // This function generates a unique tracking ID with a prefix
    private function generateUniqueTrackingId($mid = null)
    {
        $prefix = settings('par_track_prefix');
        $mid    = $mid ? base_convert($mid, 10, 36) : null;

        $microtime  = microtime(true);
        $id         = base_convert($microtime, 10, 36) . $mid;
        $id         = substr($id, 0, 19); // Truncate the ID to 19 characters

        while (Parcel::where('tracking_id', $prefix . $id)->exists()) {
            $random = uniqid();
            $id     = base_convert($random, 16, 36) . $mid;
            $id     = substr($id, 0, 19); // Truncate the ID to 19 characters
        }

        return Str::upper($prefix . $id);
    }

    public function requestParcelDelivery($request)
    {

        try {
            $hero_id = auth()->user()->deliveryman->id;

            $event = ParcelEvent::where('parcel_id', $request->parcel_id)->where('delivery_man_id', $hero_id)->first();

            if (!$event) {
                return $this->responseWithError(___('alert.unauthorized'));
            }

            $otp        = random_int(100000, 999999);

            // if (config('app.app_demo')) {
            //     $otp        = 123456;
            // }

            $parcelStatusUpdate                 =   ParcelStatusUpdate::where('parcel_id', $request->parcel_id)->where('parcel_status', $request->status)->first();

            if (!$parcelStatusUpdate) {
                $parcelStatusUpdate             = new ParcelStatusUpdate();
            }

            $parcelStatusUpdate->parcel_id      = $request->parcel_id;
            $parcelStatusUpdate->parcel_status  = $request->status;
            $parcelStatusUpdate->otp            = $otp;
            $parcelStatusUpdate->save();

            app(SmsService::class)->sendOtp($event->parcel->customer_phone, $otp);

            return $this->responseWithSuccess(___('alert.otp_send_to_customer'));
        } catch (\Exception $e) {
            return $this->responseWithError(___('alert.something_went_wrong'));
        }
    }

    public function parcelBankToggle($id)
    {
        try {
            $parcel                 = $this->model::find($id);
            $parcel->is_parcel_bank = $parcel->is_parcel_bank == true ? false : true;
            $parcel->save();

            return $this->responseWithSuccess(___('alert.request_successfully_executed'));
        } catch (\Throwable $th) {
            return $this->responseWithError(___('alert.something_went_wrong'));
        }
    }


    public function codCollections(int $paginate = null, bool $paidByHero = null)
    {

        $hero_id = auth()->user()->user_type == UserType::DELIVERYMAN ? auth()->user()->deliveryman->id : request('hero_id');

        $query = $this->model::query();

        $query->with('parcelTransaction:parcel_id,cash_collection');

        $query->whereIn('status', [ParcelStatus::DELIVERED, ParcelStatus::PARTIAL_DELIVERED]);

        if ($paidByHero != null) {
            $paidByHero ? $query->whereNot('cash_collection_status', CashCollectionStatus::PENDING) :  $query->where('cash_collection_status', CashCollectionStatus::PENDING);
        }

        if (!$hero_id) {
            $query->whereHas('parcelEvent', fn($query) => $query->where('delivery_man_id', $hero_id));
        }

        $query->whereHas('parcelTransaction', fn($query) => $query->where('cash_collection', '>', 0));

        $query->latest('delivery_date');

        return $paginate != null ? $query->paginate($paginate) : $query->get();
    }
}
