@if($footer != null)

@if($footer->section == \Config::get('site.widgets.footer_style1'))
@include('frontend.sections.footer.style1')

@elseif($footer->section == \Config::get('site.widgets.footer_style2'))
@include('frontend.sections.footer.style2')

@endif

@endif
