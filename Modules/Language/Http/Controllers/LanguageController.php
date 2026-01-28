<?php

namespace Modules\Language\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Modules\Language\Http\Requests\Language\StoreRequest;
use Modules\Language\Http\Requests\Language\UpdateRequest;
use Modules\Language\Repositories\Language\LanguageInterface;
// use Illuminate\Http\Response;

class LanguageController extends Controller
{
    protected $repo;

    public function __construct(LanguageInterface $repo)
    {
        $this->repo = $repo;
    }

    public function index()
    {
        $languages      = $this->repo->all(paginate: settings('paginate_value'));
        return view('language::language.index', compact('languages'));
    }

    //language create page
    public function create()
    {
        $flags        = $this->repo->flags();
        return view('language::language.create', compact('flags'));
    }

    //language store
    public function store(StoreRequest $request)
    {
        // dd($request);
        // if (env('DEMO')) {
        //     return redirect()->back()->withInput()->with('danger', ___('store_system_error'));
        // }
        $result = $this->repo->store($request);

        if ($result['status']) {
            return redirect()->route('language.index')->with('success', $result['message']);
        }
        return redirect()->back()->withInput()->with('danger', $result['message']);
    }


    public function edit($id)
    {
        $lang       = $this->repo->get($id);
        $flags       = $this->repo->flags();
        return view('language::language.edit', compact('lang', 'flags'));
    }

    //language update
    public function update(UpdateRequest $request)
    {
        $result = $this->repo->update($request);

        if ($result['status']) {
            return redirect()->route('language.index')->with('success', $result['message']);
        }
        return redirect()->back()->withInput()->with('danger', $result['message']);
    }

    //edit phrase
    public function editPhrase($id)
    {
        $result = $this->repo->editPhrase($id);

        if ($result['status']) {
            $langData    = $result['data']['terms'];

            $lang        = $this->repo->get($id);
            return view('language::language.edit_phrase', compact('langData', 'lang'));
        }
        return redirect()->back()->withInput()->with('danger', $result['message']);
    }


    public function changeModule(Request $request)
    {
        $path = base_path("lang/{$request->code}/{$request->module}.json");
        $jsonString = file_get_contents($path);
        $terms = json_decode($jsonString, true);

        return response()->json(['terms' => $terms]);
    }

    //update phrase
    public function updatePhrase(Request $request, $code)
    {
        $result = $this->repo->updatePhrase($request, $code);

        if ($result['status']) {
            return redirect()->route('language.index')->with('success', $result['message']);
        }
        return redirect()->back()->withInput()->with('danger', $result['message']);
    }

    //delete language
    public function delete($id)
    {
        $result = $this->repo->delete($id);

        if ($result['status']) :
            $success[0] = $result['message'];
            $success[1] = 'success';
            $success[2] = ___('delete.deleted');
            return response()->json($success);
        else :
            $success[0] = $result['message'];
            $success[1] = 'error';
            $success[2] = ___('delete.oops');
            return response()->json($success);
        endif;
    }
}
