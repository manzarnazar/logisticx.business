<?php

namespace App\View\Composers;

use App\Enums\Status;
use Illuminate\View\View;
use Modules\Language\Entities\Language;
use Modules\Language\Repositories\Language\LanguageInterface;

class LangComposer
{
    protected $repoLang;

    public function __construct(LanguageInterface $repoLang)
    {
        $this->repoLang     = $repoLang;
    }

    /**
     * @param View $view
     */
    public function compose(View $view)
    {
        $view->with('languages', $this->repoLang->all(status: Status::ACTIVE, orderBy: 'code', sortBy: 'asc'));
    }
}
