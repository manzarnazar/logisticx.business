{{-- popups_content --}}

<div class="form-group col-md-6">
    <label class="label-style-1">{{ ___('label.cookie_concent') }} </label>
    <textarea class="form-control input-style-1 summernote" name="cookie_concent" rows="6">{{ @$section['cookie_concent'] }}</textarea>
    <input type="hidden" class="form-control input-style-1" name="name[]" value="cookie_concent">
</div>
