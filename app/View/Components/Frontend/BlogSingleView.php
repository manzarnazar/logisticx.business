<?php

namespace App\View\Components\Frontend;

use Closure;
use App\Enums\Status;
use Illuminate\View\Component;
use Modules\Blog\Entities\Blog;
use Illuminate\Contracts\View\View;

class BlogSingleView extends Component
{
    public $blog;

    public function __construct($blog)
    {
        $this->blog = $blog;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.frontend.blog-single-view');
    }
}
