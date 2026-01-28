<?php

namespace Modules\Widgets\Database\Seeders;

use App\Enums\Widget;
use App\Enums\SectionPadding;
use Illuminate\Database\Seeder;
use Modules\Widgets\Entities\Widgets;

class WidgetsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $widgets = [
            Widget::HEADER_STYLE1,
            Widget::HERO_SECTION_STYLE1,
            Widget::ABOUT_US_STYLE1,
            Widget::SERVICES_STYLE1,
            Widget::HOW_IT_WORK_STYLE1,
            Widget::GALLERY_STYLE1,
            Widget::DELIVERY_CALCULATOR_STYLE1,
            Widget::COVERAGE_AREA_STYLE1,
            Widget::FAQ_STYLE1,
            Widget::CLIENTS_STYLE1,
            Widget::CLIENT_REVIEW_STYLE1,
            Widget::BLOGS_STYLE1,
            Widget::CTA_STYLE1,
            Widget::FOOTER_STYLE1,
        ];

        $widgetsTwo = [
            Widget::HEADER_STYLE2,
            Widget::HERO_SECTION_STYLE2,
            Widget::ABOUT_US_STYLE2,
            Widget::OUR_ACHIEVEMENT_STYLE2,
            Widget::SERVICES_STYLE2,
            Widget::DELIVERY_CALCULATOR_STYLE2,
            Widget::COVERAGE_AREA_STYLE2,
            Widget::CHARGE_LIST_STYLE1,
            Widget::FAQ_STYLE2,
            Widget::CLIENT_REVIEW_STYLE2,
            Widget::BLOGS_STYLE1,
            Widget::CLIENTS_STYLE2,
            Widget::FOOTER_STYLE2,
        ];

        foreach ($widgets as $index => $widgetValue) {
            if (config('app.app_demo')) :
            Widgets::create([
                'title'                    => ucwords(str_replace('_', ' ', $widgetValue)),
                'section'                  => $widgetValue,
                'position'                 => $index + 1,
                'status'                   => 1,
                'demo_style'               => 1,
                'section_padding'          =>  $this->getPaddings($widgetValue),
            ]);
            else:
                Widgets::create([
                'title'                    => ucwords(str_replace('_', ' ', $widgetValue)),
                'section'                  => $widgetValue,
                'position'                 => $index + 1,
                'status'                   => 1,
                'section_padding'          =>  $this->getPaddings($widgetValue),
            ]);
            endif;

            
        }

        if (config('app.app_demo')) {
            if ($widgetValue == Widget::HERO_SECTION_STYLE2 || $widgetValue == Widget::CLIENTS_STYLE2) {
                $sectionPadding = SectionPadding::NONE->value;
            } else {
                $sectionPadding = SectionPadding::PADDING_80->value;
            }

            foreach ($widgetsTwo as $index => $widgetValue) {
                if (config('app.app_demo')) :
                Widgets::create([
                    'title'                => ucwords(str_replace('_', ' ', $widgetValue)),
                    'section'              => $widgetValue,
                    'position'             => $index + 13,
                    'status'               => 1,
                    'demo_style'           => 2,
                    'section_padding'      =>  $this->getPaddings($widgetValue),
                ]);
                else:
                    Widgets::create([
                    'title'                => ucwords(str_replace('_', ' ', $widgetValue)),
                    'section'              => $widgetValue,
                    'position'             => $index + 13,
                    'status'               => 1,
                    'section_padding'      =>  $this->getPaddings($widgetValue),
                ]);

                    endif;
            }
        }
    }

    private function getPaddings($widget):array
    {

          $paddings = [

            // style 1
            Widget::HEADER_STYLE1                   => [ SectionPadding::PADDING_TOP_50->value,  SectionPadding::PADDING_BOTTOM_80->value, ],
            Widget::HERO_SECTION_STYLE1             => [ SectionPadding::PADDING_TOP_80->value,  SectionPadding::PADDING_BOTTOM_80->value, ],
            Widget::ABOUT_US_STYLE1                 => [ SectionPadding::PADDING_TOP_80->value,  SectionPadding::PADDING_BOTTOM_100->value, ],
            Widget::SERVICES_STYLE1                 => [ SectionPadding::PADDING_TOP_80->value,  SectionPadding::PADDING_BOTTOM_80->value, ],
            Widget::HOW_IT_WORK_STYLE1              => [ SectionPadding::PADDING_TOP_80->value,  SectionPadding::PADDING_BOTTOM_80->value, ],
            Widget::GALLERY_STYLE1                  => [ SectionPadding::PADDING_TOP_80->value,  SectionPadding::PADDING_BOTTOM_80->value, ],
            Widget::DELIVERY_CALCULATOR_STYLE1      => [ SectionPadding::PADDING_TOP_100->value,  SectionPadding::PADDING_BOTTOM_100->value, ],
            Widget::COVERAGE_AREA_STYLE1            => [ SectionPadding::PADDING_TOP_80->value,  SectionPadding::PADDING_BOTTOM_80->value, ],
            Widget::FAQ_STYLE1                      => [ SectionPadding::PADDING_TOP_NONE->value,  SectionPadding::PADDING_BOTTOM_80->value, ],
            Widget::CLIENTS_STYLE1                  => [ SectionPadding::PADDING_TOP_NONE->value,  SectionPadding::PADDING_BOTTOM_80->value, ],
            Widget::CLIENT_REVIEW_STYLE1            => [ SectionPadding::PADDING_TOP_80->value,  SectionPadding::PADDING_BOTTOM_80->value, ],
            Widget::BLOGS_STYLE1                    => [ SectionPadding::PADDING_TOP_NONE->value,  SectionPadding::PADDING_BOTTOM_80->value, ],
            Widget::CTA_STYLE1                      => [ SectionPadding::PADDING_TOP_NONE->value,  SectionPadding::PADDING_BOTTOM_80->value, ],
            Widget::FOOTER_STYLE1                   => [ SectionPadding::PADDING_TOP_80->value,  SectionPadding::PADDING_BOTTOM_80->value, ],

            // style 2
            Widget::HEADER_STYLE2                   => [ SectionPadding::PADDING_TOP_50->value,  SectionPadding::PADDING_BOTTOM_50->value, ],
            Widget::HERO_SECTION_STYLE2             => [ SectionPadding::PADDING_TOP_150->value,  SectionPadding::PADDING_BOTTOM_150->value, ],
            Widget::ABOUT_US_STYLE2                 => [ SectionPadding::PADDING_TOP_80->value,  SectionPadding::PADDING_BOTTOM_100->value, ],
            Widget::OUR_ACHIEVEMENT_STYLE2          => [ SectionPadding::PADDING_TOP_80->value,  SectionPadding::PADDING_BOTTOM_80->value, ],
            Widget::SERVICES_STYLE2                 => [ SectionPadding::PADDING_TOP_80->value,  SectionPadding::PADDING_BOTTOM_80->value, ],
            Widget::DELIVERY_CALCULATOR_STYLE2      => [ SectionPadding::PADDING_TOP_80->value,  SectionPadding::PADDING_BOTTOM_80->value, ],
            Widget::COVERAGE_AREA_STYLE2            => [ SectionPadding::PADDING_TOP_80->value,  SectionPadding::PADDING_BOTTOM_NONE->value, ],
            Widget::CHARGE_LIST_STYLE1              => [ SectionPadding::PADDING_TOP_80->value,  SectionPadding::PADDING_BOTTOM_80->value, ],
            Widget::FAQ_STYLE2                      => [ SectionPadding::PADDING_TOP_80->value,  SectionPadding::PADDING_BOTTOM_NONE->value, ],
            Widget::CLIENT_REVIEW_STYLE2            => [ SectionPadding::PADDING_TOP_80->value,  SectionPadding::PADDING_BOTTOM_80->value, ],
            Widget::BLOGS_STYLE1                    => [ SectionPadding::PADDING_TOP_80->value,  SectionPadding::PADDING_BOTTOM_80->value, ],
            Widget::CLIENTS_STYLE2                  => [ SectionPadding::PADDING_TOP_NONE->value,  SectionPadding::PADDING_BOTTOM_80->value, ],
            Widget::FOOTER_STYLE2                   => [ SectionPadding::PADDING_TOP_80->value,  SectionPadding::PADDING_BOTTOM_80->value, ],
        ];

        return $paddings[$widget];

    }
}
