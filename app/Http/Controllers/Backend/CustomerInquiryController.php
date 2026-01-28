<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\CustomerInquiry\StoreRequest;
use App\Repositories\CustomerInquiry\CustomerInquiryInterface;

class CustomerInquiryController extends Controller
{
    protected $repo;

    public function __construct(CustomerInquiryInterface $repo)
    {
        $this->repo = $repo;
    }


    public function index()
    {
        $inquires = $this->repo->all();
        return view('backend.inquiry.index', compact('inquires'));
    }

    public function store(StoreRequest $request)
    {
        if (!auth()->check()) {
            return view('frontend.pages.signin');
        }

        $result = $this->repo->store($request);
        if ($result['status']) {
            return redirect()->back()->with('success', $result['message']);
        }
        return back()->with('danger', $result['message']);
    }

    public function view($id)
    {
        $inquiry = $this->repo->find($id);
        return view('backend.inquiry.view', compact('inquiry'));
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
