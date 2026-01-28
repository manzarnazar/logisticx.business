<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\ToDo\ToDoStoreRequest;
use Illuminate\Http\Request;
use App\Repositories\Todo\TodoInterface;

class TodoController extends Controller
{

    protected $repo;

    public function __construct(TodoInterface $repo)
    {
        $this->repo = $repo;
    }
    public function index()
    {
        $todos = $this->repo->all(paginate: settings('paginate_value'));
        return view('backend.todo.index', compact('todos'));
    }

    public function store(ToDoStoreRequest $request)
    {
        $result = $this->repo->store($request);

        if ($request->wantsJson()) {
            return response()->json($result, $result['data']['status_code']);
        }

        if ($result['status']) {
            return redirect()->route('todo.index')->with('success', $result['message']);
        }
        return back()->with('danger', $result['message']);
    }

    public function todoProcessing(Request $request)
    {
        $result = $this->repo->todoProcessing($request->todo_id, $request);

        if ($request->wantsJson()) {
            return response()->json($result, $result['data']['status_code']);
        }

        if ($result['status']) {
            return redirect()->route('todo.index')->with('success', $result['message']);
        }
        return back()->with('danger', $result['message']);
    }

    public function todoComplete(Request $request)
    {
        $result = $this->repo->todoComplete($request->todo_id, $request);

        if ($request->wantsJson()) {
            return response()->json($result, $result['data']['status_code']);
        }

        if ($result['status']) {
            return redirect()->route('todo.index')->with('success', $result['message']);
        }
        return back()->with('danger', $result['message']);
    }

    public function update(Request $request)
    {
        $result = $this->repo->update($request);

        if ($request->wantsJson()) {
            return response()->json($result, $result['data']['status_code']);
        }

        if ($result['status']) {
            return redirect()->route('todo.index')->with('success', $result['message']);
        }
        return back()->with('danger', $result['message']);
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
}
