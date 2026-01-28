@if($widget != null)
       @if($widget->section == \Config::get('site.widgets.clients_style1'))
              @include('frontend.sections.clients.style1')
       @elseif($widget->section == \Config::get('site.widgets.clients_style2'))
              @include('frontend.sections.clients.style2')
       @endif
@endif
