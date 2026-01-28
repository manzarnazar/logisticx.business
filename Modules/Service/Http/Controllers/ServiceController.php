<?php

namespace Modules\Service\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Service\Http\Requests\ServiceStoreRequest;
use Modules\Service\Http\Requests\ServiceUpdateRequest;
use Modules\Service\Repositories\Service\ServiceInterface;

class ServiceController extends Controller
{
    protected $repo;

    public function __construct(ServiceInterface $repo)
    {
        $this->repo = $repo;
    }

    public function index()
    {
        $services = $this->repo->all();
        return view('service::service.index', compact('services'));
    }

    public function create()
    {
        return view('service::service.create');
    }

    public function store(ServiceStoreRequest $request)
    {
        // dd($request->banner_image);

        $result = $this->repo->store($request);
        if ($result['status']) {
            return redirect()->route('service.index')->with('success', $result['message']);
        }
        return back()->with('danger', $result['message'])->withInput();
    }

    public function edit($id)
    {
        $service = $this->repo->get($id);
        // dd($service->image);
        return view('service::service.edit', compact('service'));
    }

    public function update(ServiceUpdateRequest $request)
    {
        $result = $this->repo->update($request);
        if ($result['status']) {
            return redirect()->route('service.index')->with('success', $result['message']);
        }
        return back()->with('danger', $result['message'])->withInput();
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

    public function statusUpdate($id)
    {
        $result = $this->repo->statusUpdate($id);
        if ($result['status']) {
            return redirect()->route('service.index')->with('success', $result['message']);
        }
        return back()->with('danger', $result['message']);
    }
}
