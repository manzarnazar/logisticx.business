<?php

namespace App\Http\Controllers\Backend\Charges;

use App\Models\HomePageSlider;
use App\Http\Controllers\Controller;
use App\Http\Requests\Charges\HomePageSlider\HomePageSliderStoreRequest;
use App\Http\Requests\Charges\HomePageSlider\HomePageSliderUpdateRequest;
use App\Repositories\HomePageSlider\HomePageSliderInterface;
use Illuminate\Http\Request;

class HomePageSliderController extends Controller
{
    protected $repo;

     public function __construct(HomePageSliderInterface $repo)
    {
        $this->repo = $repo;
    }

    public function index()
    {
        $HomePageSlider = $this->repo->all(paginate: settings('paginate_value'));

        return view('backend.home_page_slider.index', compact('HomePageSlider'));
    }

    public function create()
    {
      return view('backend.home_page_slider.create');
    }

    public function store(HomePageSliderStoreRequest $request)
    {
        $result = $this->repo->store($request);
        if ($result['status']) {
            return redirect()->route('HomePageSider.index')->with('success', $result['message']);
        }
        return back()->with('danger', $result['message']);
    }

    public function edit($id)
    {

        $HomePageSlider = HomePageSlider::find($id);
        return view('backend.home_page_slider.edit', compact('HomePageSlider'));

    }

    public function update(HomePageSliderUpdateRequest $request)
    {

        $result = $this->repo->update($request);

        if ($result['status']) {
            return redirect()->route('HomePageSider.index')->with('success', $result['message']);
        }
        return back()->with('danger', $result['message']);
    }

    public function delete($id)
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
