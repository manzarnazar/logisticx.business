@if($widget !== null)

    @if($widget->section == config('site.widgets.how_it_work_style1'))
        @include('frontend.sections.how-it-work.style1')
    @elseif($widget->section == config('site.widgets.how_it_work_style2'))
        @include('frontend.sections.how-it-work.style2')
    @endif

@endif

