

<div class="form-group col-lg-6">
    <label class=" label-style-1" for="section_tagline">{{ ___('label.section_tagline') }}</label>
    <textarea class="form-control input-style-1 summernote-2" name="section_tagline" id="section_tagline" placeholder="{{ ___("placeholder.enter_section_tagline")}}">{{ @$section['section_tagline'] }}</textarea>
    <input type="hidden" class="form-control input-style-1" name="name[]" value="section_tagline">
</div>

<div class="form-group col-lg-6">
    <label class=" label-style-1" for="section_main_title">{{ ___('label.section_main_title') }}</label>
    <textarea class="form-control input-style-1 summernote-2" name="section_main_title" id="section_main_title" placeholder="{{ ___("placeholder.enter_section_main_title")}}">{{ @$section['section_main_title'] }}</textarea>
    <input type="hidden" class="form-control input-style-1" name="name[]" value="section_main_title">
</div>
