<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\AppSlider\StoreRequest;
use App\Http\Requests\AppSlider\UpdateRequest;
use App\Repositories\AppSlider\AppSliderInterface;

class AppSliderController extends Controller
{
    private $repo;
    public function __construct(AppSliderInterface $repo)
    {
        $this->repo          = $repo;
    }

    public function index()
    {
        $app_sliders = $this->repo->all(paginate: settings('paginate_value'));
        return view('backend.app_slider.index', compact('app_sliders'));
    }

    public function create()
    {
        return view('backend.app_slider.create');
    }

    public function store(StoreRequest $request)
    {
        $result = $this->repo->store($request);
        if ($result['status']) {
            return redirect()->route('app_slider.index')->with('success', $result['message']);
        }
        return back()->with('danger', $result['message'])->withInput();
    }

    public function edit($id)
    {
        $app_slider     = $this->repo->get($id);
        return view('backend.app_slider.edit', compact('app_slider'));
    }

    public function update(UpdateRequest $request)
    {
        $result = $this->repo->update($request);
        if ($result['status']) {
            return redirect()->route('app_slider.index')->with('success', $result['message']);
        }
        return back()->with('danger', $result['message'])->withInput();
    }

    public function delete($id)
    {
        $result = $this->repo->delete($id);

        if ($result['status']) :
            $success[0] = $result['message'];
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
