@if($widget != null)
       @if($widget->section == \Config::get('site.widgets.client_review_style1'))
              @include('frontend.sections.client-review.style1')
       @elseif($widget->section == \Config::get('site.widgets.client_review_style2'))
              @include('frontend.sections.client-review.style2')
       @endif
 @endif
 