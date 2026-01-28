<?php

namespace Modules\Gallery\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Modules\Gallery\Http\Requests\Gallery\StoreRequest;
use Modules\Gallery\Http\Requests\Gallery\UpdateRequest;
use Modules\Gallery\Repositories\GalleryInterface;

class GalleryController extends Controller
{
    protected $repo;

    public function __construct(GalleryInterface $repo)
    {
        $this->repo = $repo;
    }

    public function index()
    {
        $galleries = $this->repo->all(paginate: settings('paginate_value'));
        return view('gallery::gallery.index', compact('galleries'));
    }



    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('gallery::gallery.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request): RedirectResponse
    {
        $result = $this->repo->store($request);
        if ($result['status']) {
            return redirect()->route('gallery.index')->with('success', $result['message']);
        }
        return back()->with('danger', $result['message'])->withInput();
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $gallery       = $this->repo->getFind($id);
        return view('gallery::gallery.edit', compact('gallery'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, $id): RedirectResponse
    {
        $result = $this->repo->update($request, $id);
        if ($result['status']) {
            return redirect()->route('gallery.index')->with('success', $result['message']);
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
