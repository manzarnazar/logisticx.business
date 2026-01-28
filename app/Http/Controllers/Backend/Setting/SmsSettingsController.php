<?php

namespace App\Http\Controllers\Backend\Setting;

use App\Enums\Status;
use App\Http\Controllers\Controller;
use App\Http\Requests\SmsSetting\StoreRequest;
use App\Models\Backend\SmsSetting;
use App\Models\Config;
use App\Repositories\SmsSetting\SmsSettingInterface;
use Illuminate\Http\Request;
use Brian2694\Toastr\Facades\Toastr;

class SmsSettingsController extends Controller
{
    protected $repo;
    public function __construct(SmsSettingInterface $repo)
    {
        $this->repo  = $repo;
    }
    public function index()
    {
        $smsSettings = $this->repo->all();
        return view('backend.setting.sms.index', compact('smsSettings'));
    }
    public function create()
    {
        return view('backend.setting.sms.create');
    }
    public function store(StoreRequest $request)
    {
        $result = $this->repo->store($request);
        if ($result['status']) {
            return redirect()->route('sms-settings.index')->with('success', $result['message']);
        }
        return back()->with('danger', $result['message']);
    }

    public function edit($id)
    {
        $smsSetting   = $this->repo->get($id);
        return view('backend.setting.sms.edit', compact('smsSetting'));
    }

    public function update($id, StoreRequest $request)
    {
        $result = $this->repo->update($id, $request);
        if ($result['status']) {
            return redirect()->route('sms-settings.index')->with('success', $result['message']);
        }
        return back()->with('danger', $result['message']);
    }

    public function delete($id)
    {
        if ($this->repo->delete($id)) :
            $success[0] = ___('alert.successfully_deleted');
            $success[1] = 'success';
            $success[2] = ___('delete.deleted');
            return response()->json($success);
        else :
            $success[0] = ___('alert.something_went_wrong');
            $success[1] = 'error';
            $success[2] = ___('delete.oops');
            return response()->json($success);
        endif;
    }

    public function status(Request $request)
    {

        $smsSetting             =  SmsSetting::where(['id' => $request->id])->first();
        if (Status::ACTIVE == $request->status) {
            $smsSetting->status      =  Status::INACTIVE;
        } else {
            $smsSetting->status      =  Status::ACTIVE;
        }
        $smsSetting->save();
        return $smsSetting;
    }
}
