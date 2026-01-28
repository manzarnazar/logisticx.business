<div class="form-group col-lg-6 ">
    <label class="label-style-1">{{ ___('label.privacy return pages') }} </label>
    <input type="text" class="form-control input-style-1" name="title" value="{{ @$section['title'] }}" required>
    <input type="hidden" class="form-control input-style-1" name="name[]" value="title">
</div>

{{-- <div class="form-group col-lg-6 ">
    <label class="label-style-1">{{ ___('label.image') }} </label>
<input type="file" class="form-control input-style-1" name="about-us-image-left">
<input type="hidden" class="form-control input-style-1" name="name[]" value="about-us-image-left">
</div> --}}

<div class="col-md-6">
    <label class="label-style-1">{{ ___('label.image') }} <span class="fillable"></span></label>

    <div class="ot_fileUploader left-side mb-3">
        <input class="form-control input-style-1 placeholder" type="text" placeholder="{{ ___('placeholder.attach_file') }}" readonly>
        <button class="primary-btn-small-input" type="button">
            <label class="j-td-btn" for="fileBrouse">{{ ___('label.browse') }}</label>
            <input type="file" class="d-none form-control" name="about-us-image-left" value="about-us-image-left" id="fileBrouse" accept="image/jpeg, image/jpg, image/png, image/webp">
        </button>
    </div>
</div>

<div class="form-group col-lg-6 ">
    <label class="label-style-1">{{ ___('label.description') }} </label>
    <input type="text" class="form-control input-style-1" name="description" value="{{ @$section['description'] }}" required>
    <input type="hidden" class="form-control input-style-1" name="name[]" value="description">
</div>
