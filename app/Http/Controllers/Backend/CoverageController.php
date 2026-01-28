<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Coverage\CoverageStoreRequest;
use App\Repositories\Coverage\CoverageInterface;
use Illuminate\Http\Request;

class CoverageController extends Controller
{
    private $repo;

    public function __construct(CoverageInterface $repo)
    {
        $this->repo          = $repo;
    }

    public function index()
    {
        $coverages = $this->repo->all(paginate: settings('paginate_value'));

        return view('backend.coverage.index', compact('coverages'));
    }

    public function create()
    {
        $coverages = $this->repo->getWithActiveChild();

        return view('backend.coverage.create', compact('coverages'));
    }

    public function store(CoverageStoreRequest $request)
    {
        $result = $this->repo->store($request);
        if ($result['status']) {
            return redirect()->route('coverage.index')->with('success', $result['message']);
        }
        return redirect()->back()->withInput()->with('danger', $result['message']);
    }

    public function edit($id)
    {
        $area       = $this->repo->get($id);
        $coverages  = $this->repo->getWithActiveChild();

        return view('backend.coverage.edit', compact('area', 'coverages'));
    }

    public function update(CoverageStoreRequest $request)
    {
        $result = $this->repo->update($request);
        if ($result['status']) {
            return redirect()->route('coverage.index')->with('success', $result['message']);
        }
        return redirect()->back()->withInput()->with('danger', $result['message']);
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


    // ====================================================================================================================
    // Merchant charge Ajax response
    // ====================================================================================================================

    public function detectArea(Request $request)
    {
        if (!request()->ajax()) {
            return response()->json(['message' => ___('alert.invalid_request')], 400);
        }

        $area = $this->repo->detectArea($request->pickup_id, $request->destination_id);
        return response()->json(['area' => $area]);
    }
}
