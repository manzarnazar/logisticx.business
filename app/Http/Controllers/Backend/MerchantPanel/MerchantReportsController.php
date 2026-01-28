<?php

namespace App\Http\Controllers\Backend\MerchantPanel;

use Illuminate\Http\Request;
use App\Models\Backend\Parcel;
use App\Http\Controllers\Controller;
use App\Repositories\Hub\HubInterface;
use App\Repositories\Reports\ReportsInterface;

class MerchantReportsController extends Controller
{
    protected $hub;
    protected $repo;
    public function __construct(ReportsInterface $repo, HubInterface $hub,)
    {
        $this->repo = $repo;
        $this->hub  =  $hub;
    }
    public function parcelReports(Request $request)
    {
        // $filteredIds    = [];
        return view('backend.merchant_panel.reports.parcel_reports', compact('request'));
    }

    public function parcelSReports(Request $request)
    {
        
        if ($this->repo->merchantParcelReports($request)) {


            $parcels        =  $this->repo->merchantParcelReports($request);

            $filteredIds    = [];

            foreach ($parcels as $key => $parcel) {
                foreach ($parcel as $key => $parcl) {
                    $filteredIds = $parcl->pluck('id')->toArray();
                }
            }
            return view('backend.merchant_panel.reports.parcel_reports', compact('parcels', 'request', 'filteredIds'));
        } else {
            return redirect()->back();
        }
    }

    
    public function parcelReportsPrint(Request $request, $array)
    {
        $parcel_ids  = [];
        foreach (explode(',', $array) as  $id) {
            if ($id !== "") :
                $parcel_ids[] = $id;
            endif;
        }
        $parcels    = Parcel::whereIn('id', $parcel_ids)->orderBy('id')->get();
        $parcels    = $parcels->groupBy('status');
        return view('backend.merchant_panel.reports.parcel_reports_print', compact('parcels'));
    }
}
