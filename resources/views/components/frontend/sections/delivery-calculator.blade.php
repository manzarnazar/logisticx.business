@if($widget != null)

@if($widget->section == \Config::get('site.widgets.delivery_calculator_style1'))
    @include('frontend.sections.delivery-calculator.style1')
@elseif($widget->section == \Config::get('site.widgets.delivery_calculator_style2'))
    @include('frontend.sections.delivery-calculator.style2') 
@endif

@endif


@push('scripts')
<script src="{{ asset('frontend/js/charge_calculations.js')}}"></script>

<script>
    $(document).ready(function() {
        $('#pickup_area').select2({
            placeholder: "{{ ___('label.select') }} {{ ___('label.pickup_area')  }}",
            allowClear: true
        });
        $('#delivery_area').select2({
            placeholder: "{{ ___('label.select') }} {{ ___('label.delivery_area') }}",
            allowClear: true
        });
        $('#product_category').select2({
            placeholder: "{{ ___('label.select') }} {{ ___('charges.product_category') }}",
            allowClear: true
        });
        $('#service_type').select2({
            placeholder: "{{ ___('label.select') }} {{ ___('charges.service_type') }}",
            allowClear: true
        });

    });
</script>    
@endpush
