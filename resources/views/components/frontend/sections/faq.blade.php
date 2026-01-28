@if($faq->section == \Config::get('site.widgets.faq_style1'))
       @include('frontend.sections.faq.style1')
@elseif($faq->section == \Config::get('site.widgets.faq_style2'))
       @include('frontend.sections.faq.style2')
@elseif($faq->section == \Config::get('site.widgets.faq_style3'))
       @include('frontend.sections.faq.style3')
@endif