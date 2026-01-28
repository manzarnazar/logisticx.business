<?php

namespace Modules\Widgets\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Contracts\Support\Renderable;
use Modules\Widgets\Http\Requests\StoreRequest;
use Modules\Widgets\Http\Requests\UpdateRequest;
use Modules\Widgets\Repositories\WidgetsInterface;


class WidgetsController extends Controller
{

    protected $repo;

    public function __construct(WidgetsInterface $repo)
    {
        $this->repo         = $repo;
    }

    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $widgets = $this->repo->all();
        return view('widgets::widgets.index', compact('widgets'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('widgets::widgets.create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */

    // public function widgetInputShow(Request $request)
    // {
    //     return view('widgets::widget_info.' . $page);
    // }

    public function store(StoreRequest $request)
    {
        $result = $this->repo->store($request);
        if ($result['status']) {
            return redirect()->route('widgets.index')->with('success', $result['message']);
        }
        return back()->with('danger', $result['message']);
    }

    public function widgetView($id)
    {
        $widget  = $this->repo->getFind($id);
        return view('widgets::view', compact('widget'));
    }


    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit(Request $request, $id)
    {
        $widget  = $this->repo->getFind($id);
        return view('widgets::widgets.edit', compact('widget'));
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
            return redirect()->route('widgets.index')->with('success', $result['message']);
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
