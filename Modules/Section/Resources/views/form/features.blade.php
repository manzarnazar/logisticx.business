

<div class="form-group col-lg-6 ">
    <label class="label-style-1">{{ ___('label.section_tagline') }} </label>
    <input type="text" class="form-control input-style-1" name="section_tagline" value="{{ @$section['section_tagline'] }}" required>
    <input type="hidden" class="form-control input-style-1" name="name[]" value="section_tagline">
</div>


<div class="form-group col-lg-6 ">
    <label class="label-style-1">{{ ___('label.section_main_title') }} </label>
    <input type="text" class="form-control input-style-1" name="section_main_title" value="{{ @$section['section_main_title'] }}" required>
    <input type="hidden" class="form-control input-style-1" name="name[]" value="section_main_title">
</div>
<div class="col-md-6">
    <label class="label-style-1">{{ ___('label.bg_image') }} <span class="fillable"></span></label>

    <div class="ot_fileUploader left-side mb-3">

        @php
        $right_info_image = App\Models\Backend\Upload::find($section['bg_image']);
        @endphp

        <img src="{{ getImage($right_info_image,'original') }}" alt=" " class="rounded">
        <input class="form-control input-style-1 placeholder" type="text" placeholder="{{ ___('placeholder.attach_file') }}" readonly>
        <button class="primary-btn-small-input" type="button">
            <label class="j-td-btn" for="bg_image">{{ ___('label.browse') }}</label>
            <input type="file" class="d-none form-control" name="bg_image" value="bg_image" id="bg_image" accept="image/jpeg, image/jpg, image/png, image/webp">
        </button>
    </div>
</div>

<div class="form-group col-lg-6 ">
    <label class="label-style-1">{{ ___('label.process_one') }} </label>
    <input type="text" class="form-control input-style-1" name="process_one" value="{{ @$section['process_one'] }}" required>
    <input type="hidden" class="form-control input-style-1" name="name[]" value="process_one">
</div>

<div class="form-group col-lg-6 ">
    <label class="label-style-1">{{ ___('label.process_two') }} </label>
    <input type="text" class="form-control input-style-1" name="process_two" value="{{ @$section['process_two'] }}" required>
    <input type="hidden" class="form-control input-style-1" name="name[]" value="process_two">
</div>

<div class="form-group col-lg-6 ">
    <label class="label-style-1">{{ ___('label.process_three') }} </label>
    <input type="text" class="form-control input-style-1" name="process_three" value="{{ @$section['process_three'] }}" required>
    <input type="hidden" class="form-control input-style-1" name="name[]" value="process_three">
</div>

