<?php

namespace App\Http\Controllers\Backend\Charges;

use App\Http\Controllers\Controller;
use App\Http\Requests\Charges\ServiceFaq\ServiceFaqStoreRequest;
use App\Http\Requests\Charges\ServiceFaq\ServiceFaqUpdateRequest;
use App\Models\ServiceFaq;
use App\Models\Backend\Charges\ServiceType;
use App\Repositories\ServiceFaq\ServiceFaqInterface;

class ServiceFaqController extends Controller
{
    private $repo;

    public function __construct(ServiceFaqInterface $repo)
    {
        $this->repo = $repo;
    }

    public function index()
    {
        $serviceFaqs = $this->repo->all(paginate: settings('paginate_value'));
        return view('backend.service_faq.index', compact('serviceFaqs'));
    }

    public function create()

    {
        
          $service_type = ServiceType::get();
         return view('backend.service_faq.create', compact('service_type'));
      
    }

    public function store(ServicefaqStoreRequest $request)
    {
        $result = $this->repo->store($request);
        if ($result['status']) {
            return redirect()->route('serviceFaq.index')->with('success', $result['message']);
        }
        return back()->with('danger', $result['message']);
    }

    public function edit($id)
    {
        $serviceFaqs = ServiceFaq::find($id);
        $service_type = ServiceType::get();
        return view('backend.service_faq.update', compact('serviceFaqs','service_type'));
    }

    public function update(ServiceFaqUpdateRequest $request)
    {

        $result = $this->repo->update($request);

        if ($result['status']) {
            return redirect()->route('serviceFaq.index')->with('success', $result['message']);
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
