<?php

namespace App\Imports;

use App\Enums\Area;
use App\Enums\CashCollectionStatus;
use App\Enums\CouponType;
use App\Enums\DiscountType;
use App\Enums\ParcelStatus;
use App\Enums\Status;
use App\Enums\UserType;
use App\Models\Backend\Charges\Charge;
use App\Models\Backend\Charges\ProductCategory;
use App\Models\Backend\Charges\ServiceType;
use App\Models\Backend\Charges\ValueAddedService;
use App\Models\Backend\Coupon;
use App\Models\Backend\Coverage;
use App\Models\Backend\MerchantCharge;
use App\Models\Backend\Parcel;
use App\Models\Backend\ParcelEvent;
use App\Models\Backend\ParcelTransaction;
use App\Models\MerchantShops;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Illuminate\Support\Str;

class ParcelImport implements ToModel, WithHeadingRow, WithValidation, SkipsEmptyRows
{

    use Importable;

    private $merchant;
    public array $insertedRows = [];
    public array $skippedRows = [];

    public function __construct($merchant)
    {
        $this->merchant = $merchant;
    }


    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        $row = $this->validateRow($row);
        if ($row == null) {
            return null;
        }

        DB::beginTransaction();

        $parcel                         = new Parcel();
        $transaction                    = new ParcelTransaction();

        $parcel->merchant_id            = $this->merchant->id;
        $parcel->vat                    = $this->merchant->vat;
        $parcel->merchant_shop_id       = $row['shop_id'];
        $parcel->first_hub_id           = $row['shop_hub_id'];
        $parcel->hub_id                 = $parcel->first_hub_id;
        $parcel->pickup_phone           = $row['pickup_phone'];
        $parcel->pickup_address         = $row['pickup_address'];
        $parcel->pickup                 = $row['pickup_id'];
        $parcel->destination            = $row['destination_id'];
        $parcel->customer_name          = $row['customer_name'];
        $parcel->customer_phone         = $row['customer_phone'];
        $parcel->customer_address       = $row['customer_address'];
        $parcel->note                   = $row['note'];
        $parcel->invoice_no             = $row['invoice_no'];
        $parcel->vas                    = $row['vas'];
        $parcel->quantity               = $row['quantity'];
        $parcel->charge_id              = $row['charge_id'];
        $parcel->product_category_id    = $row['product_category_id'];
        $parcel->service_type_id        = $row['service_type_id'];
        $parcel->area                   = $row['area'];
        $parcel->tracking_id            = $this->generateUniqueTrackingId($parcel->merchant_id) . 'I';


        //  parcel transaction amounts 
        $transaction->cash_collection       = $row['cash_collection'] ?? 0;
        $transaction->selling_price         = $row['selling_price'] ?? 0;
        $transaction->charge                = $row['charge'];
        $transaction->cod_charge            = $transaction->cash_collection > 0 ? ($this->merchant->codCharges[$parcel->area] * $transaction->cash_collection) / 100 : 0;
        $transaction->liquid_fragile_charge = $row['fragile_liquid'] ? ($this->merchant->liquidFragileRate *  $transaction->charge) / 100 : 0;
        $transaction->vas_charge            = $row['vas_charge'];
        $transaction->total_charge          = $transaction->charge + $transaction->cod_charge + $transaction->liquid_fragile_charge +  $transaction->vas_charge;

        if ($row['coupon'] != null) {
            $transaction->discount          = $this->couponDiscount($row['coupon'], $parcel->merchant_id, $transaction->total_charge);
            $transaction->total_charge      = $transaction->total_charge - $transaction->discount;
            $parcel->coupon                 = $transaction->discount > 0 ? $row['coupon']  :  null;
        }

        $transaction->vat_amount            = ($transaction->total_charge * $parcel->vat) / 100;
        $transaction->total_charge          = $transaction->total_charge + $transaction->vat_amount; // total charge with vat
        $transaction->current_payable       =  $transaction->cash_collection - $transaction->total_charge;

        if ($transaction->cash_collection > 0) {
            $parcel->cash_collection_status = CashCollectionStatus::PENDING;
        }

        $parcel->save(); // save parcel 

        $transaction->parcel_id             = $parcel->id; // add parcel id 

        $transaction->save(); // save parcel transaction

        // Parcel event
        $event                              = new ParcelEvent();
        $event->parcel_id                   = $parcel->id;
        $event->note                        = 'Parcel Created';
        $event->parcel_status               = ParcelStatus::PENDING;
        $event->created_by                  = auth()->user()->id;
        $event->save();

        DB::commit();

        $this->insertedRows[]    = $row;

        return $parcel;
    }

    public function prepareForValidation($row)
    {
        $row = array_map('trim', $row);

        if (in_array($row['fragile_liquid'], ['on', 'yes', 1, true])) {
            $row['fragile_liquid'] = true;
        } else {
            $row['fragile_liquid'] = null;
        }

        return $row;
    }

    public function rules(): array
    {
        $rules = [
            'pickup_phone'      => ['nullable', 'regex:/^\+?[0-9]{1,4}-?[0-9]{7,14}$/'],
            'pickup_address'    => ['nullable', 'string', 'max:191'],
            'cash_collection'   => ['nullable', 'numeric', 'min:0'],
            'selling_price'     => ['nullable', 'numeric', 'min:0'],
            'invoice_no'        => ['nullable', 'max:50'],
            'customer_name'     => ['required', 'string', 'max:50'],
            'customer_phone'    => ['required', 'regex:/^\+?[0-9]{1,4}-?[0-9]{7,14}$/'],
            'customer_address'  => ['required', 'string', 'max:191'],
            'note'              => ['nullable', 'string', 'max:255'],
            // 'fragileLiquid'     => ['nullable', 'boolean'],
            'quantity'          => ['required', 'numeric', 'min:0'],
            'charge'            => ['nullable', 'numeric', 'min:0'],
            'coupon'            => ['nullable', 'string', 'max:50'],
        ];

        return $rules;
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

    private function  validateRow($row)
    {
        $invalidRow = $row;

        $shop           = MerchantShops::where('status', Status::ACTIVE)->where('merchant_id', $this->merchant->id)->where('name', $row['shop_name'])->first();

        if (!$shop) {
            $invalidRow['error']  =  'Check Shop name and make sure its active';
            $this->skippedRows[]    = $invalidRow;
            return null;
        }

        $destination    = Coverage::where('status', Status::ACTIVE)->where('name', $row['destination_area'])->first();

        if (!$destination) {
            $invalidRow['error']  =  'Check Destination area and make sure its active';
            $this->skippedRows[]    = $invalidRow;
            return null;
        }

        $productCategory = ProductCategory::where('status', Status::ACTIVE)->where('name', $row['product_category'])->first();

        if (!$productCategory) {
            $invalidRow['error']  =  'Check Product category and make sure its active';
            $this->skippedRows[]    = $invalidRow;
            return null;
        }

        $serviceType     = ServiceType::where('status', Status::ACTIVE)->where('name', $row['service_type'])->first();

        if (!$serviceType) {
            $invalidRow['error']  =  'Check Service Type and make sure its active';
            $this->skippedRows[]    = $invalidRow;
            return null;
        }

        // manage vas 
        if (!empty($row['value_added_services'])) {

            $vasNames                   = array_map('trim', explode(",", $row['value_added_services']));
            $vas                        = ValueAddedService::whereIn('name', $vasNames)->where('status', Status::ACTIVE)->get(['id', 'price']);

            if (count($vas->toArray()) != count($vasNames)) {
                $invalidRow['error']    = 'Value Added Services not found.';
                $this->skippedRows[]    = $invalidRow;
                return null;
            }

            $row['vas']                 = $vas->toArray();
            $row['vas_charge']          = $vas->sum('price');
        } else {
            $row['vas']                 = [];
            $row['vas_charge']          = 0;
        }

        $row['shop_id']                 = $shop->id;
        $row['shop_hub_id']             = $shop->hub_id;
        $row['pickup_phone']            = $row['pickup_phone'] ? $row['pickup_phone'] : $shop->contact_no;
        $row['pickup_address']          = $row['pickup_address'] ? $row['pickup_address'] : $shop->address;
        $row['pickup_id']               = $shop->coverage_id;
        $row['destination_id']          = $destination->id;
        $row['destination_parent_id']   = $destination->parent_id;
        $row['product_category_id']     = $productCategory->id;
        $row['service_type_id']         = $serviceType->id;
        $row['area']                    = Area::OUTSIDE_CITY->value;

        if ($row['pickup_id'] ==  $row['destination_id']) {
            $row['area']    = Area::INSIDE_CITY->value;
        } else {
            $pickup         = Coverage::find($row['pickup_id']);
            if ($pickup && ($pickup->parent_id == $destination->parent_id || $pickup->id == $destination->parent_id || $pickup->parent_id == $destination->id)) {
                $row['area'] = Area::SUB_CITY->value;
            }
        }

        $where  = ['product_category_id' =>  $row['product_category_id'], 'service_type_id' =>  $row['service_type_id'], 'area' => $row['area'], 'status' => Status::ACTIVE];
        $charge = MerchantCharge::where($where)->first('id');

        if (!$charge) {
            $charge = Charge::where($where)->first();
        }

        if (!$charge) {
            $invalidRow['error']    = 'No charge found.';
            $this->skippedRows[]    = $invalidRow;
            DB::rollBack();
            return null;
        }

        $row['charge_id']  =  $charge->id;

        if (auth()->user()->user_type == UserType::MERCHANT || $row['charge'] == null) {
            $additional = ($row['quantity'] - 1) * $charge->additional_charge;
            $row['charge']     = $charge->charge + $additional;
        }

        return $row;
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
}
