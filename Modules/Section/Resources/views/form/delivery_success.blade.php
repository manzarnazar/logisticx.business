
<div class="form-group col-lg-6">
    <label class=" label-style-1" for="hero_section_title">{{ ___('label.title') }}</label>
    <textarea class="form-control input-style-1 summernote-2" name="title"  placeholder="{{ ___("placeholder.enter_title")}}">{{ @$section['title'] }}</textarea>
    <input type="hidden" class="form-control input-style-1" name="name[]" value="title">
</div>

<div class="form-group col-lg-6 ">
    <label class="label-style-1">{{ ___('label.short_description') }} </label>
    <input type="text" class="form-control input-style-1" name="short_title" value="{{ @$section['short_title'] }}" required>
    <input type="hidden" class="form-control input-style-1" name="name[]" value="short_title">
</div>

<div class="form-group col-lg-6 ">
    <label class="label-style-1">{{ ___('label.short_description') }} </label>
    <input type="text" class="form-control input-style-1" name="short_description" value="{{ @$section['short_description'] }}" required>
    <input type="hidden" class="form-control input-style-1" name="name[]" value="short_description">
</div>


