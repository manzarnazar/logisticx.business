<?php

namespace App\Http\Controllers\Backend\Setting;

use App\Http\Controllers\Controller;
use App\Repositories\PayoutSetup\PayoutSetupInterface;
use Illuminate\Http\Request;

class PayoutSetupController extends Controller
{
    protected $repo, $MOPmodel;

    public function __construct(PayoutSetupInterface $repo)
    {
        $this->repo     = $repo;
    }

    public function index()
    {
        return view('backend.setting.payout_setup.index');
    }

    public function PayoutSetupUpdate(Request $request, $paymentMethod)
    {

        $result = $this->repo->update($paymentMethod, $request);
        if ($result['status']) {
            return redirect()->back()->with('success', $result['message']);
        }
        return back()->with('danger', $result['message'])->withInput();
    }

   
}
