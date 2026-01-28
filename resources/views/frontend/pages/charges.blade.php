@extends('frontend.master')

@section('title')
{{ ___('label.charge') . " | " . settings('name') }}
@endsection

@section('main')

<!-- Start Calculator  -->
@if ($calculatorWidget )
<x-frontend.sections.delivery-calculator :widget="$calculatorWidget" />
@endif
<!-- End Calculator -->

<!-- Start Charge List -->
@if ($chargeListWidget )
<x-frontend.sections.charge-list :widget="$chargeListWidget" />
@endif
<!-- End Charge List -->

@endsection


@push('scripts')
{{-- <script src="{{ asset('frontend/js/charge_calculation.js') }}"></script> --}}
@endpush
