<?php

namespace App\Http\Controllers\Backend\BranchManage;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Hub\StoreHubRequest;
use App\Http\Requests\Hub\UpdateHubRequest;
use App\Repositories\Coverage\CoverageInterface;
use App\Repositories\Hub\HubInterface;
use App\Repositories\Reports\ReportsInterface;

class HubController extends Controller
{
    protected $repo, $coverageRepo, $reportRepo;

    public function __construct(HubInterface $repo, CoverageInterface $coverageRepo, ReportsInterface $reportRepo)
    {
        $this->repo         = $repo;
        $this->coverageRepo = $coverageRepo;
        $this->reportRepo   = $reportRepo;
    }

    public function index(Request $request)
    {
        $hubs = $this->repo->all(paginate: settings('paginate_value'));
        return view('backend.hub.index', compact('hubs'));
    }

    public function filter(Request $request)
    {
        $hubs = $this->repo->filter($request, paginate: settings('paginate_value'));
        return view('backend.hub.index', compact('hubs'));
    }

    public function create()
    {
        $coverages  = $this->coverageRepo->getWithActiveChild();
        return view('backend.hub.create', compact('coverages'));
    }

    public function store(StoreHubRequest $request)
    {
        $result = $this->repo->store($request);

        if ($result['status']) {
            return redirect()->route('hubs.index')->with('success', $result['message']);
        }
        return back()->with('danger', $result['message'])->withInput();
    }

    public function edit($id)
    {
        $hub       = $this->repo->get($id);
        $coverages = $this->coverageRepo->getWithActiveChild();
        return view('backend.hub.edit', compact('hub', 'coverages'));
    }

    public function update(UpdateHubRequest $request)
    {
        $result = $this->repo->update($request->id, $request);

        if ($result['status']) {
            return redirect()->route('hubs.index')->with('success', $result['message']);
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

    public function view(Request $request, $hub_id)
    {
        $request->merge(['hub_id' => $hub_id]);

        $report = $this->reportRepo->hubReport($request);

        return view('backend.hub.dashboard', compact('report'));
    }
}
