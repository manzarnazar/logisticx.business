
<div class="form-group col-lg-6 ">
    <label class="label-style-1">{{ ___('label.section_tagline') }} </label>
    <input type="text" class="form-control input-style-1" name="section_tagline" value="{{ @$section['section_tagline'] }}" required>
    <input type="hidden" class="form-control input-style-1" name="name[]" value="section_tagline">
</div>

<div class="form-group col-lg-6 ">
    <label class="label-style-1">{{ ___('label.section_title') }} </label>
    <input type="text" class="form-control input-style-1" name="section_title" value="{{ @$section['section_title'] }}" required>
    <input type="hidden" class="form-control input-style-1" name="name[]" value="section_title">
</div>

<div class="col-md-6">
    <label class="label-style-1">{{ ___('label.image') }} <span class="fillable"></span></label>
    <div class="ot_fileUploader left-side mb-3">
        <img src="{{ getImage(@$section['image']) }}" alt=" ">
        <input class="form-control input-style-1 placeholder" type="text" placeholder="{{ ___('placeholder.attach_file') }}" readonly>
        <button class="primary-btn-small-input" type="button">
            <label class="j-td-btn" for="image">{{ ___('label.browse') }}</label>
            <input type="file" class="d-none form-control" name="image" id="image" accept="image/jpeg, image/jpg, image/png, image/webp">
        </button>
    </div>
</div>
<div class="col-md-6">
    <label class="label-style-1">{{ ___('label.background_image') }} <span class="fillable"></span></label>
    <div class="ot_fileUploader left-side mb-3">
        <img src="{{ getImage(@$section['background_image']) }}" alt=" ">
        <input class="form-control input-style-1 placeholder" type="text" placeholder="{{ ___('placeholder.attach_file') }}" readonly>
        <button class="primary-btn-small-input" type="button">
            <label class="j-td-btn" for="background_image">{{ ___('label.browse') }}</label>
            <input type="file" class="d-none form-control" name="background_image" id="background_image" accept="image/jpeg, image/jpg, image/png, image/webp">
        </button>
    </div>
</div>

<div class="form-group col-lg-6 ">
    <label class="label-style-1">{{ ___('label.description') }} </label>
    <textarea class="form-control input-style-1 summernote" id="summernote" name="description" rows="6">{!! @$section['description'] !!}</textarea>
    <input type="hidden" class="form-control input-style-1" name="name[]" value="description">
</div>

