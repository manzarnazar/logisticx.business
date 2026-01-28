<?php

namespace App\View\Components\Frontend\Sections;

use Closure;
use App\Enums\Status;
use Illuminate\View\Component;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Cache;
use Modules\Gallery\Repositories\GalleryInterface;

class Gallery extends Component
{
    /**
     * Create a new component instance.
     */
    public $widget;

    private $repo;

    public function __construct($widget, GalleryInterface $repo)
    {
        $this->widget    = $widget;

        $this->repo  = $repo;
    }


    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        $galleries = Cache::rememberForever("galleries", fn() => $this->repo->all(status: Status::ACTIVE, orderBy: 'position'));

        return view('components.frontend.sections.gallery', compact('galleries'));
    }
}
