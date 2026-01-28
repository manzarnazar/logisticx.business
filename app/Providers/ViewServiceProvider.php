<?php

namespace App\Providers;

use App\View\Composers\LangComposer;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        View::composer(['*.partials.navbar', 'frontend.sections.header.*'], LangComposer::class);
    }
}
