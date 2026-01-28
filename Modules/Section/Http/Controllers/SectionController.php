<?php

namespace Modules\Section\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Section\Enums\Type;
use Modules\Section\Repositories\SectionInterface;
use Modules\Section\Traits\SectionTrait;

class SectionController extends Controller
{
    use SectionTrait;
    protected $repo;
    public function __construct(SectionInterface $repo)
    {
        $this->repo = $repo;
    }
    /**
     * Display a listing of the resource.
     * @return Renderable
     */

    public function index()
    {
        $sections = $this->repo->get();
        return view('section::index', compact('sections'));
    }


    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($type)
    {
        $section     = $this->repo->getFind($type);
        $sectionType = $this->SectionType($type);
        return view('section::edit', compact('section', 'sectionType', 'type'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request)
    {
        // HERE WAS DEMO CODE, REMOVED

        $result = $this->repo->update($request);
        if ($result['status']) {
            return redirect()->route('section.index')->with('success', $result['message']);
        }
        return back()->with('danger', $result['message']);
    }

    public function themeAppearance()
    {
        $type        = Type::THEME_APPEARANCE;
        $section     = $this->repo->themeAppearance();
        $sectionType = $this->SectionType($type);
        return view('section::edit', compact('section', 'sectionType', 'type'));
    }
}
