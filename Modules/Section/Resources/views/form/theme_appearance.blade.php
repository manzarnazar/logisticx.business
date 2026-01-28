<div class="form-group col-lg-6">
    <label class="label-style-1">{{ ___('label.primary_color') }} </label>
    <input type="color" class="form-control input-style-1" name="primary_color" value="{{ @$section['primary_color'] }}" required>
    <input type="hidden" class="form-control input-style-1" name="name[]" value="primary_color">
</div>
<div class="form-group col-lg-6">
    <label class="label-style-1">{{ ___('label.primary_text_color') }} </label>
    <input type="color" class="form-control input-style-1" name="primary_text_color" value="{{ @$section['primary_text_color'] }}" required>
    <input type="hidden" class="form-control input-style-1" name="name[]" value="primary_text_color">
</div>
<div class="form-group col-lg-6">
    <label class="label-style-1">{{ ___('label.secondary_text_color') }} </label>
    <input type="color" class="form-control input-style-1" name="secondary_text_color" value="{{ @$section['secondary_text_color'] }}" required>
    <input type="hidden" class="form-control input-style-1" name="name[]" value="secondary_text_color">
</div>

<div class="form-group col-12 col-lg-6">
    <label class="label-style-1">{{ ___('label.font_family_heading') }} <span class="text-danger">*</span></label>
    <select name="font_family_heading" class="form-control input-style-1 select2">
        @foreach (App\Enums\FontFamily::cases() as $fontFamily)
            <option value="{{ $fontFamily->value }}" {{@$section['font_family_heading'] == $fontFamily->value ? 'selected' : ''}}>
                {{ $fontFamily->label() }} <!-- Format to human-readable name -->
            </option>
        @endforeach

    </select>
    <input type="hidden" class="form-control input-style-1" name="name[]" value="font_family_heading">
</div>

<div class="form-group col-12 col-lg-6">
    <label class="label-style-1">{{ ___('label.font_family_body') }} <span class="text-danger">*</span></label>
    <select name="font_family_body" class="form-control input-style-1 select2">
        @foreach (App\Enums\FontFamily::cases() as $fontFamily)
            <option value="{{ $fontFamily->value }}" {{@$section['font_family_body'] == $fontFamily->value ? 'selected' : ''}}>
                {{ $fontFamily->label() }} <!-- Format to human-readable name -->
            </option>
        @endforeach

    </select>
    <input type="hidden" class="form-control input-style-1" name="name[]" value="font_family_body">
</div>

<div class="form-group col-md-6">
    <label class="label-style-1">{{ ___('label.button_input_field_style') }}</label>
    <div class="custom-control custom-checkbox d-flex gap-6">
        <div class="form-check form-check-inline">
            <input type="radio" class="custom-control-input" id="rounded" name="button_input_style" value="rounded" {{@$section['button_input_style'] == 'rounded' ? 'checked' : ''}}>
            <label class="custom-control-label" for="rounded">{{ ___('parcel.rounded') }}</label>
        </div>
        <div class="form-check form-check-inline ml-5">

            <input type="radio" class="custom-control-input" id="square" name="button_input_style" value="square" {{@$section['button_input_style'] == 'square' ? 'checked' : ''}}>
            <label class="custom-control-label" for="square">{{ ___('parcel.square') }}</label>
        </div>


    </div>
    
    <input type="hidden" class="form-control input-style-1" name="name[]" value="button_input_style">
</div>
