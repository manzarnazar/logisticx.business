<?php

namespace Modules\Client\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Client\Http\Requests\UpdateRequest;
use Modules\Client\Http\Requests\StoreRequest;
use Modules\Client\Repositories\Client\ClientInterface;


class ClientController extends Controller
{
    protected $repo;

    public function __construct(ClientInterface $repo)
    {
        $this->repo         = $repo;
    }

    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $companies = $this->repo->all();
        return view('client::client.index', compact('companies'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('client::client.create');
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
            return redirect()->route('client.index')->with('success', $result['message']);
        }
        return back()->with('danger', $result['message']);
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('client::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        $client       = $this->repo->getFind($id);
        return view('client::client.edit', compact('client'));
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
            return redirect()->route('client.index')->with('success', $result['message']);
        }
        return back()->with('danger', $result['message']);
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
}
