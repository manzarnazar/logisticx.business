<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Fraud\StoreRequest;
use App\Http\Requests\Fraud\UpdateRequest;
use App\Repositories\Fraud\FraudInterface;

class FraudController extends Controller
{
    protected $repo;

    public function __construct(FraudInterface $repo)
    {
        $this->repo = $repo;
    }

    public function index()
    {
        $frauds = $this->repo->all();
        return view('backend.fraud.index', compact('frauds'));
    }

    public function create()
    {
        return view('backend.fraud.create');
    }

    public function store(StoreRequest $request)
    {
        $result = $this->repo->store($request);
        if ($result['status']) {
            return redirect()->route('fraud.index')->with('success', $result['message']);
        }
        return back()->with('danger', $result['message']);
    }

    public function edit($id)
    {
        $fraud = $this->repo->get($id);
        return view('backend.fraud.edit', compact('fraud'));
    }

    public function update(UpdateRequest $request)
    {
        $result = $this->repo->update($request->id, $request);
        if ($result['status']) {
            return redirect()->route('fraud.index')->with('success', $result['message']);
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
