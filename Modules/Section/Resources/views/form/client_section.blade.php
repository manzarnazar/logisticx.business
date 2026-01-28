<div class="form-group col-lg-6">
    <label class=" label-style-1" for="title">{{ ___('label.title') }}</label>
    <textarea class="form-control input-style-1 summernote-2" name="title" id="title" placeholder="{{ ___("placeholder.enter_title")}}">{{ @$section['title'] }}</textarea>
    <input type="hidden" class="form-control input-style-1" name="name[]" value="title">
</div>
<div class="form-group col-lg-6 ">
    <label>{{ ___('label.short_title') }} </label>
    <input type="text" class="form-control input-style-1" name="short_title" value="{{ @$section['short_title'] }}">
    <input type="hidden" class="form-control input-style-1" name="name[]" value="short_title">
</div>

<div class="form-group col-lg-6 ">
    <label>{{ ___('label.short_description') }} </label>
    <textarea class="form-control input-style-1" name="short_description" rows="6">{{ @$section['short_description'] }}</textarea>
    <input type="hidden" class="form-control input-style-1" name="name[]" value="short_description">
</div>
