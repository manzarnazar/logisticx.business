{{-- <div class="delivery-area bg-thm-1 d-none {{ implode(' ', $widget->section_padding) }}" @if($widget->background === 'bg_color') data-background-color="{{ $widget->bg_color }}"
    @elseif($widget->background === 'bg_image') data-background="{{ getImage($widget->upload) }}"
    @endif>

    <div class="container">
        <div class="row  @if (request()->is('charges')) d-none @endif">
            <div class="col-xl-12">
                <div class="site-title text-center mb-50">
                    <h2>{!! customSection(\Modules\Section\Enums\Type::DELIVERY_CALCULATOR, 'title') !!}</h2>
                </div>
            </div>
        </div>
        <div class="delivery-wpr grid-2">
            <div class="delivery-left element-center pr-70">
                <div class="section-title">
                    <p class="border-start ps-3 border-3 border-primary text-left lh-1 mb-4 fs-3 text-dark fw-semibold d-inline-block"> Calculator</p>
                    <h2 class="hero-title-3"> </h2>
                    <p class="mb-0"> </p>
                </div>
            </div>
            <div class="delivery-right">
                <div class="requ-contact delivery-requ requ-contact-white">
                    <h5 class=" mb-40"> {{ ___('frontend.quick_booking') }} </h5>
                    <form class="contact-form-requ">
                        @csrf

                        <input type="hidden" id="area" name="area" data-url="{{ route('coverage.detectArea') }}" />

                        <div class="row g-3">

                            <div class="col-md-6 pickup_area">
                                <label for="pickup_area" class="input-label">{{ ___('label.pickup_area') }}</label>
                                <select name="pickup_area" id="pickup_area" class="form-control input-style-2 form-select">
                                    <option value="" @selected(true) @disabled(true)> {{ ___('label.pickup_area') }}</option>

                                    @foreach ($coverages as $coverage)
                                    <option value="{{ $coverage->id }}" @selected(old('pickup_area')==$coverage->id)> {{ $coverage->name }}</option>
                                    <x-coverage-child :coverage="$coverage" name="pickup_area" />
                                    @endforeach

                                </select>
                            </div>

                            <div class="col-md-6 delivery_area">
                                <label for="delivery_area" class="input-label">{{ ___('label.delivery_area') }}</label>
                                <select name="delivery_area" id="delivery_area" class="form-control input-style-2 form-select">
                                    <option value="" @selected(true) @disabled(true)> {{ ___('label.delivery_area') }}</option>

                                    @foreach ($coverages as $coverage)
                                    <option value="{{ $coverage->id }}" @selected(old('delivery_area')==$coverage->id)> {{ $coverage->name }}</option>
                                    <x-coverage-child :coverage="$coverage" name="delivery_area" />
                                    @endforeach

                                </select>

                            </div>

                            <div class="col-md-6 product_category">
                                <label for="product_category" class="input-label">{{ ___('charges.product_category') }}</label>
                                <select id="product_category" class="form-control input-style-2 form-select" name="product_category">
                                    <option value="" @selected(true) @disabled(true)> {{ ___('charges.product_category') }}</option>

                                    @foreach ($productCategories as $category)
                                    <option value="{{ $category->product_category_id }}" @selected(old('product_category')==$category->product_category_id)>
                                        {{ $category->productCategory->name }}</option>
                                    @endforeach

                                </select>
                            </div>

                            <div class="col-md-6 service_type">
                                <label for="service_type" class="input-label">{{ ___('charges.service_type') }}</label>
                                <select id="service_type" class="form-control input-style-2 form-select" name="service_type" data-url="{{ route('parcel.serviceType') }}">
                                    <option value="" @selected(true) @disabled(true)> {{ ___('charges.service_type') }}</option>
                                </select>
                            </div>

                            <div class="col-md-12 pt-lg-5 pt-4">
                                <div class="delivery-total">
                                    <h6 id="charge" data-url="{{ route('parcel.merchant.charge') }}" data-currency="{{ settings('currency') }}"> {{ ___('frontend.total_delivery_cost') }} {{ settings('currency') }} {{ ___('frontend.00') }} </h6>
                                </div>
                            </div>

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div> --}}

<!--============ Delivery Calculator Style 1 start ============-->

<section class="dely-calculator {{ implode(' ', $widget->section_padding) }}" @if($widget->background === 'bg_color') data-background-color="{{ $widget->bg_color }}"
    @elseif($widget->background === 'bg_image') data-background="{{ getImage($widget->upload) }}"
    @endif>

    <div class="shape-1 up-move"><img src="{{ asset('frontend/assets/img/shape/contact-two-shape-3.png') }}" alt=""></div>
    <div class="shape-2 up-move"><img src="{{ asset('frontend/assets/img/shape/contact-two-shape-4.png') }}" alt=""></div>
    <div class="shape-3 d-none d-lg-block"><img src="{{ data_get(customSection(\Modules\Section\Enums\Type::DELIVERY_CALCULATOR, 'image'), 'original') }}" alt=""></div>

    <div class="container">
        <div class="row g-4">
            <div class="col-lg-6 text-light-emphasis">
                <div class="section-title mb-50">
                    <span class="text-primary section-title-tagline border-2 border-primary border-start ps-2">{{ customSection(\Modules\Section\Enums\Type::DELIVERY_CALCULATOR, 'section_tagline')}}</span>
                    <h2 class="hero-title-3">{!! customSection(\Modules\Section\Enums\Type::DELIVERY_CALCULATOR, 'section_title') !!}</h2>
                </div>
                <p class="mb-0 text-light-emphasis">{!! customSection(\Modules\Section\Enums\Type::DELIVERY_CALCULATOR, 'description') !!}</p>

                {{-- circle progress bar --}}
                <div class="circular-container d-flex align-items-center">
                    <div class="circular-progress">
                        <span class="progress-value">{{ customSection(\Modules\Section\Enums\Type::DELIVERY_CALCULATOR, 'progress_value')}}</span>
                    </div>
                    <div class="heading-5">{!! customSection(\Modules\Section\Enums\Type::DELIVERY_CALCULATOR, 'progress_title')!!}</div>
                </div>

                <div class="calculator-btn">
                    <a href="{{ customSection(\Modules\Section\Enums\Type::DELIVERY_CALCULATOR, 'button_url')}}" class="btn-1 two rounded-pill">{{ customSection(\Modules\Section\Enums\Type::DELIVERY_CALCULATOR, 'button_text')}}<i class="fa-solid fa-arrow-right"></i></a>
                </div>
            </div>

            <div class="col-lg-6 ps-lg-5">
                <div class="right-form">
                    <form action="#" method="POST" class="contact-form-requ">
                        @csrf
                        <input type="hidden" id="area" name="area" data-url="{{ route('coverage.detectArea') }}" />

                        {{-- Hidden inputs for selected values --}}
                        <input type="hidden" id="pickup_area_input" name="pickup_area" />
                        <input type="hidden" id="delivery_area_input" name="delivery_area" />
                        <input type="hidden" id="product_category_input" name="product_category" />
                        <input type="hidden" id="service_type_input" name="service_type" />

                        <span class="text-primary section-title-tagline border-2 border-primary border-start ps-2">
                            {{ customSection(\Modules\Section\Enums\Type::DELIVERY_CALCULATOR, 'calculator_tagline') }}
                        </span>
                        <h3 class="heading-3 fw-bold">
                            {{ customSection(\Modules\Section\Enums\Type::DELIVERY_CALCULATOR, 'calculator_title') }}
                        </h3>

                        <!-- Pickup Area -->
                        <div class="custom-select w-100 mb-3 pickup_area">
                            <div class="select-box">
                                <span class="selected-text">{{ ___('label.pickup_area') }}</span>
                            </div>
                            <ul class="options">
                                @foreach ($coverages as $pickup_area)
                                    <li data-id="{{ $pickup_area->id }}">{{ $pickup_area->name }}</li>
                                    <x-coverage-child-ul :coverage="$pickup_area" :depth="1" />
                                @endforeach
                            </ul>
                        </div>

                        <!-- Delivery Area -->
                        <div class="custom-select w-100 mb-3 delivery_area">
                            <div class="select-box">
                                <span class="selected-text">{{ ___('label.delivery_area') }}</span>
                            </div>
                            <ul class="options">
                                @foreach ($coverages as $delivery_area)
                                    <li data-id="{{ $delivery_area->id }}">{{ $delivery_area->name }}</li>
                                    <x-coverage-child-ul :coverage="$delivery_area" :depth="1" />
                                @endforeach
                            </ul>
                        </div>

                        <!-- Product Category -->
                        <div class="custom-select w-100 mb-3 product_category">
                            <div class="select-box">
                                <span class="selected-text">{{ ___('charges.product_category') }}</span>
                            </div>
                            <ul class="options">
                                @foreach ($productCategories as $product_category)
                                    <li data-id="{{ $product_category->productCategory->id ?? '' }}">
                                        {{ $product_category->productCategory->name ?? '' }}
                                    </li>
                                @endforeach
                            </ul>
                        </div>

                        <!-- Service Type Select -->
                        <div class="custom-select w-100 service_type"
                            data-label="{{ ___('charges.service_type') }}"
                            data-placeholder="{{ ___('charges.select_service_type') }}"
                            data-service-type-url="{{ route('parcel.serviceType') }}">
                            <div class="select-box">
                                <span class="selected-text">{{ ___('charges.service_type') }}</span>
                            </div>
                            <ul class="options">
                                <li data-id="">{{ ___('charges.select_service_type') }}</li>
                            </ul>
                        </div>

                        <!-- Delivery Cost -->
                        <div class="delivery-total mb-3">
                            <h6 class="charge"
                                data-url="{{ route('parcel.merchant.charge') }}"
                                data-currency="{{ settings('currency') }}"
                                data-label="{{ ___('frontend.total_delivery_cost') }}"
                                data-service-type-url="{{ route('parcel.serviceType') }}">
                                {{ ___('frontend.total_delivery_cost') }} {{ settings('currency') }} {{ ___('frontend.00') }}
                            </h6>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

