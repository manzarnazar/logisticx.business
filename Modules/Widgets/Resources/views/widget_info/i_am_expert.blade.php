
<div class="col-lg-6 {{ widgetArray()["i_am_expert"] }}  ">
    <div class="form-group ">
        <label>{{ ___('title') }} <span class="text-danger">*</span></label>
        <input type="text" placeholder="{{ ___('enter_title') }}"
            class="form-control" name="title" value="{{ old('title',$widget->value['title']?? '') }}" >
        @error('title')
            <p class="pt-2 text-danger">{{ $message }}</p>
        @enderror
    </div>
</div>


<div class="col-lg-6 {{ widgetArray()["i_am_expert"] }}">
    <div class="form-group ">
        <label>{{ ___('image') }} <span class="text-danger">*</span></label>
        <input type="file" placeholder="{{ ___('image') }}"
            class="form-control" name="image" value="{{ old('image',$widget->value['image']?? '') }}"  >
        @error('image')
            <p class="pt-2 text-danger">{{ $message }}</p>
        @enderror
    </div>
</div>

<div class="col-lg-6  {{ widgetArray()["i_am_expert"] }} ">
    <div class="form-group ">
        <label>{{ ___('description') }} <span class="text-danger">*</span></label>
            <textarea name="description" class="form-control" rows="10">{{ old('description',$widget->value['description']?? '') }}</textarea>
        @error('description')
            <p class="pt-2 text-danger">{{ $message }}</p>
        @enderror
    </div>
</div>
{{-- (type,title,description,position,status) --}}
