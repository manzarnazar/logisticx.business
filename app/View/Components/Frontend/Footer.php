<?php

namespace App\View\Components\Frontend;

use Closure;
use App\Enums\Status;
use Illuminate\View\Component;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Cache;
use Modules\Gallery\Entities\Gallery;
use Modules\Widgets\Entities\Widgets;
use Illuminate\Cache\RateLimiting\Limit;
use Modules\Gallery\Repositories\GalleryInterface;
use Modules\SocialLink\Repositories\SocialLinkInterface;

class Footer extends Component
{
    protected $socialLink, $galleryRepo;
    /**
     * Create a new component instance.
     */
    public function __construct(SocialLinkInterface $socialLink, GalleryInterface $gallery)
    {
        $this->socialLink = $socialLink;
        $this->galleryRepo = $gallery;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        $socialLinks = Cache::rememberForever('socialLinks', function () {
            return $this->socialLink->getActiveAll();
        });

        $galleries = Gallery::where('status', Status::ACTIVE)->limit(6)->get();
        
        if (!config('app.app_demo')) {
            $footer     = Cache::rememberForever('footer', fn() => Widgets::where('status', Status::ACTIVE)->whereIn('section', ['footer_style1', 'footer_style2'])->first());
        } else {

            $section = match (true) {
                str_contains(request()->url(), 'home2') => 'footer_style2',
                default => 'footer_style1',
            };

            $cacheKey   = str_replace('footer_style', 'footer', $section);

            $footer     = Cache::rememberForever($cacheKey, fn() => Widgets::where('status', Status::ACTIVE)->where('section', $section)->first());
        }

        return view('components.frontend.footer', compact('footer', 'socialLinks', 'galleries'));
    }
}
