<div class="form-group col-lg-6">
    <label class=" label-style-1" for="hero_section_title">{{ ___('label.title') }}</label>
    <textarea class="form-control input-style-1 summernote" name="hero_section_title" id="hero_section_title" placeholder="{{ ___("placeholder.enter_title")}}">{{ @$section['hero_section_title'] }}</textarea>
    <input type="hidden" class="form-control input-style-1" name="name[]" value="hero_section_title">
</div>

<div class="form-group col-lg-6 ">
    <label class="label-style-1" for="hero_section_short_description">{{ ___('label.slogan') }} </label>
    <textarea class="form-control input-style-1" name="hero_section_short_description" id="hero_section_short_description" rows="4" placeholder="{{ ___("placeholder.slogan")}}">{{ @$section['hero_section_short_description'] }}</textarea>
    <input type="hidden" class="form-control input-style-1" name="name[]" value="hero_section_short_description">
</div>

<div class="form-group col-lg-6 ">
    <label class="label-style-1">{{ ___('label.short_title') }} </label>
    <input type="text" class="form-control input-style-1" name="short_title" value="{{ @$section['short_title'] }}" required>
    <input type="hidden" class="form-control input-style-1" name="name[]" value="short_title">
</div>

<div class="form-group col-lg-6 ">
    <label class="label-style-1">{{ ___('label.clients_label') }} </label>
    <input type="text" class="form-control input-style-1" name="satisfied_clients_label" value="{{ @$section['satisfied_clients_label'] }}" required>
    <input type="hidden" class="form-control input-style-1" name="name[]" value="satisfied_clients_label">
</div>
<div class="form-group col-lg-6 ">
    <label class="label-style-1">{{ ___('label.total_satisfied_clients') }} </label>
    <input type="text" class="form-control input-style-1" name="total_satisfied_clients" value="{{ @$section['total_satisfied_clients'] }}" required>
    <input type="hidden" class="form-control input-style-1" name="name[]" value="total_satisfied_clients">
</div>
<div class="form-group col-lg-6 ">
    <label class="label-style-1">{{ ___('label.link') }} </label>
    <input type="url" class="form-control input-style-1" name="link" value="{{ @$section['link'] }}" required>
    <input type="hidden" class="form-control input-style-1" name="name[]" value="link">
</div>
<div class="form-group col-lg-6 ">
    <label class="label-style-1">{{ ___('label.button_name') }} </label>
    <input type="text" class="form-control input-style-1" name="button_name" value="{{ @$section['button_name'] }}" required>
    <input type="hidden" class="form-control input-style-1" name="name[]" value="button_name">
</div>

<div class="col-md-6">
    <label class="label-style-1">{{ ___('label.hero_image') }} <span class="fillable"></span></label>

    <div class="ot_fileUploader left-side mb-3">

        @php
        $upload = App\Models\Backend\Upload::find($section['hero_image']);
        @endphp

        <img src="{{ getImage($upload,'original') }}" alt=" " class="rounded">
        <input class="form-control input-style-1 placeholder" type="text" placeholder="{{ ___('placeholder.attach_file') }}" readonly>
        <button class="primary-btn-small-input" type="button">
            <label class="j-td-btn" for="fileBrouse">{{ ___('label.browse') }}</label>
            <input type="file" class="d-none form-control" name="hero_image" value="hero_image" id="fileBrouse" accept="image/jpeg, image/jpg, image/png, image/webp">
        </button>
    </div>
</div>


<div class="col-md-6">
    <label class="label-style-1">{{ ___('label.client_image_one') }} <span class="fillable"></span></label>

    <div class="ot_fileUploader left-side mb-3">

        @php
        $client_image_one = App\Models\Backend\Upload::find($section['client_image_one']);
        @endphp

        <img src="{{ getImage($client_image_one,'original') }}" alt=" " class="rounded">
        <input class="form-control input-style-1 placeholder" type="text" placeholder="{{ ___('placeholder.attach_file') }}" readonly>
        <button class="primary-btn-small-input" type="button">
            <label class="j-td-btn" for="client_image_one">{{ ___('label.browse') }}</label>
            <input type="file" class="d-none form-control" name="client_image_one" value="client_image_one" id="client_image_one" accept="image/jpeg, image/jpg, image/png, image/webp">
        </button>
    </div>
</div>
<div class="col-md-6">
    <label class="label-style-1">{{ ___('label.client_image_two') }} <span class="fillable"></span></label>

    <div class="ot_fileUploader left-side mb-3">

        @php
           $client_image_two = App\Models\Backend\Upload::find($section['client_image_two']);
        @endphp

        <img src="{{ getImage($client_image_two,'original') }}" alt=" " class="rounded">
        <input class="form-control input-style-1 placeholder" type="text" placeholder="{{ ___('placeholder.attach_file') }}" readonly>
        <button class="primary-btn-small-input" type="button">
            <label class="j-td-btn" for="client_image_two">{{ ___('label.browse') }}</label>
            <input type="file" class="d-none form-control" name="client_image_two" value="client_image_two" id="client_image_two" accept="image/jpeg, image/jpg, image/png, image/webp">
        </button>
    </div>
</div>
<div class="col-md-6">
    <label class="label-style-1">{{ ___('label.client_image_three') }} <span class="fillable"></span></label>

    <div class="ot_fileUploader left-side mb-3">

        @php
          $client_image_three = App\Models\Backend\Upload::find($section['client_image_three']);
        @endphp

        <img src="{{ getImage($client_image_three,'original') }}" alt=" " class="rounded">
        <input class="form-control input-style-1 placeholder" type="text" placeholder="{{ ___('placeholder.attach_file') }}" readonly>
        <button class="primary-btn-small-input" type="button">
            <label class="j-td-btn" for="client_image_three">{{ ___('label.browse') }}</label>
            <input type="file" class="d-none form-control" name="client_image_three" value="client_image_three" id="client_image_three" accept="image/jpeg, image/jpg, image/png, image/webp">
        </button>
    </div>
</div>
