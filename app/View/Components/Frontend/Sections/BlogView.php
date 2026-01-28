<?php

namespace App\View\Components\frontend\sections;

use Closure;
use App\Enums\Status;
use Illuminate\View\Component;
use Modules\Blog\Entities\Blog;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Cache;
use Modules\Blog\Repositories\Blog\BlogInterface;

class BlogView extends Component
{
    /**
     * Create a new component instance.
     */
    public $widget;

    private $repo;

    public function __construct($widget, BlogInterface $repo)
    {
        $this->widget    = $widget;

        $this->repo  = $repo;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        $paginate = ceil(settings('paginate_value') / 4) * 4;

        $blogs = Cache::rememberForever("blogs", fn () => $this->repo->all(status: Status::ACTIVE, paginate: $paginate, orderBy: 'position'));

        return view('components.frontend.sections.blog-view', compact('blogs'));
    }
}
