@if($widget != null)

@if($widget->section == \Config::get('site.widgets.gallery_style1'))
@include('frontend.sections.gallery.style1')
@endif

@endif
