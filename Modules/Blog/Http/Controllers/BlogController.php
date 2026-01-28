<?php

namespace Modules\Blog\Http\Controllers;


use Illuminate\Routing\Controller;
use Modules\Blog\Repositories\Blog\BlogInterface;
use Modules\Blog\Http\Requests\Blog\StoreRequest;
use Modules\Blog\Http\Requests\Blog\UpdateRequest;
use App\Repositories\User\UserInterface;

class BlogController extends Controller
{
    protected $repo, $userRepo, $categoryRepo;

    public function __construct(BlogInterface $repo, UserInterface $userRepo)
    {
        $this->repo         = $repo;
        $this->userRepo     = $userRepo;
    }
    public function index()
    {
        $blogs = $this->repo->all(paginate: settings('paginate_value'));
        return view('blog::blog.index', compact('blogs'));
    }

    public function create()
    {
        $users      = $this->userRepo->all();
        return view('blog::blog.create', compact('users'));
    }

    public function store(StoreRequest $request)
    {
        $result = $this->repo->store($request);
        if ($result['status']) {
            return redirect()->route('blog.index')->with('success', $result['message']);
        }
        return back()->with('danger', $result['message'])->withInput();
    }

    public function edit($id)
    {
        $blog       = $this->repo->getFind($id);
        $users      = $this->userRepo->getWithFilter();
        return view('blog::blog.edit', compact('blog', 'users'));
    }

    public function update(UpdateRequest $request, $id)
    {
        $result = $this->repo->update($request, $id);
        if ($result['status']) {
            return redirect()->route('blog.index')->with('success', $result['message']);
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
            return redirect()->route('blog.index')->with('success', $result['message']);
        }
        return back()->with('danger', $result['message']);
    }
}
