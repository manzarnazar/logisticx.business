<?php

namespace App\Http\Controllers\Backend\Account;

use Illuminate\Http\Request;
use App\Models\Backend\AccountHead;
use App\Http\Controllers\Controller;
use App\Http\Requests\AccountHeads\StoreRequest;
use App\Http\Requests\AccountHeads\UpdateRequest;
use App\Repositories\AccountHeads\AccountHeadsInterface;

class AccountHeadsController extends Controller
{

    protected $repo;

    public function __construct(AccountHeadsInterface $repo)
    {
        $this->repo  = $repo;
    }

    public function index()
    {
        $account_heads  = $this->repo->all();
        $protectedIds   = AccountHead::protectedIds();

        return view('backend.account_heads.index', compact('account_heads', 'protectedIds'));
    }

    public function create()
    {
        $account_heads = $this->repo->all();
        return view('backend.account_heads.create', compact('account_heads'));
    }

    public function store(StoreRequest $request)
    {
        $result = $this->repo->store($request);
        if ($result['status']) {
            return redirect()->route('account.heads.index')->with('success', $result['message']);
        }
        return back()->with('danger', $result['message'])->withInput();
    }

    public function edit($id)
    {
        $account_heads = $this->repo->get($id);
        return view('backend.account_heads.edit', compact('account_heads'));
    }

    public function update($id, UpdateRequest $request)
    {
        $result = $this->repo->update($id, $request);
        if ($result['status']) {
            return redirect()->route('account.heads.index')->with('success', $result['message']);
        }
        return back()->with('danger', $result['message'])->withInput();
    }

    public function destroy($id)
    {
        $result = $this->repo->delete($id);

        if ($result['status']) :
            $success[0] = $result['message'];
            $success[1] = 'success';
            $success[2] = ___('delete.deleted');
            return response()->json($success);
        else :
            $success[0] = $result['message'];
            // $success[0] = ___('alert.something_went_wrong');
            $success[1] = 'error';
            $success[2] = ___('delete.oops');
            return response()->json($success);
        endif;
    }
}
