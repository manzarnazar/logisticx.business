
@if($widget->section == \Config::get('site.widgets.faq_style1'))
       @include('frontend.sections.faq.style1')
@elseif($widget->section == \Config::get('site.widgets.faq_style2'))
       @include('frontend.sections.faq.style2') 
@endif
