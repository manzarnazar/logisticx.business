<?php

namespace App\Http\Controllers\Backend\MerchantPanel;

use Carbon\Carbon;
use App\Enums\Status;
use Illuminate\Http\Request;
use App\Models\MerchantShops;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\MerchantParcelExport;
use App\Repositories\Charge\ChargeInterface;
use App\Repositories\Parcel\ParcelInterface;
use App\Repositories\Coverage\CoverageInterface;
use App\Repositories\ValueAddedService\VASInterface;
use App\Repositories\MerchantPanel\Shops\ShopsInterface;
use App\Repositories\Merchant\DeliveryCharge\MerchantChargeInterface;
use App\Repositories\MerchantPanel\MerchantParcel\MerchantParcelInterface;

class MerchantParcelController extends Controller
{

    protected $repo;
    protected $shop;
    protected $vasRepo;
    protected $chargeRepo;
    protected $merchantCharge;
    protected $coverageRepo;
    protected $parcelRepo;
    protected $deliveryman;

    public function __construct(ParcelInterface $parcelRepo, MerchantParcelInterface $repo, ShopsInterface $shop, VASInterface $vasRepo, ChargeInterface $chargeRepo, MerchantChargeInterface $merchantCharge, CoverageInterface $coverageRepo)
    {
        $this->repo             = $repo;
        $this->shop             = $shop;
        $this->vasRepo          = $vasRepo;
        $this->chargeRepo       = $chargeRepo;
        $this->merchantCharge   = $merchantCharge;
        $this->coverageRepo     = $coverageRepo;
        $this->parcelRepo       = $parcelRepo;
    }

    private function mid()  // mid = Merhchant User-Id 
    {
        return Auth::user()->merchant->id;
    }

    public function parcelBank(Request $request)
    {
        $parcels = $this->repo->parcelBank($this->mid());

        return view('backend.merchant_panel.parcel.parcel_bank', compact('parcels', 'request'));
    }

    public function filter(Request $request)
    {
        $parcels = $this->repo->filter($this->mid(), $request);

        if ($parcels) {
            return view('backend.merchant_panel.parcel.index', compact('parcels', 'request'));
        }

        return redirect()->back();
    }

    // Parcel details
    public function details($id)
    {
        dd('here');
        $parcel       = $this->repo->details($id);
        $parcelevents = $this->repo->parcelEvents($id);
        return view('backend.merchant_panel.parcel.details', compact('parcel', 'parcelevents'));
    }


    public function merchantShops(Request $request)
    {
        dd('here');
        if (request()->ajax()) {
            if ($request->id && $request->shop == 'true') {
                $merchantShops = [];
                $merchantShop = MerchantShops::where(['merchant_id' => $request->id, 'default_shop' => Status::ACTIVE])->first();
                $merchantShops[] = $merchantShop;
                $merchantShopArray = MerchantShops::where(['merchant_id' => $request->id, 'default_shop' => Status::INACTIVE])->get();
                if (!blank($merchantShopArray)) {
                    foreach ($merchantShopArray as $shop) {
                        $merchantShops[] = $shop;
                    }
                }
                if (!blank($merchantShops)) {
                    return view('backend.parcel.shops', compact('merchantShops'));
                }
                return '';
            } else {
                $merchantShop = MerchantShops::find($request->id);
                if (!blank($merchantShop)) {
                    return $merchantShop;
                }
                return '';
            }
        }
        return '';
    }

    public function parcelExport(Request $request)
    {
        try {
            if ($request->type && $request->type == 'csv') :
                return Excel::download(new MerchantParcelExport($this->repo->parcelExport($request)), 'Parcels Export-csv-file-' . Carbon::now()->format('d-m-Y His') . '.csv', \Maatwebsite\Excel\Excel::CSV, [
                    'Content-Type' => 'text/csv',
                ]);
            else :
                return Excel::download(new MerchantParcelExport($this->repo->parcelExport($request)), 'Parcels Export-excel-file-' . Carbon::now()->format('d-m-Y His') . '.xlsx');
            endif;
        } catch (\Throwable $th) {
            toast(___('alert.something_went_wrong'), 'error');
            return redirect()->back();
        }
    }


    // ====================================================================================================================
    //                                       Merchant parcel charge Ajax response 
    // ====================================================================================================================



    public function charge(Request $request)
    {
        dd('here');

        if (!request()->ajax()) {
            return response()->json(['error' => ___('alert.invalid_request')], 400);
        }

        $where =  [
            'merchant_id'         => $this->mid(),
            'product_category_id' => $request->input('product_category_id'),
            'service_type_id'     => $request->input('service_type_id'),
            'area'                => $request->input('area'),
            'status'              => Status::ACTIVE
        ];

        $columns = ['charge_id', 'charge', 'additional_charge'];

        $charge = $this->merchantCharge->singleCharge(where: $where, columns: $columns);

        if ($charge) {
            // If a merchant charge exists, return response 
            return response()->json($charge);
        }

        // Remove 'merchant_id' from the $where array
        unset($where['merchant_id']);
        $columns = array_diff($columns, ['charge_id']);
        $columns[] = 'id';

        $charge = $this->chargeRepo->getWithFilter(where: $where, columns: $columns, retrieveFirst: true);

        if ($charge) {
            $charge['charge_id'] = $charge['id'];
            unset($charge['id']);
            return response()->json($charge);
        }

        return response()->json(['message' => 'No matching charge found.'], 404);
    }
}
