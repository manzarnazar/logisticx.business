@if($widget != null)

@if($widget->section == \Config::get('site.widgets.about_us_style1'))
@include('frontend.sections.about-us.style1')
@elseif($widget->section == \Config::get('site.widgets.about_us_style2'))
@include('frontend.sections.about-us.style2')
@endif

@endif
