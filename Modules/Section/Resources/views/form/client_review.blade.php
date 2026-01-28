<div class="form-group col-lg-6">
    <label class=" label-style-1" for="title">{{ ___('label.title') }}</label>
    <textarea class="form-control input-style-1 summernote-2" name="title" id="title" placeholder="{{ ___("placeholder.enter_title")}}">{{ @$section['title'] }}</textarea>
    <input type="hidden" class="form-control input-style-1" name="name[]" value="title">
</div>

<div class="form-group col-lg-6 ">
    <label class="label-style-1">{{ ___('label.description') }} </label>
    <textarea class="form-control input-style-1" name="description" rows="6">{{ @$section['description'] }}</textarea>
    {{-- <input type="text" class="form-control input-style-1" name="description" value="{{ @$section['description'] }}" required> --}}
    <input type="hidden" class="form-control input-style-1" name="name[]" value="description">
</div>
