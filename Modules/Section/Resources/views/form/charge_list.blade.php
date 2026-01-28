<div class="form-group col-lg-6">
    <label class=" label-style-1" for="title">{{ ___('label.title') }}</label>
    <textarea class="form-control input-style-1 summernote-2" name="title" id="title" placeholder="{{ ___("placeholder.enter_title")}}">{{ @$section['title'] }}</textarea>
    <input type="hidden" class="form-control input-style-1" name="name[]" value="title">
</div>

<div class="form-group col-lg-6 ">
    <label>{{ ___('label.short_description') }} </label>
    <input type="text" class="form-control input-style-1" name="short_description" value="{{ @$section['short_description'] }}">
    <input type="hidden" class="form-control input-style-1" name="name[]" value="short_description">
</div>


<div class="form-group">
    <label class="label-style-1">{{ ___('label.description') }} </label>
    <textarea class="form-control input-style-1" name="description" rows="6">{{ @$section['description'] }}</textarea>
    <input type="hidden" class="form-control input-style-1" name="name[]" value="description">
</div>

