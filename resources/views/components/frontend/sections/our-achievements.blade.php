@if($widget != null)

@if($widget->section == \Config::get('site.widgets.our_achievement_style1'))
@include('frontend.sections.achievements.style1')
@elseif($widget->section == \Config::get('site.widgets.our_achievement_style2'))
@include('frontend.sections.achievements.style2')
@endif

@endif
