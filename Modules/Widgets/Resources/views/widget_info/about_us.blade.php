
<div class="col-lg-6 {{ widgetArray()["about_us"] }}  ">
    <div class="form-group ">
        <label>{{ ___('title') }} <span class="text-danger">*</span></label>
        <input type="text" placeholder="{{ ___('enter_title') }}"
            class="form-control" name="title" value="{{ old('title',$widget->value['title']?? '') }}" >
        @error('title')
            <p class="pt-2 text-danger">{{ $message }}</p>
        @enderror
    </div>
</div>

{{-- (type,title,position,status) --}}
