@if ($header != null)
    @if ($header->section == \Config::get('site.widgets.header_style1'))
      @include('frontend.sections.header.style1')
    @elseif($header->section == \Config::get('site.widgets.header_style2'))
        @include('frontend.sections.header.style2')
    @endif
@endif
