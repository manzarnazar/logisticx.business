<?php

namespace Modules\HR\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\HR\Repositories\Weekend\WeekendInterface;

class WeekendController extends Controller
{
    protected $repo;

    public function __construct(WeekendInterface $repo)
    {
        $this->repo         = $repo;
    }

    public function index()
    {
        $week = $this->repo->all(sortBy: 'asc');
        return view('hr::weekend.index', compact('week'));
    }

    public function edit($id)
    {
        $day       = $this->repo->get($id);
        return view('hr::weekend.edit', compact('day'));
    }

    public function update(Request $request)
    {
        $request->validate(
            [
                'name'          => 'required|unique:weekends,name,' . $request->id,
                'is_weekend'    => 'required|boolean',
                'status'        => 'required|boolean',
            ]
        );

        $result = $this->repo->update($request);
        if ($result['status']) {
            return redirect()->route('weekend.index')->with('success', $result['message']);
        }
        return back()->with('danger', $result['message'])->withInput();
    }
}
