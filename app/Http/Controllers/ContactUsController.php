<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ContactUs\StoreRequest;
use App\Repositories\ContactUs\ContactUsInterface;

class ContactUsController extends Controller
{
    private $repo;

    public function __construct(ContactUsInterface $repo)
    {
        $this->repo = $repo;
    }

    public function index()
    {
        $feedbacks = $this->repo->all(paginate: settings('paginate_value'));
        return view('backend.contact.index', compact('feedbacks'));
    }

    public function storeMessage(StoreRequest $request)
    {
        // dd($request->all());
        $result =  $this->repo->storeMessage($request);

        if (request()->wantsJson()) return response()->json($result);

        if ($result['status']) {
            return redirect()->back()->with('success', $result['message']);
        }
        return redirect()->back()->with('danger', $result['message'])->withInput();
    }
}
