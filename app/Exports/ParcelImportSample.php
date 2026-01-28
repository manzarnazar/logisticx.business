<?php

namespace App\Exports;

use App\Enums\Status;
use App\Enums\UserType;
use App\Models\Backend\Charges\Charge;
use App\Models\Backend\Charges\ProductCategory;
use App\Models\Backend\Charges\ServiceType;
use App\Models\Backend\Charges\ValueAddedService;
use App\Models\Backend\Coverage;
use App\Models\Backend\Merchant;
use App\Models\MerchantShops;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ParcelImportSample implements FromArray, WithHeadings, WithStyles
{
    use Exportable;

    private $shop;
    private $vas;
    private $coverage;
    private $charge;


    public function __construct()
    {
        if (auth()->user()->user_type == UserType::MERCHANT) {
            $merchant = Merchant::where('user_id', auth()->user()->id)->first();
            $this->shop         = MerchantShops::where('merchant_id', $merchant->id)->where('status', Status::ACTIVE)->get(['name', 'contact_no', 'address']);
        } else {
            $this->shop         = MerchantShops::where('status', Status::ACTIVE)->get(['name', 'contact_no', 'address']);
        }

        $this->charge          = Charge::where('status', Status::ACTIVE)->get();
        $this->vas             = ValueAddedService::where('status', Status::ACTIVE)->pluck('name');
        $this->coverage        = Coverage::where('status', Status::ACTIVE)->pluck('name');
    }

    public function array(): array
    {
        return $this->rows();
    }

    public function headings(): array
    {
        $headings =  [
            'shop_name',
            'pickup_phone',
            'pickup_address',
            'cash_collection',
            'selling_price',
            'invoice_no',
            'customer_name',
            'customer_phone',
            'customer_address',
            'destination_area',
            'note',
            'product_category',
            'service_type',
            'value_added_services',
            'quantity',
            'coupon',
            'fragile_liquid',
        ];

        if (auth()->user()->user_type != UserType::MERCHANT) {
            $headings[] = 'charge';
        }

        return $headings;
    }


    private function rows(): array
    {
        $rows = [];
        for ($i = 0; $i < 2; $i++) {
            $rows[] = $this->getRow();
        }
        return $rows;
    }

    private function getRow()
    {
        $vas = $this->vas->random();
        for ($i = 1; $i < rand(2, 3); $i++) {
            $vas .= ',' . $this->vas->random();
        }
        $quantity = rand(1, 3);

        $charge = $this->charge->random();

        $row =  [
            "shop_name"             => $this->shop->random()->name,
            "pickup_phone"          => $this->shop->random()->contact_no,
            "pickup_address"        => $this->shop->random()->address,
            "cash_collection"       => rand(1000, 5000),
            "selling_price"         => rand(1000, 5000),
            "invoice_no"            => "INV12345",
            "customer_name"         => fake()->name,
            "customer_phone"        => "01" . "800000000",
            "customer_address"      => fake()->address,
            "destination_area"      => $this->coverage->random(),
            "note"                  => fake()->text,
            "product_category"      => $charge->productCategory->name,
            "service_type"          => $charge->serviceType->name,
            "value_added_services"  => $vas,
            "quantity"              => $quantity,
            "coupon"                => "COUPON",
            "fragile_liquid"        => "yes",
        ];

        if (auth()->user()->user_type != UserType::MERCHANT) {
            $row['charge'] = rand(20, 30) * $quantity;
        }

        return $row;
    }

    public function styles(Worksheet $sheet)
    {
        return [
            // Style the first row as bold text.
            1    => ['font' => ['bold' => true]],
        ];
    }
}
