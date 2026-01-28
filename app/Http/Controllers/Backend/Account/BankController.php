<?php

namespace App\Http\Controllers\Backend\Account;

use App\Http\Controllers\Controller;
use App\Repositories\Bank\BankInterface;
use App\Http\Requests\Bank\BankStoreRequest;
use App\Http\Requests\Bank\BankUpdateRequest;


class BankController extends Controller
{
    private $repo;

    public function __construct(BankInterface $repo)
    {
        $this->repo = $repo;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $banks = $this->repo->all(paginate: settings('paginate_value'));
        return view('backend.bank.index', compact('banks'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('backend.bank.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BankStoreRequest $request)
    {
        $result = $this->repo->store($request);
        if ($result['status']) {
            return redirect()->route('banks.index')->with('success', $result['message']);
        }
        return back()->with('danger', $result['message']);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $banks       = $this->repo->get($id);
        return view('backend.bank.edit', compact('banks'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(BankUpdateRequest $request, $id)
    {
        $result = $this->repo->update($request, $id);
        if ($result['status']) {
            return redirect()->route('banks.index')->with('success', $result['message']);
        }
        return back()->with('danger', $result['message']);
    }

    /**
     * Remove the specified resource from storage.
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
