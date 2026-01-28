
@if($widget->section == \Config::get('site.widgets.hero_section_style1'))
@include('frontend.sections.hero.style1')
@elseif($widget->section == \Config::get('site.widgets.hero_section_style2'))
@include('frontend.sections.hero.style2')
@elseif($widget->section == \Config::get('site.widgets.hero_section_style3'))
@include('frontend.sections.hero.style3')
@endif
