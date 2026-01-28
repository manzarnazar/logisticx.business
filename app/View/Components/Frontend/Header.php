<?php

namespace App\View\Components\Frontend;

use Closure;
use App\Enums\Status;
use Illuminate\View\Component;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Cache;
use Modules\Widgets\Entities\Widgets;
use Modules\SocialLink\Repositories\SocialLinkInterface;

class Header extends Component
{

    protected $socialLink;
    /** 
     * Create a new component instance.
     */
    public function __construct(SocialLinkInterface $socialLink)
    {
        $this->socialLink = $socialLink;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {

        $socialLinks = Cache::rememberForever('socialLinks', function () {
            return $this->socialLink->getActiveAll();
        });


        if (!config('app.app_demo')) {
            $header = Cache::rememberForever('header', fn() => Widgets::where('status', Status::ACTIVE)->whereIn('section', ['header_style1', 'header_style2'])->first());
        } else {

            $section = match (true) {
                str_contains(request()->url(), 'home2') => 'header_style2',
                default => 'header_style1',
            };

            $cacheKey = str_replace('header_style', 'header', $section);

            $header = Cache::rememberForever($cacheKey, fn() => Widgets::where('status', Status::ACTIVE)->where('section', $section)->first());
        }



        return view('components.frontend.header', compact('header', 'socialLinks'));
    }
}
