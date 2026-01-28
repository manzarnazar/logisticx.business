<?php

namespace Modules\Pages\Http\Controllers;

use App\Repositories\User\UserInterface;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Pages\Http\Requests\StoreRequest;
use Modules\Pages\Http\Requests\UpdateRequest;
use Modules\Pages\Repositories\PagesInterface;

class PagesController extends Controller
{
    protected $repo, $userRepo;

    public function __construct(PagesInterface $repo, UserInterface $userRepo)
    {
        $this->repo = $repo;
        $this->userRepo = $userRepo;
    }
    public function index()
    {
        $pages = $this->repo->all();

        return view('pages::pages.index', compact('pages'));
    }

    public function edit($id)
    {
        $page          = $this->repo->get($id);

        return view('pages::pages.edit', compact('page'));
    }

    public function update(UpdateRequest $request, $id)
    {
        $result = $this->repo->update($request, $id);
        if ($result['status']) {
            return redirect()->route('page.index')->with('success', $result['message']);
        }
        return back()->with('danger', $result['message']);
    }
}
