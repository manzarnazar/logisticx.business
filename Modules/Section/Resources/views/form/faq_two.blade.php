

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

<div class="form-group col-lg-6 ">
    <label class="label-style-1">{{ ___('label.label_one_value') }} </label>
    <input type="number" class="form-control input-style-1" name="label_one_value" value="{{ @$section['label_one_value'] }}" required>
    <input type="hidden" class="form-control input-style-1" name="name[]" value="label_one_value">
</div>

<div class="form-group col-lg-6 ">
    <label class="label-style-1">{{ ___('label.label_one_title') }} </label>
    <input type="text" class="form-control input-style-1" name="label_one_title" value="{{ @$section['label_one_title'] }}" required>
    <input type="hidden" class="form-control input-style-1" name="name[]" value="label_one_title">
</div>

<div class="form-group col-lg-6 ">
    <label class="label-style-1">{{ ___('label.label_two_value') }} </label>
    <input type="number" class="form-control input-style-1" name="label_two_value" value="{{ @$section['label_two_value'] }}" required>
    <input type="hidden" class="form-control input-style-1" name="name[]" value="label_two_value">
</div>

<div class="form-group col-lg-6 ">
    <label class="label-style-1">{{ ___('label.label_two_title') }} </label>
    <input type="text" class="form-control input-style-1" name="label_two_title" value="{{ @$section['label_two_title'] }}" required>
    <input type="hidden" class="form-control input-style-1" name="name[]" value="label_two_title">
</div>
<div class="col-md-6">
    <label class="label-style-1">{{ ___('label.faq_image') }} <span class="fillable"></span></label>

    <div class="ot_fileUploader left-side mb-3">

        @php
        $faq_image = App\Models\Backend\Upload::find($section['faq_image']);
        @endphp

        <img src="{{ getImage($faq_image,'original') }}" alt=" " class="rounded">
        <input class="form-control input-style-1 placeholder" type="text" placeholder="{{ ___('placeholder.attach_file') }}" readonly>
        <button class="primary-btn-small-input" type="button">
            <label class="j-td-btn" for="faq_image">{{ ___('label.browse') }}</label>
            <input type="file" class="d-none form-control" name="faq_image" value="faq_image" id="faq_image" accept="image/jpeg, image/jpg, image/png, image/webp">
        </button>
    </div>
</div>

<div class="form-group col-lg-6 ">
    <label class="label-style-1">{{ ___('label.description') }} </label>
    <textarea class="form-control input-style-1 summernote" id="summernote" name="description" rows="6">{{ @$section['description'] }}</textarea>
    <input type="hidden" class="form-control input-style-1" name="name[]" value="description">
</div>
