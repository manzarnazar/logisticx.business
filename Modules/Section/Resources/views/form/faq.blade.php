<div class="form-group col-lg-6">
    <label class=" label-style-1" for="title">{{ ___('label.title') }}</label>
    <textarea class="form-control input-style-1 summernote-2" name="title" id="title" placeholder="{{ ___("placeholder.enter_title")}}">{{ @$section['title'] }}</textarea>
    <input type="hidden" class="form-control input-style-1" name="name[]" value="title">
</div>

<div class="col-md-6">
    <label class="label-style-1">{{ ___('label.image') }} <span class="fillable"></span></label>

    <div class="ot_fileUploader left-side mb-3">
        <input class="form-control input-style-1 placeholder" type="text" placeholder="{{ ___('placeholder.attach_file') }}" readonly>
        <button class="primary-btn-small-input" type="button">
            <label class="j-td-btn" for="fileBrouse">{{ ___('label.browse') }}</label>
            <input type="file" class="d-none form-control" name="faq_image" value="faq_image" id="fileBrouse" accept="image/jpeg, image/jpg, image/png, image/webp">
        </button>
    </div>
    @error('faq_image') <small class="text-danger mt-2">{{ $message }}</small> @enderror
    <input type="hidden" class="form-control input-style-1" name="name[]" value="faq_image">
</div>

<div class="form-group col-lg-6 ">
    <label class="label-style-1">{{ ___('label.description') }} </label>
    <textarea class="form-control input-style-1" name="description" rows="6">{{ @$section['description'] }}</textarea>
    {{-- <input type="text" class="form-control input-style-1" name="description" value="{{ @$section['description'] }}" required> --}}
    <input type="hidden" class="form-control input-style-1" name="name[]" value="description">
</div>

