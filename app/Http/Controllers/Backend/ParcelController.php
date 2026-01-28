<?php

namespace App\Http\Controllers\Backend;

use App\Models\User;
use App\Enums\Status;
use App\Enums\UserType;
use App\Enums\ParcelStatus;
use App\Exports\RowsExport;
use App\Models\Backend\Hub;
use Illuminate\Support\Str;
use App\Enums\PaymentStatus;
use Illuminate\Http\Request;
use App\Imports\ParcelImport;
use App\Models\MerchantShops;
use App\Notifications\Notify;
use App\Models\Backend\Parcel;
use App\Models\Backend\Merchant;
use App\Enums\CashCollectionStatus;
use App\Exports\ParcelImportSample;
use App\Exports\ParcelSampleExport;
use App\Models\Backend\ParcelEvent;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use App\Repositories\Hub\HubInterface;
use Maatwebsite\Excel\HeadingRowImport;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\Parcel\StoreRequest;
use App\Http\Requests\Parcel\ImportRequest;
use App\Repositories\Charge\ChargeInterface;
use App\Repositories\Parcel\ParcelInterface;
use App\Models\Backend\DeliveryHeroCommission;
use App\Repositories\Coverage\CoverageInterface;
use App\Repositories\Merchant\MerchantInterface;
use App\Http\Requests\Parcel\ParcelDeliveredRequest;
use App\Repositories\ValueAddedService\VASInterface;
use App\Repositories\DeliveryMan\DeliveryManInterface;
use App\Repositories\MerchantPanel\Shops\ShopsInterface;
use App\Repositories\Merchant\DeliveryCharge\MerchantChargeInterface;

class ParcelController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    protected $merchant;
    protected $repo;
    protected $shop;
    protected $deliveryman;
    protected $hub;
    protected $ValueAddedServices;
    protected $charge;
    protected $merchantCharge;
    protected $coverageRepo;

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

    public function __construct(
        ParcelInterface $repo,
        MerchantInterface $merchant,
        ShopsInterface $shop,
        DeliveryManInterface $deliveryman,
        HubInterface $hub,
        VASInterface $ValueAddedServices,
        ChargeInterface $charge,
        MerchantChargeInterface $merchantCharge,
        CoverageInterface $coverageRepo,
    ) {
        $this->merchant             = $merchant;
        $this->repo                 = $repo;
        $this->shop                 = $shop;
        $this->deliveryman          = $deliveryman;
        $this->hub                  = $hub;
        $this->ValueAddedServices   = $ValueAddedServices;
        $this->charge               = $charge;
        $this->merchantCharge       = $merchantCharge;
        $this->coverageRepo         = $coverageRepo;
    }

    public function index(Request $request, $slug =  null)
    {
        $status = $slugText = null;

        $slugContainer = $slug;

        if ($slug) {
            if (!array_key_exists($slug, $this->statusSlug)) {
                abort(404);
            }
            $slugText   = ___('parcel.' . str_replace("-", "_", $slug));
            $status     = $this->statusSlug[$slug];
        }

        $parcels        = $this->repo->all($status, paginate: settings('paginate_value'));

        if (auth()->user()->user_type == UserType::MERCHANT) {
            return view('backend.merchant_panel.parcel.index', compact('parcels', 'slugText'));
        }

        if (auth()->user()->user_type == UserType::DELIVERYMAN) {
            return view('backend.deliveryman_panel.parcel.index', compact('parcels', 'slugText'));
        }

        $hubs           = $this->hub->all();

        return view('backend.parcel.index', compact('parcels', 'slugText', 'hubs'));
    }

    public function filter(Request $request)
    {
        if ($this->repo->filter($request)) {
            $parcels        = $this->repo->filter($request);
            $parcelsPrint   = $this->repo->filterPrint($request);
            $slugText       = null;

            if (auth()->user()->user_type == UserType::MERCHANT) {
                return view('backend.merchant_panel.parcel.index', compact('parcels', 'slugText'));
            }

            if (auth()->user()->user_type == UserType::DELIVERYMAN) {
                return view('backend.deliveryman_panel.parcel.index', compact('parcels', 'slugText'));
            }

            $hubs           = $this->hub->all();

            return view('backend.parcel.index', compact('parcels', 'slugText', 'hubs', 'parcelsPrint',));
        } else {
            return redirect()->back();
        }
    }

    public function create(Request $request)
    {
        $coverages          = $this->coverageRepo->getWithActiveChild($request);
        $ValueAddedServices = $this->ValueAddedServices->all(Status::ACTIVE, ['id', 'name', 'price']);
        $productCategories  = $this->charge->getWithFilter(with: 'productCategory:id,name', columns: ['product_category_id']);

        return view('backend.parcel.create', compact('productCategories', 'ValueAddedServices', 'coverages'));
    }


    public function store(StoreRequest $request)
    {
        $result = $this->repo->store($request);

        if ($request->wantsJson()) {
            return response()->json($result, $result['data']['status_code']);
        }
    }

    public function edit($id)
    {
        $parcel             = $this->repo->get($id);

        if ($parcel->status != ParcelStatus::PENDING) {
            return back()->with('danger', ___('alert.modification_not_allowed'));
        }

        $coverages          = $this->coverageRepo->getWithActiveChild();
        $productCategories  = $this->charge->getWithFilter(with: 'productCategory:id,name')->map(fn($charge) => $charge->productCategory);

        $where              = ['product_category_id' => $parcel->product_category_id, 'area' => $parcel->area];
        $serviceTypes       = $this->charge->getWithFilter(with: 'serviceType:id,name', where: $where)->map(fn($charge) => $charge->serviceType);

        $ValueAddedServices = $this->ValueAddedServices->all(status: Status::ACTIVE, column: ['id', 'name', 'price']); // get all active vas except this parcels vas ids
        $existingVAS        = collect($parcel->vas)->map(fn($item) => (object) $item); // get this parcel's VAS's
        $existingVASIds     = $existingVAS->pluck('id')->toArray(); // get this parcels vas ids

        $ValueAddedServices->transform(function ($vas) use ($existingVAS) {
            $existing = $existingVAS->where('id', $vas->id)->first();
            if ($existing) {
                $vas->price = $existing->price;
            }
            return $vas;
        });

        return view('backend.parcel.edit', compact('parcel', 'coverages', 'ValueAddedServices', 'existingVASIds', 'productCategories', 'serviceTypes'));
    }

    public function update(StoreRequest $request)
    {
        // return $request;
        $result = $this->repo->update($request);

        if ($request->wantsJson()) {
            return response()->json($result, $result['data']['status_code']);
        }

        if ($result['status']) {
            return redirect()->route('parcel.index')->with('success', $result['message']);
        }
        return back()->with('danger', $result['message']);
    }

    public function destroy($id)
    {
        $result = $this->repo->delete($id);
        $data[0] = $result['message'];

        if ($result['status']) :
            $data[1] = 'success';
            $data[2] = "Deleted";
            return response()->json($data);
        else :
            $data[1] = 'error';
            $data[2] = "oops";
            return response()->json($data);
        endif;
    }


    public function parcelBankToggle($id)
    {
        $result = $this->repo->parcelBankToggle($id);
        return response()->json($result);
    }

    // Parcel duplicate
    public function duplicate($id)
    {
        $parcel             = $this->repo->get($id);
        $coverages          = $this->coverageRepo->getWithActiveChild();
        $productCategories  = $this->charge->getWithFilter(with: 'productCategory:id,name')->map(fn($charge) => $charge->productCategory);

        $where              = ['product_category_id' => $parcel->product_category_id, 'area' => $parcel->area];
        $serviceTypes       = $this->charge->getWithFilter(with: 'serviceType:id,name', where: $where)->map(fn($charge) => $charge->serviceType);

        $ValueAddedServices = $this->ValueAddedServices->all(status: Status::ACTIVE, column: ['id', 'name', 'price']);
        $existingVASIds     = collect($parcel->vas)->pluck('id')->toArray(); // get this parcels vas ids

        return view('backend.parcel.duplicate', compact('parcel', 'coverages', 'productCategories', 'serviceTypes', 'ValueAddedServices', 'existingVASIds'));
    }

    // Parcel details
    public function details($id)
    {
        $parcel = $this->repo->details($id);
        return view('backend.parcel.details', compact('parcel'));
    }

    public function parcelImportView()
    {
        $notes = [
            'required'          => 'Row must have following fields: Shop name, Customer name, Customer Phone, Customer address, Destination area,quantity,Product Category, Service Type,   ',
            'amounts'           => 'Amounts must be a number or blank',
            'vas'               => 'Value added services must be as comma separated. like: one,two,three',
            'fragile_liquid'    => 'Fragile/liquid value can be null or yes/1/on',
        ];

        return view('backend.parcel.import', compact('notes'));
    }

    public function parcelImportSample()
    {
        return Excel::download(new ParcelImportSample(), 'Parcel_Import.xlsx');
    }

    public function parcelImport(ImportRequest $request)
    {
        try {

            if (auth()->user()->user_type == UserType::MERCHANT) {
                $merchant  = Merchant::where('user_id', auth()->user()->id)->first();
            } else {
                $merchant = Merchant::findOrFail($request->merchant_id);
            }

            $import = new ParcelImport($merchant);
            $import->import($request->file('file'));

            if (count($import->insertedRows) > 0) {
                $message    = "Import " . count($import->insertedRows) . " Parcel";
                $url        = route('parcel.index');

                if (auth()->user()->user_type == UserType::MERCHANT) {
                    $user = User::where('user_type', UserType::INCHARGE)->where('hub_id',  $merchant->user->hub_id)->first();
                    $user ?  $user->notify(new Notify($message, $url)) : '';
                } else {
                    $merchant->user->notify(new Notify($message, $url));
                }
            }

            if (!empty($import->skippedRows)) {
                $headings   = (new HeadingRowImport())->toArray($request->file)[0][0];
                $headings[] = 'error';
                array_unshift($import->skippedRows, $headings);
                return Excel::download(new RowsExport($import->skippedRows), 'skipped_rows.xlsx');
            }

            $message = count($import->insertedRows) . " " . ___('label.parcel') . " " .  ___('alert.successfully_added');

            return redirect()->route('parcel.index')->with('success',  $message);
        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {

            $importErrors = [];
            foreach ($e->failures() as $key => $failure) {
                $importErrors[$key]['row']      = $failure->row();
                $importErrors[$key]['column']   = $failure->attribute();
                $importErrors[$key]['message']  = $failure->errors()[0];
            }

            return back()->with(['danger' => ___('alert.something_went_wrong'), 'importErrors' =>  $importErrors]);
        }
    }


    // ========================================================== ajax responses ==========================================================

    public function getMerchant(Request $request)
    {

        if (!request()->ajax()) {
            return response()->json(['error' => ___('alert.invalid_request')], 422);
        }

        if ($request->search == null && $request->searchQuery != 'true') {
            return response()->json(['error' => 'search parameter can not be null.'], 422);
        }

        if ($request->searchQuery != 'true') {
            $merchant_id                    = auth()->user()->user_type == UserType::MERCHANT ? auth()->user()->merchant->id :  $request->search;
            $merchant                       = Merchant::with('shops:id,merchant_id,name,contact_no,address,coverage_id')->find($merchant_id);
            $merchant->cod_charges          = $merchant->codCharges; // all are in parentage
            $merchant->vat                  = $merchant->vat; // in parentage
            // $merchant->vat                  = merchantSetting('merchant_vat', $merchant_id); // in parentage
            $merchant->liquid_fragile_rate  = $merchant->LiquidFragileRate; // in parentage
            return response()->json($merchant);
        }

        $merchants = Merchant::where('status', Status::ACTIVE)->where('business_name', 'like', '%' . $request->search . '%')->orderBy('business_name', 'asc')->take(10)->get(['id', 'business_name']);
        if ($merchants->isEmpty()) {
            return response()->json(['error' => 'No Merchant Found'], 422);
        }

        $response = $merchants->map(fn($merchant) =>   ['id' => $merchant->id, 'text' => $merchant->business_name,]);

        return response()->json($response);
    }


    // Hub search
    public function getHub(Request $request)
    {
        if (!request()->ajax()) {
            return response()->json(['error' => ___('alert.invalid_request')], 422);
        }

        if ($request->search == null && $request->searchQuery != 'true') {
            return response()->json(['error' => 'search parameter can not be null.'], 422);
        }

        $hubs = Hub::where('status', Status::ACTIVE)->orderby('name', 'asc')->select('id', 'name')->where('name', 'like', '%' .  $request->search . '%')->limit(10)->get();

        if ($hubs->isEmpty()) {
            return response()->json(['error' => 'No Hub Found'], 422);
        }

        $response = $hubs->map(fn($hub) =>   ['id' => $hub->id, 'text' => $hub->name,]);

        return response()->json($response);
    }


    public function getMerchantCod(Request $request)
    {

        if (request()->ajax()) :
            $merchant = [];

            $merchant = Merchant::find($request->merchant_id);

            $merchant = [
                'inside_city'  => $merchant->cod_charges['inside_city'],
                'sub_city' => $merchant->cod_charges['sub_city'],
                'outside_city' => $merchant->cod_charges['outside_city']
            ];
            return response()->json($merchant);
        endif;
        return '';
    }

    public function merchantShops(Request $request)
    {
        if (!request()->ajax()) {
            return;
        }

        if ($request->shop == 'false') {
            $merchantShop = MerchantShops::findOrFail($request->id);
            return response()->json($merchantShop);
        }

        $merchantShops = MerchantShops::where(['merchant_id' => $request->id, 'status' => Status::ACTIVE])->get();
        return view('backend.parcel.shops', compact('merchantShops'));
    }

    public function serviceType(Request $request)
    {
        if (!request()->ajax()) {
            return response()->json(['error' => ___('alert.invalid_request')], 422);
        }

        $where = ['product_category_id' => $request->input('product_category_id'), 'area' => $request->input('area'),  'status' => Status::ACTIVE];
        $serviceTypes  = $this->charge->getServiceType($where);

        if ($serviceTypes == null) {
            return response()->json(['error' => 'No serviceTypes found'], 404);
        }

        $types = [];
        foreach ($serviceTypes as $serviceType) {
            $types[] = $serviceType->serviceType;
        }

        return response()->json(['service_types' => $types]);
    }

    public function charge(Request $request)
    {
        if (!request()->ajax()) {
            return response()->json(['error' => ___('alert.invalid_request')], 422);
        }

        $where =  [
            'merchant_id'         => $request->input('merchant_id'),
            'product_category_id' => $request->input('product_category_id'),
            'service_type_id'     => $request->input('service_type_id'),
            'area'                => $request->input('area'),
            'status'              => Status::ACTIVE
        ];

        $charge = $this->merchantCharge->singleCharge(where: $where);

        if ($charge != null) {
            // If a merchant charge exists, return response
            return response()->json($charge);
        }

        // Remove 'merchant_id' from the $where array
        unset($where['merchant_id']);

        $charge = $this->charge->singleCharge(where: $where);

        if ($charge == null) {
            return response()->json(['error' => 'No Charge found'], 404);
        }

        return response()->json($charge);
    }


    public function transferHub(Request $request)
    {
        $parcelEvent = ParcelEvent::where(['parcel_id' => $request->parcel_id, 'parcel_status' => ParcelStatus::RECEIVED_WAREHOUSE])->first();
        $hubs        = Hub::orderByDesc('id')->whereNotIn('id', [$parcelEvent->hub_id])->get();
        $response = '';
        foreach ($hubs as $hub) {
            $response .= '<option value="' . $hub->id . '" selected> ' . $hub->name . '</option>';
        }
        return $response;
    }


    public function deliverymanSearch(Request $request)
    {
        $search = $request->search;
        if ($request->single) {
            $deliveryMan  = ParcelEvent::where(['parcel_id' => $request->parcel_id, 'parcel_status' => $request->status])->first();

            if (isset($deliveryMan->deliveryMan) && !blank($deliveryMan->deliveryMan)) {
                $response = '<option value="' . $deliveryMan->delivery_man_id . '" selected> ' . $deliveryMan->deliveryMan->user->name . '</option>';
            } else {
                $response = '<option value="' . $deliveryMan->pickup_man_id . '" selected> ' . $deliveryMan->pickupman->user->name . '</option>';
            }
            return $response;
        }

        $query = User::query();
        $query->with('deliveryman:id,user_id');
        $query->where('status', Status::ACTIVE);
        if ($request->hub_id) {
            $query->where('hub_id', $request->input('hub_id'));
        }
        $query->where('name', 'like', '%' . $search . '%');
        $query->where('user_type', UserType::DELIVERYMAN);
        $query->orderby('name', 'asc');
        $query->limit(10);
        $users = $query->get(['id', 'name']);

        if ($users->isEmpty()) {
            return response()->json(['message' => 'No Delivery Man Found'], 422);
        }

        $response = $users->map(fn($user) =>   ['id' => $user->deliveryman->id, 'text' => $user->name,]);

        return response()->json($response);
    }

    //parcel search in received by hub
    public function parcelReceivedByHubSearch(Request $request)
    {
        if (!request()->ajax()) {
            return response()->json(['error' => ___('alert.invalid_request')], 422);
        }

        if ($request->tracking_id == null) {
            return response()->json(['error' => 'tracking id can not be null.'], 422);
        }

        $request->merge(['status' => ParcelStatus::TRANSFER_TO_HUB]);

        $parcel = $this->repo->searchParcel($request);

        if (!$parcel) {
            return response()->json(['error' => ___('parcel.no_parcel_pound')], 400);
        }

        return response()->json($parcel);
    }

    public function transferToHubSelectedHub(Request $request)
    {
        // $transferToHub   = ParcelEvent::where(['parcel_id'=>$request->parcel_id,'parcel_status'=>ParcelStatus::TRANSFER_TO_HUB])->orderBy('id','desc')->first();
        // $hub             = ParcelEvent::where(['parcel_id'=>$request->parcel_id,'parcel_status'=>ParcelStatus::RECEIVED_WAREHOUSE])->first();

        $parcel          = Parcel::find($request->parcel_id);
        if ($parcel) {
            if ($parcel->hub_id) {
                return '<option selected disabled>' . $parcel->hub->name . '</option>';
            } else {
                return '<option selected disabled>Hub not found</option>';
            }
        } else {
            return '<option selected disabled>Hub not found</option>';
        }
    }

    public function PickupManAssigned(Request $request)
    {
        $request->validate(['delivery_man_id' => 'required|exists:delivery_man,id', 'note' => 'nullable|string|max:1000']);

        $result = $this->repo->pickupManAssign($request);
        if ($result['status']) {
            return redirect()->back()->with('success', $result['message']);
        }
        return redirect()->back()->with('danger', $result['message']);
    }

    public function PickupManAssignedCancel($id)
    {
        $result = $this->repo->pickupManAssignedCancel($id);
        if ($result['status']) {
            return back()->with('success', $result['message']);
        }
        return back()->with('danger', $result['message']);
    }

    public function PickupReSchedule(Request $request)
    {
        $request->validate(['delivery_man_id' => 'required|exists:delivery_man,id', 'date' => 'required', 'note' => 'nullable|string|max:1000']);

        $result = $this->repo->PickupReSchedule($request);

        if ($result['status']) {
            return redirect()->back()->with('success', $result['message']);
        }
    }

    public function PickupReScheduleCancel($id)
    {
        $result = $this->repo->PickupReScheduleCancel($id);
        if ($result['status']) {
            return back()->with('success', $result['message']);
        }
        return back()->with('danger', $result['message']);
    }


    public function receivedByPickupMan(Request $request)
    {
        $result = $this->repo->receivedByPickupMan($request->parcel_id, $request);

        if ($result['status']) {
            return redirect()->back()->with('success', $result['message']);
        }
        return redirect()->back()->with('danger', $result['message']);
    }

    public function receivedByHub(Request $request)
    {
        $result = $this->repo->receivedByHub($request);

        if ($result['status']) {
            return redirect()->back()->with('success', $result['message']);
        }
        return redirect()->back()->with('danger', $result['message']);
    }

    public function receivedByHubCancel($id)
    {
        $result = $this->repo->receivedByHubCancel($id);

        if ($result['status']) {
            return redirect()->back()->with('success', $result['message']);
        }
        return redirect()->back()->with('danger', $result['message']);
    }

    public function receivedByPickupManCancel($id)
    {
        $result = $this->repo->receivedByPickupManCancel($id);

        if ($result['status']) {
            return redirect()->back()->with('success', $result['message']);
        }
        return redirect()->back()->with('danger', $result['message']);
    }

    public function searchForHUbTransfer(Request $request)
    {
        if (!request()->ajax()) {
            return response()->json(['error' => ___('alert.invalid_request')], 422);
        }

        if ($request->tracking_id == null) {
            return response()->json(['error' => 'tracking id can not be null.'], 422);
        }

        $request->merge(['status' => [ParcelStatus::RECEIVED_WAREHOUSE, ParcelStatus::RECEIVED_BY_HUB]]);

        $parcel = $this->repo->searchParcel($request);

        if (!$parcel) {
            return response()->json(['error' => ___('parcel.no_parcel_pound')], 400);
        }

        return response()->json($parcel);
    }

    public function searchForBulkHeroAssign(Request $request)
    {
        if (!request()->ajax()) {
            return response()->json(['error' => ___('alert.invalid_request')], 422);
        }

        if ($request->tracking_id == null) {
            return response()->json(['error' => 'tracking id can not be null.'], 422);
        }

        $request->merge(['status' => [ParcelStatus::RECEIVED_WAREHOUSE, ParcelStatus::RECEIVED_BY_HUB]]);

        $parcel = $this->repo->searchParcel($request);

        if (!$parcel) {
            return response()->json(['error' => ___('parcel.no_parcel_pound')], 400);
        }

        return response()->json($parcel);
    }

    // public function searchExpense(Request $data)
    // {
    //     return $this->repo->searchExpense($data);
    // }

    // public function searchIncome(Request $data)
    // {
    //     return $this->repo->searchIncome($data);
    // }

    public function transferToHubMultipleParcel(Request $request)
    {
        $request->validate(['hub_id' => 'required', 'parcel_ids' => 'required']);

        $result = $this->repo->transferToHubMultipleParcel($request);

        if ($result['status']) {

            return redirect()->back()->with('success', $result['message']);

            // if print need then uncomment
            // $deliveryman    = $this->deliveryman->get($request->delivery_man_id);
            // $parcels        = $this->repo->bulkParcels($request->parcel_ids);
            // $bulk_type      = ParcelStatus::TRANSFER_TO_HUB;
            // $transferred_hub = Hub::find($request->hub_id);
            // return view('backend.parcel.bulk_print', compact('parcels', 'deliveryman', 'bulk_type', 'transferred_hub'))->with('success', $result['message']);
        }
        return redirect()->back()->with('danger', $result['message']);
    }

    public function deliveryManAssignMultipleParcel(Request $request)
    {
        $request->validate(['delivery_man_id' => 'required', 'parcel_ids_' => 'required']);

        $result = $this->repo->deliveryManAssignMultipleParcel($request);

        if ($result['status']) {
            return redirect()->back()->with('success', $result['message']);

            // if print need then uncomment
            // $deliveryman = $this->deliveryman->get($request->delivery_man_id);
            // $parcels    = $this->repo->bulkParcels($request->parcel_ids_);
            // $bulk_type  = ParcelStatus::DELIVERY_MAN_ASSIGN;
            // return view('backend.parcel.bulk_print', compact('parcels', 'deliveryman', 'bulk_type'))->with('success', $result['message']);
        }
        return redirect()->back()->with('danger', $result['message']);
    }

    public function ParcelBulkAssignPrint(Request $request)
    {
        try {
            $deliveryman  = $this->deliveryman->get($request->delivery_man_id);
            $parcels      = $this->repo->bulkParcels($request->parcels);
            $bulk_type    = ParcelStatus::DELIVERY_MAN_ASSIGN;
            $reprint      = true;
            return view('backend.parcel.bulk_print', compact('parcels', 'deliveryman', 'bulk_type', 'reprint'));
        } catch (\Throwable $th) {
            return redirect()->back()->with('danger', ___('alert.something_went_wrong'));
        }
    }

    public function transferToHub(Request $request)
    {
        $request->validate(['hub_id' => 'required']);

        $result = $this->repo->transferToHub($request);

        if ($result['status']) {
            return redirect()->back()->with('success', $result['message']);
        }

        return redirect()->back()->with('danger', $result['message']);
    }

    public function transferToHubCancel($id)
    {
        $result = $this->repo->transferToHubCancel($id);
        if ($result['status']) {
            return redirect()->back()->with('success', $result['message']);
        }
        return redirect()->back()->with('danger', $result['message']);
    }

    public function deliverymanAssign(Request $request)
    {
        $request->validate(['delivery_man_id' => 'required']);

        $result = $this->repo->deliverymanAssign($request);

        if ($result['status']) {
            return redirect()->back()->with('success', $result['message']);
        }
        return redirect()->back()->with('danger', $result['message']);
    }

    public function deliverymanAssignCancel($id)
    {
        $result = $this->repo->deliverymanAssignCancel($id);
        if ($result['status']) {
            return redirect()->back()->with('success', $result['message']);
        }
        return redirect()->back()->with('danger', $result['message']);
    }

    public function deliveryReschedule(Request $request)
    {
        $request->validate(['delivery_man_id' => 'required', 'date' => 'required']);

        $result = $this->repo->deliveryReschedule($request);

        if ($result['status']) {
            return redirect()->back()->with('success', $result['message']);
        }
        return redirect()->back()->with('danger', $result['message']);
    }

    public function deliveryReScheduleCancel($id)
    {
        $result = $this->repo->deliveryReScheduleCancel($id);
        if ($result['status']) {
            return redirect()->back()->with('success', $result['message']);
        }
        return back()->with('danger', $result['message']);
    }

    public function receivedWarehouse(Request $request)
    {

        $request->validate(['hub_id' => 'required']);

        $result = $this->repo->receivedWarehouse($request);

        if ($result['status']) {
            return redirect()->back()->with('success', $result['message']);
        }
        return back()->with('danger', $result['message']);
    }

    public function receivedWarehouseCancel($id)
    {
        $result = $this->repo->receivedWarehouseCancel($id);
        if ($result['status']) {
            return redirect()->back()->with('success', $result['message']);
        }
        return back()->with('danger', $result['message']);
    }

    public function returnToCourier(Request $request)
    {
        $result = $this->repo->returnToCourier($request->parcel_id, $request);

        if ($result['status']) {
            return redirect()->back()->with('success', $result['message']);
        }
        return back()->with('danger', $result['message']);
    }

    public function returnToCourierCancel($id)
    {
        $result = $this->repo->returnToCourierCancel($id);
        if ($result['status']) {
            return redirect()->back()->with('success', $result['message']);
        }
        return back()->with('danger', $result['message']);
    }

    public function returnAssignToMerchant(Request $request)
    {
        $request->validate(['delivery_man_id' => 'required', 'date' => 'required']);

        $result = $this->repo->returnAssignToMerchant($request->parcel_id, $request);
        if ($result['status']) {
            return redirect()->back()->with('success', $result['message']);
        }
        return back()->with('danger', $result['message']);
    }

    public function returnAssignToMerchantCancel($id)
    {
        $result = $this->repo->returnAssignToMerchantCancel($id);
        if ($result['status']) {
            return redirect()->back()->with('success', $result['message']);
        }

        return redirect()->back()->with('danger', $result['message']);
    }

    public function returnAssignToMerchantReschedule(Request $request)
    {
        $request->validate(['delivery_man_id' => 'required', 'date' => 'required']);

        $result = $this->repo->returnAssignToMerchantReschedule($request->parcel_id, $request);

        if ($result['status']) {
            return redirect()->back()->with('success', $result['message']);
        }
        return redirect()->back()->with('danger', $result['message']);
    }

    public function returnAssignToMerchantRescheduleCancel($id)
    {
        $result = $this->repo->returnAssignToMerchantRescheduleCancel($id);
        if ($result['status']) {
            return redirect()->back()->with('success', $result['message']);
        }
        return redirect()->back()->with('danger', $result['message']);
    }

    public function returnReceivedByMerchant(Request $request)
    {
        $result = $this->repo->returnReceivedByMerchant($request->parcel_id, $request);

        if ($result['status']) {
            return redirect()->back()->with('success', $result['message']);
        }
        return redirect()->back()->with('danger', $result['message']);
    }

    public function returnReceivedByMerchantCancel($id)
    {
        $result = $this->repo->returnReceivedByMerchantCancel($id);
        if ($result['status']) {
            return redirect()->back()->with('success', $result['message']);
        }
        return redirect()->back()->with('danger', $result['message']);
    }

    public function parcelDelivered(ParcelDeliveredRequest $request)
    {
        $result = $this->repo->parcelDelivered($request);

        if ($request->wantsJson()) {
            return response()->json($result);
        }

        if ($result['status']) {
            return redirect()->back()->with('success', $result['message']);
        }

        return redirect()->back()->with('danger', $result['message']);
    }

    public function parcelDeliveredCancel($id)
    {
        $result = $this->repo->parcelDeliveredCancel($id);
        if ($result['status']) {
            return redirect()->back()->with('success', $result['message']);
        }
        return redirect()->back()->with('danger', $result['message']);
    }

    public function parcelPartialDelivered(ParcelDeliveredRequest $request)
    {
        $result = $this->repo->parcelPartialDelivered($request);

        if ($request->wantsJson()) {
            return response()->json($result);
        }

        if ($result['status']) {
            return redirect()->back()->with('success', $result['message']);
        }
        return redirect()->back()->with('danger', $result['message']);
    }

    public function parcelPartialDeliveredCancel($id)
    {
        $result = $this->repo->parcelPartialDeliveredCancel($id);
        if ($result['status']) {
            return back()->with('success', $result['message']);
        }
        return back()->with('danger', $result['message']);
    }

    public function parcelPrintLabel($id)
    {
        $parcel = $this->repo->get($id);
        $merchant = $this->merchant->get($parcel->merchant_id);
        $shops = $this->shop->all($parcel->merchant_id);
        return view('backend.parcel.print_label', compact('parcel', 'merchant', 'shops'));
    }

    public function parcelPrint($id)
    {
        $parcel = $this->repo->get($id);
        $merchant = $this->merchant->get($parcel->merchant_id);
        $shops = $this->shop->all($parcel->merchant_id);
        return view('backend.parcel.print_invoice', compact('parcel', 'merchant', 'shops'));
    }

    public function parcelReceivedByMultipleHub(Request $request)
    {
        $result = $this->repo->parcelReceivedByMultipleHub($request);
        if ($result['status']) {
            return redirect()->back()->with('success', $result['message']);
        }
        return back()->with('danger', $result['message']);
    }

    //Assign pickup bulk parcel search
    public function AssignPickupParcelSearch(Request $request)
    {
        if (!request()->ajax()) {
            return response()->json(['error' => ___('alert.invalid_request')], 422);
        }

        if ($request->tracking_id == null) {
            return response()->json(['error' => 'tracking id can not be null.'], 422);
        }

        $request->merge(['status' => ParcelStatus::PENDING]);

        $parcel = $this->repo->searchParcel($request);

        if (!$parcel) {
            return response()->json(['error' => ___('parcel.no_parcel_pound')], 400);
        }

        return response()->json($parcel);
    }

    //assign pickup bulk store
    public function AssignPickupBulk(Request $request)
    {
        $request->validate(['delivery_man_id' => 'required|exists:delivery_man,id',]);

        $result = $this->repo->bulkPickupManAssign($request);
        if ($result['status']) {
            return redirect()->back()->with('success', $result['message']);
        }
        return back()->with('danger', $result['message']);
    }

    //assign return to merchant
    //return to courier percel will be show
    public function AssignReturnToMerchantParcelSearch(Request $request)
    {
        if (!request()->ajax()) {
            return response()->json(['error' => ___('alert.invalid_request')], 422);
        }

        if ($request->tracking_id == null) {
            return response()->json(['error' => 'tracking id can not be null.'], 422);
        }

        $request->merge(['status' => ParcelStatus::RETURN_TO_COURIER]);

        $parcel = $this->repo->searchParcel($request);

        if (!$parcel) {
            return response()->json(['error' => ___('parcel.no_parcel_pound')], 400);
        }

        return response()->json($parcel);
    }

    //assign return to merchant bulk store
    public function AssignReturnToMerchantBulk(Request $request)
    {
        $request->validate(['delivery_man_id' => 'required|exists:delivery_man,id',  'date' => 'required|date']);

        $result = $this->repo->AssignReturnToMerchantBulk($request);
        if ($result['status']) {
            return redirect()->back()->with('success', $result['message']);
            // if need print then uncomment below code .
            $deliveryman    = $this->deliveryman->get($request->delivery_man_id);
            $parcels        = $this->repo->bulkParcels($request->parcel_ids);
            $bulk_type      = ParcelStatus::RETURN_ASSIGN_TO_MERCHANT;
            return view('backend.parcel.bulk_print', compact('parcels', 'deliveryman', 'bulk_type'))->with('success', $result['message']);
        }
        return redirect()->back()->with('danger', $result['message']);
    }

    //received warehouse hub auto selected
    public function warehouseHubSelected(Request $request)
    {
        $hubs_list  = "";
        $hubs_list .= "<option>" . ___("menus.select") . " " . ___("hub.title") . "</option>";

        if ($request->hub_id) :
            $hubs = Hub::all();
            foreach ($hubs as $hub) {

                if ($hub->id == $request->hub_id) {
                    $hubs_list .= "<option selected value=" . $hub->id . " >" . $hub->name . "</option>";
                } else {
                    $hubs_list .= "<option   value='" . $hub->id . "' >" . $hub->name . "</option>";
                }
            }
        else :
            $hubs = Hub::all();
            foreach ($hubs as $key => $hub) {

                $hubs_list .= "<option   value='" . $hub->id . "' >" . $hub->name . "</option>";
            }
        endif;

        return $hubs_list;
    }

    public function ParcelSearch(Request $request)
    {
        if ($this->repo->parcelSearch($request)) {
            $parcels          = $this->repo->parcelSearch($request);
            $deliverymans = $this->deliveryman->all(status: Status::ACTIVE);
            $hubs         = $this->hub->all();
            // $request['search']='on';
            return view('backend.parcel.index', compact('parcels', 'request', 'deliverymans', 'hubs'));
        } else {
            return redirect()->back();
        }
    }

    //parcel sample export
    public function parcelSampleExport()
    {
        return Excel::download(new ParcelSampleExport, 'invoice.xlsx');
    }

    public function parcelsCashCollectByDeliveryMan(Request $request)
    {
        if (!request()->ajax()) {
            return response()->json(['message' => ___('alert.invalid_request')], 422);
        }

        if ($request->delivery_man_id == null) {
            return response()->json(['message' => 'Delivery Man id can not be null.'], 422);
        }

        $query = Parcel::query();

        $query->with('parcelTransaction:parcel_id,cash_collection,total_charge');

        $query->where('cash_collection_status', CashCollectionStatus::PENDING);

        $query->whereHas('parcelTransaction', fn($query) => $query->where('cash_collection', '>', 0));

        $query->whereHas('parcelEvent', fn($query) => $query->where('delivery_man_id', $request->delivery_man_id));

        $query->where(fn($query) => $query->where('status', ParcelStatus::DELIVERED)->orWhere('partial_delivered', true));

        $parcels = $query->get(['id', 'tracking_id', 'delivery_date']);

        if ($parcels->isEmpty()) {
            return response()->json(['message' => 'No Parcels found'], 404);
        }

        return response()->json($parcels);
    }

    public function parcelsCashInHub(Request $request)
    {
        if (!request()->ajax()) {
            return response()->json(['message' => ___('alert.invalid_request')], 422);
        }

        if ($request->hub_id == null) {
            return response()->json(['message' => 'Hub id can not be null.'], 422);
        }

        $query = Parcel::query();
        $query->with('parcelTransaction:parcel_id,cash_collection,total_charge');
        $query->whereHas('parcelEvent', fn($query)  => $query->where('hub_id', $request->hub_id));
        $query->where('cash_collection_status', CashCollectionStatus::RECEIVED_BY_HUB);
        $parcels = $query->get(['id', 'tracking_id', 'delivery_date']);

        if ($parcels->isEmpty()) {
            return response()->json(['message' => 'No Parcels found'], 404);
        }

        return response()->json($parcels);
    }


    public function parcelsChargeUnpaid(Request $request)
    {
        if (!request()->ajax()) {
            return response()->json(['message' => ___('alert.invalid_request')], 422);
        }

        if ($request->merchant_id == null) {
            return response()->json(['message' => 'Merchant id can not be null.'], 422);
        }

        $query = Parcel::query();
        $query->with('parcelTransaction:parcel_id,cash_collection,total_charge');
        $query->where('is_charge_paid', false);
        $query->where('merchant_id', $request->merchant_id);
        $query->where(fn($query) => $query->where('status', ParcelStatus::DELIVERED)->orWhere('partial_delivered', true));
        // $parcels->where('cash_collection_status', CashCollectionStatus::RECEIVED_BY_ADMIN);
        // $parcels->whereHas('parcelTransaction', fn ($query) => $query->where('cash_collection', 0));
        $parcels = $query->get(['id', 'tracking_id', 'delivery_date']);

        if ($parcels->isEmpty()) {
            return response()->json(['message' => ___('alert.no_parcel_found')], 404);
        }

        return response()->json($parcels);
    }


    public function parcelsUnpaidHeroCommission(Request $request)
    {
        if (!request()->ajax()) {
            return response()->json(['message' => ___('alert.invalid_request')], 422);
        }

        if ($request->delivery_man_id == null) {
            return response()->json(['message' => 'Delivery Man id can not be null.'], 422);
        }

        $query = DeliveryHeroCommission::query();
        $query->with(['parcel']);
        $query->where('status',  Status::ACTIVE);
        $query->where('payment_status',  PaymentStatus::UNPAID);

        $query->where(
            fn($query) =>
            $query->where('delivery_hero_id', $request->input('delivery_man_id'))
                ->orWhere('pickup_hero_id', $request->input('delivery_man_id'))
        );


        $parcels = $query->get();

        if ($parcels->isEmpty()) {
            return response()->json(['message' => 'No Commission unpaid parcel found'], 404);
        }

        return response()->json($parcels);
    }

    private $statusForUpdate = [
        ParcelStatus::DELIVERED,
        ParcelStatus::PARTIAL_DELIVERED
    ];

    public function requestParcelDelivery(Request $request)
    {

        $data = Validator::make($request->all(), [
            'parcel_id' => 'required|exists:parcels,id',
            'status'    => 'required|in:' . implode(',', $this->statusForUpdate)
        ]);

        if ($data->fails()) {
            return response()->json(['message' => 'alert.validation_error']);
        }

        $result = $this->repo->requestParcelDelivery($request);

        if ($result['status']) {

            return response()->json($result);
        }
        return response()->json($result);
    }
}
