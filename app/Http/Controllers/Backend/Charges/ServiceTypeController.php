<?php

namespace App\Http\Controllers\Backend\Charges;

use App\Http\Controllers\Controller;
use App\Http\Requests\Charges\ServiceType\ServiceTypeStoreRequest;
use App\Http\Requests\Charges\ServiceType\ServiceTypeUpdateRequest;
use App\Models\backend\charges\ServiceType;
use App\Repositories\ServiceType\ServiceTypeInterface;

class ServiceTypeController extends Controller
{
    private $repo;

    public function __construct(ServiceTypeInterface $repo)
    {
        $this->repo = $repo;
    }

    public function index()
    {
        $serviceTypes = $this->repo->all(paginate: settings('paginate_value'));
        return view('backend.service_type.index', compact('serviceTypes'));
    }

    public function create()
    {
        return view('backend.service_type.create');
    }

    public function store(ServiceTypeStoreRequest $request)
    {
        $result = $this->repo->store($request);
        if ($result['status']) {
            return redirect()->route('serviceType')->with('success', $result['message']);
        }
        return back()->with('danger', $result['message']);
    }

    public function edit($id)
    {
        $serviceType = ServiceType::find($id);
        return view('backend.service_type.update', compact('serviceType'));
    }

    public function update(ServiceTypeUpdateRequest $request)
    {
        $result = $this->repo->update($request);
        if ($result['status']) {
            return redirect()->route('serviceType')->with('success', $result['message']);
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
}
