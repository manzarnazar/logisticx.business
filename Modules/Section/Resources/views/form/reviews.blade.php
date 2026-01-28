{{-- <div class="form-group col-lg-6 ">
    <label class="label-style-1">{{ ___('label.reviews_image') }} </label>
<input type="file" class="form-control input-style-1" name="reviews_image">
<input type="hidden" class="form-control input-style-1" name="name[]" value="reviews_image">
</div> --}}

<div class="col-md-6">
    <label class="label-style-1">{{ ___('label.reviews_image') }} <span class="fillable"></span></label>

    <div class="ot_fileUploader left-side mb-3">
        <input class="form-control input-style-1 placeholder" type="text" placeholder="{{ ___('placeholder.attach_file') }}" readonly>
        <button class="primary-btn-small-input" type="button">
            <label class="j-td-btn" for="fileBrouse">{{ ___('label.browse') }}</label>
            <input type="file" class="d-none form-control" name="reviews_image" value="reviews_image" id="fileBrouse" accept="image/jpeg, image/jpg, image/png, image/webp">
        </button>
    </div>
</div>
