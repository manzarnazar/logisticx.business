<?php

namespace Modules\Features\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Contracts\Support\Renderable;
use Modules\Features\Http\Requests\features\StoreRequest;
use Modules\Features\Http\Requests\features\UpdateRequest;
use Modules\Features\Repositories\Features\FeaturesInterface;

class FeaturesController extends Controller
{

    private $repo;

    public function __construct(FeaturesInterface $repo)
    {
        $this->repo = $repo;
    }

    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $features = $this->repo->get();
        return view('features::features.index', compact('features'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('features::features.create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(StoreRequest $request)
    {
        $result = $this->repo->store($request);
        if ($result['status']) {
            return redirect()->route('features.index')->with('success', $result['message']);
        }
        return back()->with('danger', $result['message'])->withInput();
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        $features       = $this->repo->getFind($id);
        return view('features::features.edit', compact('features'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(UpdateRequest $request, $id)
    {
        $result = $this->repo->update($request, $id);
        if ($result['status']) {
            return redirect()->route('features.index')->with('success', $result['message']);
        }
        return back()->with('danger', $result['message'])->withInput();
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
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

    public function statusUpdate($id)
    {
        if ($this->repo->statusUpdate($id)) {
            toast(__('features_status_update'), 'success');
            return redirect()->route('features.index');
        } else {
            toast(__('error'), 'error');
            return redirect()->back();
        }
    }
}
