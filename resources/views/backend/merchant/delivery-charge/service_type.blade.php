<option></option>
@foreach ($serviceTypes as $serviceType)
<option value="{{ $serviceType->service_type_id }}" {{ (old('service_type') == $serviceType->service_type_id) ? 'selected' : '' }}>{{ $serviceType->serviceType->name }}</option>
@endforeach
