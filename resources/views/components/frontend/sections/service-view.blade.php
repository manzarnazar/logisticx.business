@if($widget->section != null)

@if($widget->section == \Config::get('site.widgets.services_style1'))
@include('frontend.sections.service-new.style1')

@elseif($widget->section == \Config::get('site.widgets.services_style2'))
@include('frontend.sections.service-new.style2')
@endif

@endif
