<?php

namespace Modules\Testimonial\Http\Controllers;

use Modules\Testimonial\Http\Requests\StoreRequest;
use Modules\Testimonial\Http\Requests\UpdateRequest;
use Illuminate\Routing\Controller;
use Module\Testimonial\Entities\Testimonial;
use Modules\Testimonial\Repositories\TestimonialInterface;

class TestimonialController extends Controller
{
    protected $repo;
    public function __construct(TestimonialInterface $repo)
    {
        $this->repo = $repo;
    }

    public function index()
    {
        $testimonials = $this->repo->all();
        return view('testimonial::testimonial.index', compact('testimonials'));
    }

    public function create()
    {
        return view('testimonial::testimonial.create');
    }

    public function store(StoreRequest $request)
    {
        $result = $this->repo->store($request);
        if ($result['status']) {
            return redirect()->route('testimonial.index')->with('success', $result['message']);
        }
        return back()->with('danger', $result['message'])->withInput();
    }

    public function show($id)
    {
        return view('testimonial::show');
    }

    public function edit($id)
    {
        $testimonial = $this->repo->getFind($id);
        return view('testimonial::testimonial.edit', compact('testimonial'));
    }

    public function update(UpdateRequest $request, $id)
    {
        $result = $this->repo->update($request, $id);
        if ($result['status']) {
            return redirect()->route('testimonial.index')->with('success', $result['message']);
        }
        return back()->with('danger', $result['message'])->withInput();
    }

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
        $result = $this->repo->statusUpdate($id);
        if ($result['status']) {
            return redirect()->route('testimonial.index')->with('success', $result['message']);
        }
        return back()->with('danger', $result['message']);
    }
}
