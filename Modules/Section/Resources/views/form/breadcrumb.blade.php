<div class="col-md-6">
    <label class="label-style-1">{{ ___('label.image') }} <span class="fillable"></span></label>

    <div class="ot_fileUploader left-side mb-3">
        <input class="form-control input-style-1 placeholder" type="text" placeholder="{{ ___('placeholder.attach_file') }}" readonly>
        <button class="primary-btn-small-input" type="button">
            <label class="j-td-btn" for="fileBrouse">{{ ___('label.browse') }}</label>
            <input type="file" class="d-none form-control" name="breadcrumb-image" value="breadcrumb-image" id="fileBrouse" accept="image/jpeg, image/jpg, image/png, image/webp">
        </button>
    </div>
</div>

<div class="form-group col-lg-6">
    <label class="label-style-1">{{ ___('label.aboutus-title') }} </label>
    <input type="text" class="form-control input-style-1" name="aboutus-title" value="{{ @$section['aboutus-title'] }}" required>
    <input type="hidden" class="form-control input-style-1" name="name[]" value="aboutus-title">
</div>

<div class="form-group  col-lg-6 ">
    <label class="label-style-1">{{ ___('label.blog-title') }} </label>
    <input type="text" class="form-control input-style-1" name="blog-title" value="{{ @$section['blog-title'] }}" required>
    <input type="hidden" class="form-control input-style-1" name="name[]" value="blog-title">
</div>

<div class="form-group  col-lg-6 ">
    <label class="label-style-1">{{ ___('label.blog-single-title') }} </label>
    <input type="text" class="form-control input-style-1" name="blog-single-title" value="{{ @$section['blog-single-title'] }}" required>
    <input type="hidden" class="form-control input-style-1" name="name[]" value="blog-single-title">
</div>

<div class="form-group  col-lg-6 ">
    <label class="label-style-1">{{ ___('label.contactus-title') }} </label>
    <input type="text" class="form-control input-style-1" name="contactus-title" value="{{ @$section['contactus-title'] }}" required>
    <input type="hidden" class="form-control input-style-1" name="name[]" value="contactus-title">
</div>

<div class="form-group  col-lg-6 ">
    <label class="label-style-1">{{ ___('label.privacy-return-title') }} </label>
    <input type="text" class="form-control input-style-1" name="privacy-return-title" value="{{ @$section['privacy-return-title'] }}" required>
    <input type="hidden" class="form-control input-style-1" name="name[]" value="privacy-return-title">
</div>

<div class="form-group  col-lg-6 ">
    <label class="label-style-1">{{ ___('label.terms-conditions-title') }} </label>
    <input type="text" class="form-control input-style-1" name="terms-conditions-title" value="{{ @$section['terms-conditions-title'] }}" required>
    <input type="hidden" class="form-control input-style-1" name="name[]" value="terms-conditions-title">
</div>

<div class="form-group  col-lg-6 ">
    <label class="label-style-1">{{ ___('label.signin-title') }} </label>
    <input type="text" class="form-control input-style-1" name="signin-title" value="{{ @$section['signin-title'] }}" required>
    <input type="hidden" class="form-control input-style-1" name="name[]" value="signin-title">
</div>

<div class="form-group  col-lg-6 ">
    <label class="label-style-1">{{ ___('label.signup-title') }} </label>
    <input type="text" class="form-control input-style-1" name="signup-title" value="{{ @$section['signup-title'] }}" required>
    <input type="hidden" class="form-control input-style-1" name="name[]" value="signup-title">
</div>

<div class="form-group  col-lg-6 ">
    <label class="label-style-1">{{ ___('label.track-title') }} </label>
    <input type="text" class="form-control input-style-1" name="track-title" value="{{ @$section['track-title'] }}" required>
    <input type="hidden" class="form-control input-style-1" name="name[]" value="track-title">
</div>
