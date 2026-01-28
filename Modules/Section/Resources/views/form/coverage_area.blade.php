<div class="form-group col-lg-6 ">
    <label class="label-style-1">{{ ___('label.short_title') }} </label>
    <input type="text" class="form-control input-style-1" name="short_title" value="{{ @$section['short_title'] }}" required>
    <input type="hidden" class="form-control input-style-1" name="name[]" value="short_title">
</div>

<div class="form-group col-md-6 ">
    <label class="label-style-1">{{ ___('label.bg_image') }} <span class="fillable"></span></label>

    <div class="ot_fileUploader left-side mb-3">
        @php
        $upload = App\Models\Backend\Upload::find($section['bg_image']);
        @endphp

        <img src="{{ getImage($upload,'original') }}" alt=" " class="rounded">

        <input class="form-control input-style-1 placeholder" type="text" placeholder="{{ ___('placeholder.attach_file') }}" readonly>
        <button class="primary-btn-small-input" type="button">
            <label class="j-td-btn" for="bg_image">{{ ___('label.browse') }}</label>
            <input type="file" class="d-none form-control" name="bg_image" value="bg_image" id="bg_image" accept="image/jpeg, image/jpg, image/png, image/png, image/webp">
        </button>
    </div>
    @error('bg_image') <small class="text-danger mt-2">{{ $message }}</small> @enderror
    <input type="hidden" class="form-control input-style-1" name="name[]" value="bg_image">
</div>

<div class="form-group col-lg-6">
    <label class=" label-style-1" for="title">{{ ___('label.title') }}</label>
    <textarea class="form-control input-style-1 summernote-2" name="title"  placeholder="{{ ___("placeholder.enter_title")}}">{{ @$section['title'] }}</textarea>
    <input type="hidden" class="form-control input-style-1" name="name[]" value="title">
</div>

<div class="form-group col-lg-6 ">
    <label class="label-style-1">{{ ___('label.short_description') }} </label>
    <textarea class="form-control input-style-1" name="short_description" rows="4">{{ @$section['short_description'] }}</textarea>
    <input type="hidden" class="form-control input-style-1" name="name[]" value="short_description">
</div>

<div class="form-group col-md-6 ">
    <label class="label-style-1">{{ ___('label.big_bg_image') }} <span class="fillable"></span></label>

    <div class="ot_fileUploader left-side mb-3">
        @php
        $upload = App\Models\Backend\Upload::find($section['big_bg_image']);
        @endphp

        <img src="{{ getImage($upload,'original') }}" alt=" " class="rounded">

        <input class="form-control input-style-1 placeholder" type="text" placeholder="{{ ___('placeholder.attach_file') }}" readonly>
        <button class="primary-btn-small-input" type="button">
            <label class="j-td-btn" for="big_bg_image">{{ ___('label.browse') }}</label>
            <input type="file" class="d-none form-control" name="big_bg_image" value="big_bg_image" id="big_bg_image" accept="image/jpeg, image/jpg, image/png, image/png, image/webp">
        </button>
    </div>
    @error('big_bg_image') <small class="text-danger mt-2">{{ $message }}</small> @enderror
    <input type="hidden" class="form-control input-style-1" name="name[]" value="big_bg_image">
</div>

<div class="form-group col-lg-6 ">
    <label class="label-style-1">{{ ___('label.coverage_list_title') }} </label>
    <input type="text" class="form-control input-style-1" name="coverage_list_title" value="{{ @$section['coverage_list_title'] }}" required>
    <input type="hidden" class="form-control input-style-1" name="name[]" value="coverage_list_title">
</div>

{{-- Card One --}}
<div class="form-group col-lg-6 ">
    <label class="label-style-1">{{ ___('label.card_title_one') }} </label>
    <input type="text" class="form-control input-style-1" name="card_title_one" value="{{ @$section['card_title_one'] }}" required>
    <input type="hidden" class="form-control input-style-1" name="name[]" value="card_title_one">
</div>

<div class="form-group col-md-6 ">
    <label class="label-style-1">{{ ___('label.card_one_img') }} <span class="fillable"></span></label>

    <div class="ot_fileUploader left-side mb-3">
        @php
        $upload = App\Models\Backend\Upload::find($section['card_one_image']);
        @endphp

        <img src="{{ getImage($upload,'original') }}" alt=" " class="rounded">

        <input class="form-control input-style-1 placeholder" type="text" placeholder="{{ ___('placeholder.attach_file') }}" readonly>
        <button class="primary-btn-small-input" type="button">
            <label class="j-td-btn" for="card_one_image">{{ ___('label.browse') }}</label>
            <input type="file" class="d-none form-control" name="card_one_image" value="card_one_image" id="card_one_image" accept="image/jpeg, image/jpg, image/png, image/png, image/webp">
        </button>
    </div>
    @error('card_one_image') <small class="text-danger mt-2">{{ $message }}</small> @enderror
    <input type="hidden" class="form-control input-style-1" name="name[]" value="card_one_image">
</div>

<div class="form-group col-lg-6 ">
    <label class="label-style-1">{{ ___('label.card_one_description') }} </label>
    <textarea class="form-control input-style-1" name="card_one_description" rows="4">{{ @$section['card_one_description'] }}</textarea>
    <input type="hidden" class="form-control input-style-1" name="name[]" value="card_one_description">
</div>


<div class="form-group col-lg-5"></div>

{{-- Card two --}}
<div class="form-group col-lg-6 ">
    <label class="label-style-1">{{ ___('label.card_title_two') }} </label>
    <input type="text" class="form-control input-style-1" name="card_title_two" value="{{ @$section['card_title_two'] }}" required>
    <input type="hidden" class="form-control input-style-1" name="name[]" value="card_title_two">
</div>

<div class="form-group col-md-6 ">
    <label class="label-style-1">{{ ___('label.card_two_img') }} <span class="fillable"></span></label>

    <div class="ot_fileUploader left-side mb-3">
        @php
        $upload = App\Models\Backend\Upload::find($section['card_two_image']);
        @endphp

        <img src="{{ getImage($upload,'original') }}" alt=" " class="rounded">

        <input class="form-control input-style-1 placeholder" type="text" placeholder="{{ ___('placeholder.attach_file') }}" readonly>
        <button class="primary-btn-small-input" type="button">
            <label class="j-td-btn" for="card_two_image">{{ ___('label.browse') }}</label>
            <input type="file" class="d-none form-control" name="card_two_image" value="card_two_image" id="card_two_image" accept="image/jpeg, image/jpg, image/png, image/png, image/webp">
        </button>
    </div>
    @error('card_two_image') <small class="text-danger mt-2">{{ $message }}</small> @enderror
    <input type="hidden" class="form-control input-style-1" name="name[]" value="card_two_image">
</div>

<div class="form-group col-lg-6 ">
    <label class="label-style-1">{{ ___('label.card_two_description') }} </label>
    <textarea class="form-control input-style-1" name="card_two_description" rows="4">{{ @$section['card_two_description'] }}</textarea>
    <input type="hidden" class="form-control input-style-1" name="name[]" value="card_two_description">
</div>


<div class="form-group col-lg-5"></div>

{{-- Card three --}}
<div class="form-group col-lg-6 ">
    <label class="label-style-1">{{ ___('label.card_title_three') }} </label>
    <input type="text" class="form-control input-style-1" name="card_title_three" value="{{ @$section['card_title_three'] }}" required>
    <input type="hidden" class="form-control input-style-1" name="name[]" value="card_title_three">
</div>

<div class="form-group col-md-6 ">
    <label class="label-style-1">{{ ___('label.card_three_img') }} <span class="fillable"></span></label>

    <div class="ot_fileUploader left-side mb-3">
        @php
        $upload = App\Models\Backend\Upload::find($section['card_three_image']);
        @endphp

        <img src="{{ getImage($upload,'original') }}" alt=" " class="rounded">

        <input class="form-control input-style-1 placeholder" type="text" placeholder="{{ ___('placeholder.attach_file') }}" readonly>
        <button class="primary-btn-small-input" type="button">
            <label class="j-td-btn" for="card_three_image">{{ ___('label.browse') }}</label>
            <input type="file" class="d-none form-control" name="card_three_image" value="card_three_image" id="card_three_image" accept="image/jpeg, image/jpg, image/png, image/png, image/webp">
        </button>
    </div>
    @error('card_three_image') <small class="text-danger mt-2">{{ $message }}</small> @enderror
    <input type="hidden" class="form-control input-style-1" name="name[]" value="card_three_image">
</div>



<div class="form-group col-lg-6 ">
    <label class="label-style-1">{{ ___('label.card_three_description') }} </label>
    <textarea class="form-control input-style-1" name="card_three_description" rows="4">{{ @$section['card_three_description'] }}</textarea>
    <input type="hidden" class="form-control input-style-1" name="name[]" value="card_three_description">
</div>


<div class="form-group col-lg-5"></div>

{{-- Card four --}}
<div class="form-group col-lg-6 ">
    <label class="label-style-1">{{ ___('label.card_title_four') }} </label>
    <input type="text" class="form-control input-style-1" name="card_title_four" value="{{ @$section['card_title_four'] }}" required>
    <input type="hidden" class="form-control input-style-1" name="name[]" value="card_title_four">
</div>

<div class="form-group col-md-6 ">
    <label class="label-style-1">{{ ___('label.card_four_img') }} <span class="fillable"></span></label>

    <div class="ot_fileUploader left-side mb-3">
        @php
        $upload = App\Models\Backend\Upload::find($section['card_four_image']);
        @endphp

        <img src="{{ getImage($upload,'original') }}" alt=" " class="rounded">

        <input class="form-control input-style-1 placeholder" type="text" placeholder="{{ ___('placeholder.attach_file') }}" readonly>
        <button class="primary-btn-small-input" type="button">
            <label class="j-td-btn" for="card_four_image">{{ ___('label.browse') }}</label>
            <input type="file" class="d-none form-control" name="card_four_image" value="card_four_image" id="card_four_image" accept="image/jpeg, image/jpg, image/png, image/png, image/webp">
        </button>
    </div>
    @error('card_four_image') <small class="text-danger mt-2">{{ $message }}</small> @enderror
    <input type="hidden" class="form-control input-style-1" name="name[]" value="card_four_image">
</div>

<div class="form-group col-lg-6 ">
    <label class="label-style-1">{{ ___('label.card_four_description') }} </label>
    <textarea class="form-control input-style-1" name="card_four_description" rows="4">{{ @$section['card_four_description'] }}</textarea>
    <input type="hidden" class="form-control input-style-1" name="name[]" value="card_four_description">
</div>
