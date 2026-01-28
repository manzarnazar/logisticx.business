<?php

namespace Modules\HR\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\HR\Http\Requests\HolidayStoreRequest;
use Modules\HR\Repositories\Holiday\HolidayInterface;

class HolidayController extends Controller
{
    protected $repo;

    public function __construct(HolidayInterface $repo)
    {
        $this->repo         = $repo;
    }

    public function index()
    {
        $holidays = $this->repo->all(paginate: settings('paginate_value'));

        return view('hr::holiday.index', compact('holidays'));
    }

    public function create()
    {
        return view('hr::holiday.create');
    }

    public function store(HolidayStoreRequest $request)
    {
        $result = $this->repo->store($request);
        if ($result['status']) {
            return redirect()->route('holiday.index')->with('success', $result['message']);
        }
        return back()->with('danger', $result['message'])->withInput();
    }

    public function edit($id)
    {
        $holiday       = $this->repo->get($id);
        return view('hr::holiday.edit', compact('holiday'));
    }

    public function update(HolidayStoreRequest $request)
    {
        $result = $this->repo->update($request);
        if ($result['status']) {
            return redirect()->route('holiday.index')->with('success', $result['message']);
        }
        return back()->with('danger', $result['message'])->withInput();
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
