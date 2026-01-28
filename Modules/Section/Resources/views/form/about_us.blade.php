
<div class="form-group col-lg-6 ">
    <label class="label-style-1">{{ ___('label.small_heading') }} </label>
    <input type="text" class="form-control input-style-1" name="section_tagline" value="{{ @$section['section_tagline'] }}" required>
    <input type="hidden" class="form-control input-style-1" name="name[]" value="section_tagline">
</div>

<div class="form-group col-lg-6 ">
    <label class="label-style-1">{{ ___('label.main_heading') }} </label>
    <input type="text" class="form-control input-style-1" name="section_main_title" value="{{ @$section['section_main_title'] }}" required>
    <input type="hidden" class="form-control input-style-1" name="name[]" value="section_main_title">
</div>

<div class="form-group col-lg-6 ">
    <label class="label-style-1">{{ ___('label.clients_label') }} </label>
    <input type="text" class="form-control input-style-1" name="satisfied_clients_label" value="{{ @$section['satisfied_clients_label'] }}" required>
    <input type="hidden" class="form-control input-style-1" name="name[]" value="satisfied_clients_label">
</div>
<div class="form-group col-lg-3 ">
    <label class="label-style-1">{{ ___('label.total_satisfied_clients') }} </label>
    <input type="text" class="form-control input-style-1" name="total_satisfied_clients" value="{{ @$section['total_satisfied_clients'] }}" required>
    <input type="hidden" class="form-control input-style-1" name="name[]" value="total_satisfied_clients">
</div>

<div class="col-md-3">
       @php
        $client_avatar = App\Models\Backend\Upload::find($section['client_avatar_image']);
        @endphp
    <label class="label-style-1">{{ ___('label.client_avatar_image') }}<span class="fillable"></span></label>
    <div class="ot_fileUploader left-side mb-3">
        <img src="{{ getImage($client_avatar,'original') }}">
        <input class="form-control input-style-1 placeholder" type="text" placeholder="{{ ___('placeholder.attach_file') }}" readonly>
        <button class="primary-btn-small-input" type="button">
            <label class="j-td-btn" for="client_avatar_image">{{ ___('label.browse') }}</label>
            <input type="file" class="d-none form-control" name="client_avatar_image" id="client_avatar_image" accept="image/jpeg, image/jpg, image/png, image/webp">
        </button>
    </div>
    @error('section_image_one')
    <small class="text-danger mt-2">{{ $message }}</small>
    @enderror
</div>

<div class="form-group col-lg-3 ">
    <label class="label-style-1">{{ ___('label.left_service_title1') }} </label>
    <input type="text" class="form-control input-style-1" name="left_service_title1" value="{{ @$section['left_service_title1'] }}" required>
    <input type="hidden" class="form-control input-style-1" name="name[]" value="left_service_title1">
</div>



<div class="col-md-3">
     @php
        $left_service_image_one = App\Models\Backend\Upload::find($section['left_service_image_one']);
        @endphp
    <label class="label-style-1">{{ ___('label.left_service_image_one') }}<span class="fillable"></span></label>
    <div class="ot_fileUploader left-side mb-3">
        <img src="{{ getImage($left_service_image_one,'original') }}">
        <input class="form-control input-style-1 placeholder" type="text" placeholder="{{ ___('placeholder.attach_file') }}" readonly>
        <button class="primary-btn-small-input" type="button">
            <label class="j-td-btn" for="left_service_image_one">{{ ___('label.browse') }}</label>
            <input type="file" class="d-none form-control" name="left_service_image_one" id="left_service_image_one" accept="image/jpeg, image/jpg, image/png, image/webp">
        </button>
    </div>
    @error('left_service_icon')
    <small class="text-danger mt-2">{{ $message }}</small>
    @enderror
</div>
<div class="form-group col-lg-3 ">
    <label class="label-style-1">{{ ___('label.left_service_title2') }} </label>
    <input type="text" class="form-control input-style-1" name="left_service_title2" value="{{ @$section['left_service_title2'] }}" required>
    <input type="hidden" class="form-control input-style-1" name="name[]" value="left_service_title2">
</div>

<div class="col-md-3">
     @php
        $left_service_image_two = App\Models\Backend\Upload::find($section['left_service_image_two']);
        @endphp
    <label class="label-style-1">{{ ___('label.left_service_image_two') }}<span class="fillable"></span></label>
    <div class="ot_fileUploader left-side mb-3">
        <img src="{{ getImage($left_service_image_two,'original') }}">
        <input class="form-control input-style-1 placeholder" type="text" placeholder="{{ ___('placeholder.attach_file') }}" readonly>
        <button class="primary-btn-small-input" type="button">
            <label class="j-td-btn" for="left_service_image_two">{{ ___('label.browse') }}</label>
            <input type="file" class="d-none form-control" name="left_service_image_two" id="left_service_image_two" accept="image/jpeg, image/jpg, image/png, image/webp">
        </button>
    </div>
    @error('left_service_icon')
    <small class="text-danger mt-2">{{ $message }}</small>
    @enderror
</div>

<div class="form-group col-lg-3 ">
    <label class="label-style-1">{{ ___('label.right_service_title1') }} </label>
    <input type="text" class="form-control input-style-1" name="right_service_title1" value="{{ @$section['right_service_title1'] }}" required>
    <input type="hidden" class="form-control input-style-1" name="name[]" value="right_service_title1">
</div>

<div class="col-md-3">
     @php
        $right_service_image_one = App\Models\Backend\Upload::find($section['right_service_image_one']);
        @endphp
    <label class="label-style-1">{{ ___('label.right_service_image_one') }}<span class="fillable"></span></label>
    <div class="ot_fileUploader left-side mb-3">
        <img src="{{ getImage($right_service_image_one,'original') }}">
        <input class="form-control input-style-1 placeholder" type="text" placeholder="{{ ___('placeholder.attach_file') }}" readonly>
        <button class="primary-btn-small-input" type="button">
            <label class="j-td-btn" for="right_service_image_one">{{ ___('label.browse') }}</label>
            <input type="file" class="d-none form-control" name="right_service_image_one" id="right_service_image_one" accept="image/jpeg, image/jpg, image/png, image/webp">
        </button>
    </div>
    @error('right_service_icon')
    <small class="text-danger mt-2">{{ $message }}</small>
    @enderror
</div>
<div class="form-group col-lg-3 ">
    <label class="label-style-1">{{ ___('label.right_service_title2') }} </label>
    <input type="text" class="form-control input-style-1" name="right_service_title2" value="{{ @$section['right_service_title2'] }}" required>
    <input type="hidden" class="form-control input-style-1" name="name[]" value="right_service_title2">
</div>

<div class="col-md-3">
     @php
        $right_service_image_two = App\Models\Backend\Upload::find($section['right_service_image_two']);
        @endphp
    <label class="label-style-1">{{ ___('label.right_service_image_two') }}<span class="fillable"></span></label>
    <div class="ot_fileUploader left-side mb-3">
        <img src="{{ getImage($right_service_image_two,'original') }}">
        <input class="form-control input-style-1 placeholder" type="text" placeholder="{{ ___('placeholder.attach_file') }}" readonly>
        <button class="primary-btn-small-input" type="button">
            <label class="j-td-btn" for="right_service_image_two">{{ ___('label.browse') }}</label>
            <input type="file" class="d-none form-control" name="right_service_image_two" id="right_service_image_two" accept="image/jpeg, image/jpg, image/png, image/webp">
        </button>
    </div>
    @error('right_service_icon')
    <small class="text-danger mt-2">{{ $message }}</small>
    @enderror
</div>

<div class="form-group col-lg-6 ">
    <label class="label-style-1">{{ ___('label.promotional_red_text') }} </label>
    <input type="text" class="form-control input-style-1" name="promotional_red_text" value="{{ @$section['promotional_red_text'] }}" required>
    <input type="hidden" class="form-control input-style-1" name="name[]" value="promotional_red_text">
</div>

<div class="form-group col-lg-6 ">
    <label class="label-style-1">{{ ___('label.primary_button_text') }} </label>
    <input type="text" class="form-control input-style-1" name="primary_button_text" value="{{ @$section['primary_button_text'] }}" required>
    <input type="hidden" class="form-control input-style-1" name="name[]" value="primary_button_text">
</div>
<div class="form-group col-lg-6 ">
    <label class="label-style-1">{{ ___('label.primary_button_link') }} </label>
    <input type="url" class="form-control input-style-1" name="primary_button_link" value="{{ @$section['primary_button_link'] }}" required>
    <input type="hidden" class="form-control input-style-1" name="name[]" value="primary_button_link">
</div>

<div class="form-group col-lg-6 ">
    <label class="label-style-1">{{ ___('label.contact_title') }} </label>
    <input type="text" class="form-control input-style-1" name="contact_title" value="{{ @$section['contact_title'] }}" required>
    <input type="hidden" class="form-control input-style-1" name="name[]" value="contact_title">
</div>

<div class="form-group col-lg-4 ">
    <label class="label-style-1">{{ ___('label.contact_number') }} </label>
    <input type="tel" class="form-control input-style-1" name="contact_number" value="{{ @$section['contact_number'] }}" required>
    <input type="hidden" class="form-control input-style-1" name="name[]" value="contact_number">
</div>

<div class="col-md-4">
       @php
        $section_image_one = App\Models\Backend\Upload::find($section['section_image_one']);
        @endphp
    <label class="label-style-1">{{ ___('label.section_image_one') }}<span class="fillable"></span></label>
    <div class="ot_fileUploader left-side mb-3">
        <img src="{{ getImage($section_image_one,'original') }}">
        <input class="form-control input-style-1 placeholder" type="text" placeholder="{{ ___('placeholder.attach_file') }}" readonly>
        <button class="primary-btn-small-input" type="button">
            <label class="j-td-btn" for="section_image_one">{{ ___('label.browse') }}</label>
            <input type="file" class="d-none form-control" name="section_image_one" id="section_image_one" accept="image/jpeg, image/jpg, image/png, image/webp">
        </button>
    </div>
    @error('section_image_one')
    <small class="text-danger mt-2">{{ $message }}</small>
    @enderror
</div>



<div class="col-md-4">
       @php
        $section_image_two = App\Models\Backend\Upload::find($section['section_image_two']);
        @endphp
    <label class="label-style-1">{{ ___('label.section_image_two') }}<span class="fillable"></span></label>
    <div class="ot_fileUploader left-side mb-3">
        <img src="{{ getImage($section_image_two,'original') }}">
        <input class="form-control input-style-1 placeholder" type="text" placeholder="{{ ___('placeholder.attach_file') }}" readonly>
        <button class="primary-btn-small-input" type="button">
            <label class="j-td-btn" for="section_image_two">{{ ___('label.browse') }}</label>
            <input type="file" class="d-none form-control" name="section_image_two" id="section_image_two" accept="image/jpeg, image/jpg, image/png, image/webp">
        </button>
    </div>
    @error('section_image_two')
    <small class="text-danger mt-2">{{ $message }}</small>
    @enderror
</div>

<div class="form-group col-lg-6 ">
    <label class="label-style-1">{{ ___('label.description') }} </label>
    {{-- <input type="text" class="form-control input-style-1 summernote" id="summernote" name="section_description" value="{{ @$section['section_description'] }}" required> --}}
    <textarea class="form-control input-style-1 summernote" id="summernote" name="section_description" rows="6">{!! @$section['section_description'] !!}</textarea>
    <input type="hidden" class="form-control input-style-1" name="name[]" value="section_description">
</div>
