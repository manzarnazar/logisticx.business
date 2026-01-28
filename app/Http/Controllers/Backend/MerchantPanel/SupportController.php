<?php

namespace App\Http\Controllers\Backend\MerchantPanel;

use App\Enums\UserType;
use Illuminate\Http\Request;
use App\Models\Backend\SupportChat;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\MerchantPanel\Support\StoreRequest;
use App\Repositories\MerchantPanel\Support\SupportInterface;

class SupportController extends Controller
{
    protected $repo;

    public function __construct(SupportInterface $repo)
    {
        $this->repo = $repo;
    }
    public function index()
    {
        $supports = $this->repo->all();
        return view('backend.merchant_panel.support.index', compact('supports'));
    }

    public function create()
    {
        $departments = $this->repo->departments();

        return view('backend.merchant_panel.support.create', compact('departments'));
    }


    public function store(StoreRequest $request)
    {
        $result = $this->repo->store($request);
        if ($result['status']) {
            return redirect()->route('merchant-panel.support.index')->with('success', $result['message']);
        }
        return back()->with('danger', $result['message'])->withInput();
    }

    public function edit($id)
    {
        if (SupportChat::where('support_id', $id)->exists()) {
            return redirect()->route('merchant-panel.support.index')->with('danger',  ___('alert.modification_not_allowed'));
        }

        $departments   = $this->repo->departments();
        $singleSupport = $this->repo->get($id);

        return view('backend.merchant_panel.support.edit', compact('departments', 'singleSupport'));
    }


    public function update(StoreRequest $request)
    {
        $result = $this->repo->update($request->id, $request);
        if ($result['status']) {
            return redirect()->route('merchant-panel.support.index')->with('success', $result['message']);
        }
        return back()->with('danger', $result['message'])->withInput();
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


    public function view($id)
    {
        $singleSupport = $this->repo->get($id);

        if (auth()->user()->user_type != UserType::ADMIN && auth()->user()->id != $singleSupport->user_id) {
            abort(404);
        }

        $chats         = $this->repo->chats($id);

        return view('backend.merchant_panel.support.view', compact('singleSupport', 'chats'));
    }

    public function supportReply(Request $request)
    {
        $validator  = Validator::make($request->all(), [
            'message'       => 'required',
            'attached_file' => 'nullable|mimes:png,jpg,jpeg,webp,pdf|max:5120',
        ]);

        if ($validator->fails()) :
            return redirect()->back()->withErrors($validator)->withInput();
        endif;

        $result = $this->repo->reply($request);

        if ($result['status']) {
            return redirect()->route('merchant-panel.support.view', $request->support_id)->with('success', $result['message']);
        }
        return back()->with('danger', $result['message'])->withInput($request->all());
    }
}
