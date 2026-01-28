<div class="form-group col-lg-6 ">
    <label class="label-style-1">{{ ___('label.section_tagline') }} </label>
    <input type="text" class="form-control input-style-1" name="section_tagline" value="{{ @$section['section_tagline'] }}" required>
    <input type="hidden" class="form-control input-style-1" name="name[]" value="section_tagline">
</div>

<div class="form-group col-lg-6 ">
    <label class="label-style-1">{{ ___('label.section_title') }} </label>
    <input type="text" class="form-control input-style-1" name="section_main_title" value="{{ @$section['section_main_title'] }}" required>
    <input type="hidden" class="form-control input-style-1" name="name[]" value="section_main_title">
</div>
{{-- <div class="form-group col-lg-6 ">
    <label class="label-style-1">{{ ___('label.image') }} </label>
    <input type="text" class="form-control input-style-1" name="HowWeWork_image" value="{{ @$section['HowWeWork_image'] }}" required>
    <input type="hidden" class="form-control input-style-1" name="name[]" value="HowWeWork_image">
</div> --}}

<div class="col-md-6">
    <label class="label-style-1">{{ ___('label.image') }} <span class="fillable"></span></label>

    <div class="ot_fileUploader left-side mb-3">

        @php
        $HowWeWork_image = App\Models\Backend\Upload::find($section['HowWeWork_image']);
        @endphp

        <img src="{{ getImage($HowWeWork_image,'original') }}" alt=" " class="rounded">
        <input class="form-control input-style-1 placeholder" type="text" placeholder="{{ ___('placeholder.attach_file') }}" readonly>
        <button class="primary-btn-small-input" type="button">
            <label class="j-td-btn" for="HowWeWork_image">{{ ___('label.browse') }}</label>
            <input type="file" class="d-none form-control" name="HowWeWork_image" value="HowWeWork_image" id="HowWeWork_image" accept="image/jpeg, image/jpg, image/png, image/webp">
        </button>
    </div>
</div>
