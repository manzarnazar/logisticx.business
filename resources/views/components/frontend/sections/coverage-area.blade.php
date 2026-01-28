@if($widget != null)
    @if($widget->section == \Config::get('site.widgets.coverage_area_style1'))
        @include('frontend.sections.coverage-area.style1')
    @elseif($widget->section == \Config::get('site.widgets.coverage_area_style2'))
        @include('frontend.sections.coverage-area.style2')

    @endif
@endif
