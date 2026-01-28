@extends('frontend.master')

@section('main')

{{-- @dd($widgets) --}}
@foreach ($widgets as $widget)

     @if ($widget->section == \Config::get('site.widgets.hero_section_style1') || $widget->section == \Config::get('site.widgets.hero_section_style2')  )
     <x-frontend.sections.hero-section :widget="$widget" />

     @elseif($widget->section == config('site.widgets.how_it_work_style1') || $widget->section == config('site.widgets.how_it_work_style2'))
     <x-frontend.sections.how-it-work-view :widget="$widget" />

     @elseif($widget->section == \Config::get('site.widgets.about_us_style1') || $widget->section == \Config::get('site.widgets.about_us_style2'))
     <x-frontend.sections.about-us :widget="$widget" />

     @elseif($widget->section == \Config::get('site.widgets.gallery_style1'))
     <x-frontend.sections.gallery :widget="$widget" />

     @elseif($widget->section == \Config::get('site.widgets.services_style1') || $widget->section == \Config::get('site.widgets.services_style2'))
     <x-frontend.sections.service-view :widget="$widget" />

     @elseif ($widget->section == \Config::get('site.widgets.charge_list_style1'))
     <x-frontend.sections.charge-list :widget="$widget" />

     @elseif ($widget->section == \Config::get('site.widgets.delivery_calculator_style1') ||$widget->section == \Config::get('site.widgets.delivery_calculator_style2'))
     <x-frontend.sections.delivery-calculator :widget="$widget" />

     @elseif ($widget->section == \Config::get('site.widgets.faq_style1') || $widget->section == \Config::get('site.widgets.faq_style2') )
     <x-frontend.sections.faq-view :widget="$widget" />

     @elseif ($widget->section == \Config::get('site.widgets.client_review_style1') || $widget->section == \Config::get('site.widgets.client_review_style2'))
     <x-frontend.sections.client-review :widget="$widget" />

     @elseif ($widget->section == \Config::get('site.widgets.our_achievement_style1') || $widget->section == \Config::get('site.widgets.our_achievement_style2'))
     <x-frontend.sections.our-achievements :widget="$widget" />

     @elseif ($widget->section == \Config::get('site.widgets.blogs_style1'))
     <x-frontend.sections.blog-view :widget="$widget" />

     @elseif ($widget->section == \Config::get('site.widgets.clients_style1') || $widget->section == \Config::get('site.widgets.clients_style2'))
     <x-frontend.sections.client-new :widget="$widget" />

     @elseif ($widget->section == \Config::get('site.widgets.coverage_area_style1') ||$widget->section == \Config::get('site.widgets.coverage_area_style2'))
     <x-frontend.sections.coverage-area :widget="$widget" />

     @elseif ($widget->section == \Config::get('site.widgets.cta_style1') || $widget->section == \Config::get('site.widgets.cta_style2'))
     <x-frontend.sections.cta :widget="$widget" />

     @endif

@endforeach

@endsection

@push('scripts')
@endpush
