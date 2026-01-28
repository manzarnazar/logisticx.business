<?php

namespace App\Http\Controllers\Backend\Charges;

use App\Http\Controllers\Controller;
use App\Http\Requests\Charges\ValueAddedService\VASStoreRequest;
use App\Http\Requests\Charges\ValueAddedService\VASUpdateRequest;
use App\Repositories\ValueAddedService\VASInterface;

class VASController extends Controller
{
    private $repo;
    public function __construct(VASInterface $repo)
    {
        $this->repo = $repo;
    }

    public function index()
    {
        $all_vas = $this->repo->all(paginate: settings('paginate_value'));
        return view('backend.vas.index', compact('all_vas'));
    }

    public function create()
    {
        return view('backend.vas.create');
    }

    public function store(VASStoreRequest $request)
    {
        $result = $this->repo->store($request);
        if ($result['status']) {
            return redirect()->route('vas')->with('success', $result['message']);
        }
        return back()->with('danger', $result['message'])->withInput();
    }

    public function edit($id)
    {
        $vas = $this->repo->get($id);
        return view('backend.vas.update', compact('vas'));
    }

    public function update(VASUpdateRequest $request)
    {
        $result = $this->repo->update($request);
        if ($result['status']) {
            return redirect()->route('vas')->with('success', $result['message']);
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
