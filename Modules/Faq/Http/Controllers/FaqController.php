<?php

namespace Modules\Faq\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Faq\Http\Requests\StoreRequest;
use Modules\Faq\Http\Requests\UpdateRequest;
use Modules\Faq\Repositories\FaqInterface;

class FaqController extends Controller
{
    protected $repo;
    public function __construct(FaqInterface $repo)
    {
        $this->repo = $repo;
    }

    public function index()
    {
        $all_faq = $this->repo->all();
        return view('faq::faq.index', compact('all_faq'));
    }

    public function create()
    {
        return view('faq::faq.create');
    }

    public function edit($id)
    {
        $faq = $this->repo->find($id);
        return view('faq::faq.edit', compact('faq'));
    }

    public function store(StoreRequest $request)
    {
        $result = $this->repo->store($request);
        if ($result['status']) {
            return redirect()->route('faq.index')->with('success', $result['message']);
        }
        return back()->with('danger', $result['message']);
    }

    public function update(UpdateRequest $request, $id)
    {
        $result = $this->repo->update($request, $id);
        if ($result['status']) {
            return redirect()->route('faq.index')->with('success', $result['message']);
        }
        return back()->with('danger', $result['message']);
    }

    public function destroy($id)
    {
        if ($this->repo->destroy($id)) :
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
        if (env('DEMO')) {
            toast(__('update_system_error'), 'error');
            return redirect()->back()->withInput();
        }

        $result = $this->repo->statusUpdate($id);
        if ($result['status']) {
            return redirect()->route('faq.index')->with('success', $result['message']);
        }
        return back()->with('danger', $result['message']);
    }
}
