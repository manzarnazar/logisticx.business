<?php

namespace Modules\Language\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Language\Entities\Language;

class LanguageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $lang                 = new Language();
        $lang->name           = 'English';
        $lang->code           = 'en';
        $lang->icon_class     = 'flag-icon flag-icon-us';
        $lang->text_direction = 'LTR';
        $lang->save();

        $lang                 = new Language();
        $lang->name           = 'বাংলা';
        $lang->code           = 'bn';
        $lang->icon_class     = 'flag-icon flag-icon-bd';
        $lang->text_direction = 'LTR';
        $lang->save();

        $lang                 = new Language();
        $lang->name           = 'Hebrew';
        $lang->code           = 'il';
        $lang->icon_class     = 'flag-icon flag-icon-il';
        $lang->text_direction = 'RTL';
        $lang->save();

    }
}
