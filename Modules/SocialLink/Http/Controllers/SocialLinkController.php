<?php

namespace Modules\SocialLink\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\SocialLink\Http\Requests\StoreRequest;
use Modules\SocialLink\Http\Requests\UpdateRequest;
use Modules\SocialLink\Repositories\SocialLinkInterface;

class SocialLinkController extends Controller
{
    protected $repo;

    public function __construct(SocialLinkInterface $repo)
    {
        $this->repo = $repo;
    }
    public function index()
    {
        $sociallinks  = $this->repo->get();
        return view('SocialLink::index', compact('sociallinks'));
    }

    public function create()
    {
        return view('SocialLink::create');
    }

    public function store(StoreRequest $request)
    {

        $result = $this->repo->store($request);
        if ($result['status']) {
            return redirect()->route('socialLink.index')->with('success', $result['message']);
        }
        return back()->with('danger', $result['message']);
    }

    public function edit($id)
    {
        $sociallink    = $this->repo->getFind($id);
        return view('SocialLink::edit', compact('sociallink'));
    }

    public function update(UpdateRequest $request)
    {

        $result = $this->repo->update($request, $request->id);

        if ($result['status']) {
            return redirect()->route('socialLink.index')->with('success', $result['message']);
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

    public function statusUpdate($id)
    {
        $result = $this->repo->statusUpdate($id);
        if ($result['status']) {
            return redirect()->route('socialLink.index')->with('success', $result['message']);
        }
        return back()->with('danger', $result['message']);
    }
}
