<?php

namespace Modules\Team\Http\Controllers;

use App\Repositories\User\UserInterface;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Team\Http\Requests\StoreRequest;
use Modules\Team\Http\Requests\UpdateRequest;
use Modules\Team\Repositories\TeamInterface;

class TeamController extends Controller
{
    protected $repo, $userRepo;

    public function __construct(TeamInterface $repo, UserInterface $userRepo)
    {
        $this->repo = $repo;
        $this->userRepo = $userRepo;
    }
    public function index()
    {
        $teams = $this->repo->all();
        return view('team::team.index', compact('teams'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create()
    {
        $users      = $this->userRepo->all();
        return view('team::team.create', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit($id)
    {
        $team          = $this->repo->get($id);
        $users         = $this->userRepo->all();
        return view('team::team.edit', compact('team', 'users'));
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreRequest $request)
    {

        $result = $this->repo->store($request);

        if ($result['status']) {
            return redirect()->route('team.index')->with('success', $result['message']);
        }
        return back()->with('danger', $result['message']);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */

    public function update(UpdateRequest $request, $id)
    {
        $result = $this->repo->update($request, $id);
        if ($result['status']) {
            return redirect()->route('team.index')->with('success', $result['message']);
        }
        return back()->with('danger', $result['message']);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
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
            toast(__('team_status_update'), 'success');
            return redirect()->route('team.index');
        } else {
            toast(__('error'), 'error');
            return redirect()->back();
        }
    }
}
