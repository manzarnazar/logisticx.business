
<div class="col-lg-6 {{ widgetArray()["our_service"] }}  ">
    <div class="form-group ">
        <label>{{ ___('title') }} <span class="text-danger">*</span></label>
        <input type="text" placeholder="{{ ___('enter_title') }}"
            class="form-control" name="title" value="{{ old('title',$widget->value['title']?? '') }}" >
        @error('title')
            <p class="pt-2 text-danger">{{ $message }}</p>
        @enderror
    </div>
</div>

<div class="col-lg-6  {{ widgetArray()["our_service"] }}  ">
    <div class="form-group ">
        <label>{{ ___('description') }} <span class="text-danger">*</span></label>
            <textarea name="description" class="form-control" rows="10">{{ old('description',$widget->value['description']?? '') }}</textarea>
        @error('description')
            <p class="pt-2 text-danger">{{ $message }}</p>
        @enderror
    </div>
</div>
{{-- (type,title,description,position,status) --}}
