<option></option>
@foreach ($areas as $area)
<option value="{{ $area->area }}" {{ (old('area') == $area->area) ? 'selected' : '' }}>{{ ___(('area.'.$area->area)) }}</option>
@endforeach
