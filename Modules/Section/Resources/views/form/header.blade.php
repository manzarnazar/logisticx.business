<div class="col-md-6">
    <label class="label-style-1">{{ ___('label.header-logo') }} <span class="fillable"></span></label>

    <div class="ot_fileUploader left-side mb-3">
        <input class="form-control input-style-1 placeholder" type="text" placeholder="{{ ___('placeholder.attach_file') }}" readonly>
        <button class="primary-btn-small-input" type="button">
            <label class="j-td-btn" for="fileBrouse">{{ ___('label.browse') }}</label>
            <input type="file" class="d-none form-control" name="header-logo" value="header-logo" id="fileBrouse" accept="image/jpeg, image/jpg, image/png, image/png, image/webp">
        </button>
    </div>
    @error('header-logo') <small class="text-danger mt-2">{{ $message }}</small> @enderror
    <input type="hidden" class="form-control input-style-1" name="name[]" value="header-logo">
</div>

<div class="form-group col-md-6">
    <label class="label-style-1">{{ ___('label.header_top_bar') }} <span class="text-danger">*</span></label>
    <select name="header_top_bar" class="form-control input-style-1 select2">
        @foreach(config('site.status.default') as $key => $status)
        <option value="{{ $key }}" @selected(old('header_top_bar', @$section['header_top_bar'] )==$key)>{{ ___('common.'.  $status) }}</option>
        @endforeach
    </select>
    @error('header_top_bar') <p class="pt-2 text-danger">{{ $message }}</p> @enderror
    <input type="hidden" name="name[]" value="header_top_bar">
</div>

<div class="col-md-6">
    <label class="label-style-1">{{ ___('label.header-topbar-logo-1') }} <span class="fillable"></span></label>

    <div class="ot_fileUploader left-side mb-3">
        <input class="form-control input-style-1 placeholder" type="text" placeholder="{{ ___('placeholder.attach_file') }}" readonly>
        <button class="primary-btn-small-input" type="button">
            <label class="j-td-btn" for="fileBrouse1">{{ ___('label.browse') }}</label>
            <input type="file" class="d-none form-control" name="header-topbar-logo-1" value="header-topbar-logo-1" id="fileBrouse1" accept="image/jpeg, image/jpg, image/png, image/png, image/webp">
        </button>
    </div>
    @error('header-topbar-logo-1') <small class="text-danger mt-2">{{ $message }}</small> @enderror
    <input type="hidden" class="form-control input-style-1" name="name[]" value="header-topbar-logo-1">
</div>

<div class="form-group col-md-6 ">
    <label class="label-style-1">{{ ___('label.phone_number') }} </label>
    <input type="text" class="form-control input-style-1" name="phone-number" value="{{ @$section['phone-number'] }}" required>
    <input type="hidden" class="form-control input-style-1" name="name[]" value="phone-number">
</div>

<div class="col-md-6">
    <label class="label-style-1">{{ ___('label.header-topbar-logo-2') }} <span class="fillable"></span></label>

    <div class="ot_fileUploader left-side mb-3">
        <input class="form-control input-style-1 placeholder" type="text" placeholder="{{ ___('placeholder.attach_file') }}" readonly>
        <button class="primary-btn-small-input" type="button">
            <label class="j-td-btn" for="fileBrouse2">{{ ___('label.browse') }}</label>
            <input type="file" class="d-none form-control" name="header-topbar-logo-2" value="header-topbar-logo-2" id="fileBrouse2" accept="image/jpeg, image/jpg, image/png, image/PNG, image/webp">
        </button>
    </div>
    @error('header-topbar-logo-2') <small class="text-danger mt-2">{{ $message }}</small> @enderror
    <input type="hidden" class="form-control input-style-1" name="name[]" value="header-topbar-logo-2">
</div>

<div class="form-group col-md-6 ">
    <label class="label-style-1">{{ ___('label.email') }} </label>
    <input type="text" class="form-control input-style-1" name="email" value="{{ @$section['email'] }}" required>
    <input type="hidden" class="form-control input-style-1" name="name[]" value="email">
</div>
