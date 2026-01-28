<div class="col-lg-12">
    <div class="row">

        <div class="form-group col-md-6">
            <label class="label-style-1 ">{{ ___('label.short_title') }} </label>
            <input type="text" class="form-control input-style-1 col-md-12" name="short_title" value="{{ @$section['short_title'] }}" required>
            <input type="hidden" class="form-control input-style-1" name="name[]" value="short_title">
        </div>

        <div class="form-group col-md-6">
            <label class="label-style-1 ">{{ ___('label.title') }} </label>
            <input type="text" class="form-control input-style-1 col-md-12" name="title" value="{{ @$section['title'] }}" required>
            <input type="hidden" class="form-control input-style-1" name="name[]" value="title">
        </div>

        <div class="form-group col-md-6">
            <label class="label-style-1 ">{{ ___('label.our_achievement') }} </label>
            <input type="text" class="form-control input-style-1 col-md-12" name="our_achievement" value="{{ @$section['our_achievement'] }}" required>
            <input type="hidden" class="form-control input-style-1" name="name[]" value="our_achievement">
        </div>

        <!-- Image-One -->
        <div class="form-group col-md-6 ">
            <label class="label-style-1">{{ ___('label.image_one') }} <span class="fillable"></span></label>

            <div class="ot_fileUploader left-side mb-3">
                @php
                $upload = App\Models\Backend\Upload::find($section['image_one']);
                @endphp

                <img src="{{ getImage($upload,'original') }}" alt=" " class="rounded">

                <input class="form-control input-style-1 placeholder" type="text" placeholder="{{ ___('placeholder.attach_file') }}" readonly>
                <button class="primary-btn-small-input" type="button">
                    <label class="j-td-btn" for="image_one">{{ ___('label.browse') }}</label>
                    <input type="file" class="d-none form-control" name="image_one" value="image_one" id="image_one" accept="image/jpeg, image/jpg, image/png, image/png, image/webp">
                </button>
            </div>
            @error('image_one') <small class="text-danger mt-2">{{ $message }}</small> @enderror
            <input type="hidden" class="form-control input-style-1" name="name[]" value="image_one">
        </div>

        <!-- Image-Two -->
        <div class="form-group col-md-6 ">
            <label class="label-style-1">{{ ___('label.image_two') }} <span class="fillable"></span></label>

            <div class="ot_fileUploader left-side mb-3">
                @php
                $upload = App\Models\Backend\Upload::find($section['image_two']);
                @endphp

                <img src="{{ getImage($upload,'original') }}" alt=" " class="rounded">

                <input class="form-control input-style-1 placeholder" type="text" placeholder="{{ ___('placeholder.attach_file') }}" readonly>
                <button class="primary-btn-small-input" type="button">
                    <label class="j-td-btn" for="image_two">{{ ___('label.browse') }}</label>
                    <input type="file" class="d-none form-control" name="image_two" value="image_two" id="image_two" accept="image/jpeg, image/jpg, image/png, image/png, image/webp">
                </button>
            </div>
            @error('image_two') <small class="text-danger mt-2">{{ $message }}</small> @enderror
            <input type="hidden" class="form-control input-style-1" name="name[]" value="image_two">
        </div>
    </div>
</div>


<div class="col-12">
    <div class="row">
        <div class="form-group col-md-6">
            <label class="label-style-1 ">{{ ___('label.year_experience_title') }} </label>
            <input type="text" class="form-control input-style-1 col-md-12" name="year_experience_title" value="{{ @$section['year_experience_title'] }}" required>
            <input type="hidden" class="form-control input-style-1" name="name[]" value="year_experience_title">
        </div>

        <div class="form-group col-md-6">
            <label class="label-style-1 ">{{ ___('label.year_experience_number') }} </label>
            <input type="text" class="form-control input-style-1 col-md-12" name="year_experience_number" value="{{ @$section['year_experience_number'] }}" required>
            <input type="hidden" class="form-control input-style-1" name="name[]" value="year_experience_number">
        </div>
    </div>
</div>

<div class="col-12">
    <div class="row">
        <div class="form-group col-md-6">
            <label class="label-style-1 ">{{ ___('label.card_one_title') }} </label>
            <input type="text" class="form-control input-style-1 col-md-12" name="card_one_title" value="{{ @$section['card_one_title'] }}" required>
            <input type="hidden" class="form-control input-style-1" name="name[]" value="card_one_title">
        </div>
        
        <div class="form-group col-md-6">
            <label class="label-style-1 ">{{ ___('label.card_two_title') }} </label>
            <input type="text" class="form-control input-style-1 col-md-12" name="card_two_title" value="{{ @$section['card_two_title'] }}" required>
            <input type="hidden" class="form-control input-style-1" name="name[]" value="card_two_title">
        </div>
        
        <div class="form-group col-md-6">
            <label class="label-style-1 ">{{ ___('label.card_three_title') }} </label>
            <input type="text" class="form-control input-style-1 col-md-12" name="card_three_title" value="{{ @$section['card_three_title'] }}" required>
            <input type="hidden" class="form-control input-style-1" name="name[]" value="card_three_title">
        </div>
        
        <div class="form-group col-md-6">
            <label class="label-style-1 ">{{ ___('label.card_four_title') }} </label>
            <input type="text" class="form-control input-style-1 col-md-12" name="card_four_title" value="{{ @$section['card_four_title'] }}" required>
            <input type="hidden" class="form-control input-style-1" name="name[]" value="card_four_title">
        </div>
        
        <div class="form-group col-md-6">
            <label class="label-style-1">{{ ___('label.style_two_big_image') }} <span class="fillable"></span></label>

            <div class="ot_fileUploader left-side mb-3">
                @php
                $upload = App\Models\Backend\Upload::find($section['style_two_big_image']);
                @endphp

                <img src="{{ getImage($upload,'original') }}" alt=" " class="rounded">

                <input class="form-control input-style-1 placeholder" type="text" placeholder="{{ ___('placeholder.attach_file') }}" readonly>
                <button class="primary-btn-small-input" type="button">
                    <label class="j-td-btn" for="style_two_big_image">{{ ___('label.browse') }}</label>
                    <input type="file" class="d-none form-control" name="style_two_big_image" value="style_two_big_image" id="style_two_big_image" accept="image/jpeg, image/jpg, image/png, image/png, image/webp">
                </button>
            </div>
            @error('style_two_big_image') <small class="text-danger mt-2">{{ $message }}</small> @enderror
            <input type="hidden" class="form-control input-style-1" name="name[]" value="style_two_big_image">
        </div>

        <div class="form-group col-md-6">
            <label class="label-style-1">{{ ___('label.style_two_small_image') }} <span class="fillable"></span></label>

            <div class="ot_fileUploader left-side mb-3">  
                @php
                $upload = App\Models\Backend\Upload::find($section['style_two_small_image']);
                @endphp

                <img src="{{ getImage($upload,'original') }}" alt=" " class="rounded">

                <input class="form-control input-style-1 placeholder" type="text" placeholder="{{ ___('placeholder.attach_file') }}" readonly>
                <button class="primary-btn-small-input" type="button">
                    <label class="j-td-btn" for="style_two_small_image">{{ ___('label.browse') }}</label>
                    <input type="file" class="d-none form-control" name="style_two_small_image" value="style_two_small_image" id="style_two_small_image" accept="image/jpeg, image/jpg, image/png, image/png, image/webp">
                </button>
            </div>
            @error('style_two_small_image') <small class="text-danger mt-2">{{ $message }}</small> @enderror
            <input type="hidden" class="form-control input-style-1" name="name[]" value="style_two_small_image">
        </div>


    </div>
</div>


<!-- Counter Details  -->
<div class="col-12">

    @for ($i = 1; $i <= 2; $i++) 
        <div class="row">

            <div class="form-group col-md-4">
                <label class="label-style-1">{{ ___('label.counter') . " {$i} " .  ___('label.label') }} </label>
                <input type="text" class="form-control input-style-1" name="counter_{{$i}}_number" value="{{ @$section["counter_{$i}_number"] }}" required>
                <input type="hidden" class="form-control input-style-1" name="name[]" value="counter_{{$i}}_number">
            </div>

            <div class="form-group col-md-4">
                <label class="label-style-1">{{ ___('label.counter') . " {$i} " .  ___('label.number') }} </label>
                <input type="number" class="form-control input-style-1" name="counter_{{$i}}_number" value="{{ @$section["counter_{$i}_number"] }}" required>
                <input type="hidden" class="form-control input-style-1" name="name[]" value="counter_{{$i}}_number">
            </div>

            <div class="form-group col-md-4">
                <label class="label-style-1">{{ ___('label.counter') . " {$i} " .  ___('label.icon') }} </label>
                <div class="ot_fileUploader left-side mb-3">
                    @php
                    $upload = App\Models\Backend\Upload::find($section["counter_{$i}_image"]);
                    @endphp

                    <img src="{{ getImage($upload,'original') }}" alt=" " class="rounded">

                    <input class="form-control input-style-1 placeholder" type="text" placeholder="{{ ___('placeholder.attach_file') }}" readonly>
                    <button class="primary-btn-small-input" type="button">
                        <label class="j-td-btn" for="counter_{{$i}}_image">{{ ___('label.browse') }}</label>
                        <input type="file" class="d-none form-control" name="counter_{{$i}}_image" id="counter_{{$i}}_image" accept="image/jpeg, image/jpg, image/png, image/png, image/webp">
                    </button>
                </div>
                @error('counter_{{$i}}_image') <small class="text-danger mt-2">{{ $message }}</small> @enderror
                <input type="hidden" class="form-control input-style-1" name="name[]" value="counter_{{$i}}_image">
            </div>

        </div>
    @endfor

    <div class="row">

        <div class="form-group col-md-4">
            <label class="label-style-1 ">{{ ___('label.activity_title') }} </label>
            <input type="text" class="form-control input-style-1 col-md-12" name="activity_title" value="{{ @$section['activity_title'] }}" required>
            <input type="hidden" class="form-control input-style-1" name="name[]" value="activity_title">
        </div>

        <div class="form-group col-md-4">
            <label class="label-style-1 ">{{ ___('label.activity_number') }} </label>
            <input type="text" class="form-control input-style-1 col-md-12" name="activity_number" value="{{ @$section['activity_number'] }}" required>
            <input type="hidden" class="form-control input-style-1" name="name[]" value="activity_number">
        </div>

        <div class="form-group col-md-4 ">
            <label class="label-style-1">{{ ___('label.activity_icon_image') }} <span class="fillable"></span></label>

            <div class="ot_fileUploader left-side mb-3">
                @php
                $upload = App\Models\Backend\Upload::find($section['activity_icon_image']);
                @endphp

                <img src="{{ getImage($upload,'original') }}" alt=" " class="rounded">

                <input class="form-control input-style-1 placeholder" type="text" placeholder="{{ ___('placeholder.attach_file') }}" readonly>
                <button class="primary-btn-small-input" type="button">
                    <label class="j-td-btn" for="activity_icon_image">{{ ___('label.browse') }}</label>
                    <input type="file" class="d-none form-control" name="activity_icon_image" value="activity_icon_image" id="activity_icon_image" accept="image/jpeg, image/jpg, image/png, image/png, image/webp">
                </button>
            </div>
            @error('activity_icon_image') <small class="text-danger mt-2">{{ $message }}</small> @enderror
            <input type="hidden" class="form-control input-style-1" name="name[]" value="activity_icon_image">
        </div>

    </div>

    <div class="form-group col-md-12">
        <label class="label-style-1">{{ ___('label.achievement_list') }} </label>
        <textarea class="form-control input-style-1" name="achievement_list" rows="5" required>{{ $section['achievement_list'] }}</textarea>
        <input type="hidden" class="form-control input-style-1" name="name[]" value="achievement_list">
    </div>
    
</div>
