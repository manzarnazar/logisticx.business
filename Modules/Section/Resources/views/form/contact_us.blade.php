
<div class="form-group col-lg-6">
    <label class=" label-style-1" for="title">{{ ___('label.title') }}</label>
    <textarea class="form-control input-style-1 summernote-2" name="title" id="title" placeholder="{{ ___("placeholder.enter_title")}}">{{ @$section['title'] }}</textarea>
    <input type="hidden" class="form-control input-style-1" name="name[]" value="title">
</div>


<div class="form-group col-lg-6 ">
    <label class="label-style-1">{{ ___('label.address') }} </label>
    <input type="text" class="form-control input-style-1" name="address" value="{{ @$section['address'] }}" required>
    <input type="hidden" class="form-control input-style-1" name="name[]" value="address">
</div>

<div class="form-group col-lg-6 ">
    <label class="label-style-1">{{ ___('label.phone') }} </label>
    <input type="text" class="form-control input-style-1" name="phone" value="{{ @$section['phone'] }}" required>
    <input type="hidden" class="form-control input-style-1" name="name[]" value="phone">
</div>

<div class="form-group col-lg-6 ">
    <label class="label-style-1">{{ ___('label.email') }} </label>
    <input type="email" class="form-control input-style-1" name="email" value="{{ @$section['email'] }}" required>
    <input type="hidden" class="form-control input-style-1" name="name[]" value="email">
</div>

<div class="col-md-6">
    <label class="label-style-1">{{ ___('label.right_info_image') }} <span class="fillable"></span></label>

    <div class="ot_fileUploader left-side mb-3">

        @php
        $right_info_image = App\Models\Backend\Upload::find($section['right_info_image']);
        @endphp

        <img src="{{ getImage($right_info_image,'original') }}" alt=" " class="rounded">
        <input class="form-control input-style-1 placeholder" type="text" placeholder="{{ ___('placeholder.attach_file') }}" readonly>
        <button class="primary-btn-small-input" type="button">
            <label class="j-td-btn" for="right_info_image">{{ ___('label.browse') }}</label>
            <input type="file" class="d-none form-control" name="right_info_image" value="right_info_image" id="right_info_image" accept="image/jpeg, image/jpg, image/png, image/webp">
        </button>
    </div>
</div>
<div class="col-md-6">
    <label class="label-style-1">{{ ___('label.left_info_image') }} <span class="fillable"></span></label>

    <div class="ot_fileUploader left-side mb-3">

        @php
        $left_info_image = App\Models\Backend\Upload::find($section['left_info_image']);
        @endphp

        <img src="{{ getImage($left_info_image,'original') }}" alt=" " class="rounded">
        <input class="form-control input-style-1 placeholder" type="text" placeholder="{{ ___('placeholder.attach_file') }}" readonly>
        <button class="primary-btn-small-input" type="button">
            <label class="j-td-btn" for="left_info_image">{{ ___('label.browse') }}</label>
            <input type="file" class="d-none form-control" name="left_info_image" value="left_info_image" id="left_info_image" accept="image/jpeg, image/jpg, image/png, image/webp">
        </button>
    </div>
</div>
<div class="col-md-6">
    <label class="label-style-1">{{ ___('label.Breadcrumb_image') }} <span class="fillable"></span></label>

    <div class="ot_fileUploader left-side mb-3">

        @php
        $Breadcrumb_image = App\Models\Backend\Upload::find($section['Breadcrumb_image']);
        @endphp

        <img src="{{ getImage($Breadcrumb_image,'original') }}" alt=" " class="rounded">
        <input class="form-control input-style-1 placeholder" type="text" placeholder="{{ ___('placeholder.attach_file') }}" readonly>
        <button class="primary-btn-small-input" type="button">
            <label class="j-td-btn" for="Breadcrumb_image">{{ ___('label.browse') }}</label>
            <input type="file" class="d-none form-control" name="Breadcrumb_image" value="Breadcrumb_image" id="Breadcrumb_image" accept="image/jpeg, image/jpg, image/png, image/webp">
        </button>
    </div>
</div>


<div class="form-group col-lg-6 ">
    <label class="label-style-1">{{ ___('label.website') }} </label>
    <input type="text" class="form-control input-style-1" name="website" value="{{ @$section['website'] }}" required>
    <input type="hidden" class="form-control input-style-1" name="name[]" value="website">
</div>

<div class="form-group col-lg-6 ">
    <label class="label-style-1">{{ ___('label.map') }} </label>
    <input type="text" class="form-control input-style-1" name="map" value="{{ @$section['map'] }}" required>
    <input type="hidden" class="form-control input-style-1" name="name[]" value="map">
</div>
