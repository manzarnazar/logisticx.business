
<div class="form-group col-lg-6 ">
    <label class="label-style-1">{{ ___('label.section_tagline') }} </label>
    <input type="text" class="form-control input-style-1" name="section_tagline" value="{{ @$section['section_tagline'] }}" required>
    <input type="hidden" class="form-control input-style-1" name="name[]" value="section_tagline">
</div>

<div class="form-group col-lg-6 ">
    <label class="label-style-1">{{ ___('label.progress_title') }} </label>
    <input type="text" class="form-control input-style-1" name="progress_title" value="{{ @$section['progress_title'] }}" required>
    <input type="hidden" class="form-control input-style-1" name="name[]" value="progress_title">
</div>
<div class="form-group col-lg-6 ">
    <label class="label-style-1">{{ ___('label.progress_value') }} </label>
    <input type="text" class="form-control input-style-1" name="progress_value" value="{{ @$section['progress_value'] }}" required>
    <input type="hidden" class="form-control input-style-1" name="name[]" value="progress_value">
</div>
<div class="form-group col-lg-6 ">
    <label class="label-style-1">{{ ___('label.button_url') }} </label>
    <input type="text" class="form-control input-style-1" name="button_url" value="{{ @$section['button_url'] }}" required>
    <input type="hidden" class="form-control input-style-1" name="name[]" value="button_url">
</div>
<div class="form-group col-lg-6 ">
    <label class="label-style-1">{{ ___('label.button_text') }} </label>
    <input type="text" class="form-control input-style-1" name="button_text" value="{{ @$section['button_text'] }}" required>
    <input type="hidden" class="form-control input-style-1" name="name[]" value="button_text">
</div>
<div class="form-group col-lg-6 ">
    <label class="label-style-1">{{ ___('label.section_title') }} </label>
    <input type="text" class="form-control input-style-1" name="section_title" value="{{ @$section['section_title'] }}" required>
    <input type="hidden" class="form-control input-style-1" name="name[]" value="section_title">
</div>

<div class="col-md-6">
    <label class="label-style-1">{{ ___('label.background_image') }} <span class="fillable"></span></label>
    <div class="ot_fileUploader left-side mb-3">
        <img src="{{ getImage(@$section['image']) }}" alt=" ">
        <input class="form-control input-style-1 placeholder" type="text" placeholder="{{ ___('placeholder.attach_file') }}" readonly>
        <button class="primary-btn-small-input" type="button">
            <label class="j-td-btn" for="image">{{ ___('label.browse') }}</label>
            <input type="file" class="d-none form-control" name="image" id="image" accept="image/jpeg, image/jpg, image/png, image/webp">
        </button>
    </div>
</div>

<div class="form-group col-lg-6 ">
    <label class="label-style-1">{{ ___('label.description') }} </label>
    <textarea class="form-control input-style-1 summernote" id="summernote" name="description" rows="6">{!! @$section['description'] !!}</textarea>
    <input type="hidden" class="form-control input-style-1" name="name[]" value="description">
</div>

