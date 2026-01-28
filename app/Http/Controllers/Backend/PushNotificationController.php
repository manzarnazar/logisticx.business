<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\PushNotification\StorePushNotificationRequest;
use App\Http\Requests\PushNotification\UpdatePushNotificationRequest;
use App\Http\Services\PushNotificationService;
use App\Repositories\PushNotification\PushNotificationInterface;
use Brian2694\Toastr\Facades\Toastr;

class PushNotificationController extends Controller
{
    protected $repo;
    public function __construct(PushNotificationInterface $repo, PushNotificationService $pushNotificationService)
    {
        $this->repo = $repo;
    }

    public function index()
    {
        $pushNotifications = $this->repo->all();
        return view('backend.push-notification.index', compact('pushNotifications'));
    }

    public function create()
    {
        return view('backend.push-notification.create');
    }

    public function store(StorePushNotificationRequest $request)
    {
        $result = $this->repo->store($request);
        if ($result['status']) {
            return redirect()->route('push-notification.index')->with('success', $result['message']);
        }
        return back()->with('danger', $result['message']);
    }

    public function edit($id)
    {
        $pushNotification = $this->repo->get($id);
        return view('backend.push-notification.edit', compact('pushNotification'));
    }

    public function update($id, UpdatePushNotificationRequest $request)
    {
        $result = $this->repo->update($id, $request);
        if ($result['status']) {
            return redirect()->route('push-notification.index')->with('success', $result['message']);
        }
        return back()->with('danger', $result['message']);
    }

    public function destroy($id)
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
}
