<?php

namespace Modules\DeliveryArea\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Modules\DeliveryArea\Repositories\DeliveryAreaInterface;
use Modules\DeliveryArea\Http\Requests\DeliveryArea\StoreRequest;
use Modules\DeliveryArea\Http\Requests\DeliveryArea\UpdateRequest;

class DeliveryAreaController extends Controller
{
    protected $repo;

    public function __construct(DeliveryAreaInterface $repo)
    {
        $this->repo = $repo;
    }

    public function index()
    {
        $delivery_areas = $this->repo->all(paginate: settings('paginate_value'));
        return view('deliveryarea::delivery-area.index', compact('delivery_areas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('deliveryarea::delivery-area.create');
    }


    public function store(StoreRequest $request): RedirectResponse
    {
        $result = $this->repo->store($request);
        if ($result['status']) {
            return redirect()->route('delivery_area.index')->with('success', $result['message']);
        }
        return back()->with('danger', $result['message'])->withInput();
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $delivery_area       = $this->repo->getFind($id);
        return view('deliveryarea::delivery-area.edit', compact('delivery_area'));
    }

    public function update(UpdateRequest $request, $id): RedirectResponse
    {
        $result = $this->repo->update($request, $id);
        if ($result['status']) {
            return redirect()->route('delivery_area.index')->with('success', $result['message']);
        }
        return back()->with('danger', $result['message'])->withInput();
    }

    /**
     * Remove the specified resource from storage.
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
