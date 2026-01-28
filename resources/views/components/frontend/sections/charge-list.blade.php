@if($widget != null)

@if($widget->section == \Config::get('site.widgets.charge_list_style1'))
@include('frontend.sections.charge-list.style1')
@endif

@endif
