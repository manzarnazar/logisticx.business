@if ($widget != null)
    @if ($widget->section == \Config::get('site.widgets.cta_style1'))
        @include('frontend.sections.cta.style1')
        @elseif ($widget->section == \Config::get('site.widgets.cta_style2'))
        @include('frontend.sections.cta.style2')
    @endif
@endif
