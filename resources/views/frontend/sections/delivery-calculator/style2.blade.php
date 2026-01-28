    <div class="cal-area calculator-two bg-thm-2 {{ implode(' ', $widget->section_padding) }}"
    @if($widget->background === 'bg_color') data-background-color="{{ $widget->bg_color }}"
    @elseif($widget->background === 'bg_image') data-background="{{ getImage($widget->upload) }}"
    @endif>


        <div class="shape-1"><img src="{{ data_get(customSection(\Modules\Section\Enums\Type::DELIVERY_CALCULATOR_TWO, 'background_image'), 'original') }}" class="" alt=""></div>
        <div class="shape-2 to-left d-lg-block d-none"><img src="{{ asset('frontend/assets/img/shape/project-container.png') }}" class="" alt=""></div>
        <div class="shape-3 up-move d-lg-block d-none"><img src="{{ asset('frontend/assets/img/shape/line-1.png') }}" class="" alt=""></div>
        <div class="shape-4 up-move"><img src="{{ asset('frontend/assets/img/shape/contact-two-shape-3.png') }}" class="" alt=""></div>

        <div class="container">
            <div class="cal-wpr grid-2">
                <div class="cal-left">
                    <div class="cal-style">
                        <div class="section-title mb-50">
                            <span class="text-primary section-title-tagline border-2 border-primary border-start ps-2">{!! customSection(\Modules\Section\Enums\Type::DELIVERY_CALCULATOR_TWO, 'section_tagline') !!}</span>
                            <h2 class="hero-title-3">{!! customSection(\Modules\Section\Enums\Type::DELIVERY_CALCULATOR_TWO, 'section_title') !!}</h2>
                            <p>{!! customSection(\Modules\Section\Enums\Type::DELIVERY_CALCULATOR_TWO, 'description') !!}</p>
                        </div>
                       <form action="#" method="POST" class="contact-form-requ">
                            @csrf

                            <input type="hidden" id="area" name="area" data-url="{{ route('coverage.detectArea') }}" />
                            {{-- Hidden inputs for selected values --}}
                            <input type="hidden" id="pickup_area_input" name="pickup_area" />
                            <input type="hidden" id="delivery_area_input" name="delivery_area" />
                            <input type="hidden" id="product_category_input" name="product_category" />
                            <input type="hidden" id="service_type_input" name="service_type" />

                            <div class="row g-3">

                                <!-- Pickup Area -->
                                <div class="custom-select w-50 mb-3 pickup_area">
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
                                    <div class="custom-select w-50 mb-3 delivery_area">
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
                                    <div class="custom-select w-50 mb-3 product_category">
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
                                    <div class="custom-select w-50 service_type"
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

                                <div class="col-md-12 pt-4">
                                    <div class="delivery-total two my-0 rounded-pill">
                                        <h6 class="charge"
                                                data-url="{{ route('parcel.merchant.charge') }}"
                                                data-currency="{{ settings('currency') }}"
                                                data-label="{{ ___('frontend.total_delivery_cost') }}"
                                                data-service-type-url="{{ route('parcel.serviceType') }}">
                                                {{ ___('frontend.total_delivery_cost') }} {{ settings('currency') }} {{ ___('frontend.00') }}
                                            </h6>
                                    </div>
                                </div>

                            </div>
                        </form>
                    </div>
                </div>
                <div class="calculator-thumb rounded overflow-hidden ps-lg-5">
                    <img src="{{ data_get(customSection(\Modules\Section\Enums\Type::DELIVERY_CALCULATOR_TWO, 'image'), 'original') }}" class="" alt="">
                </div>
            </div>
        </div>
    </div>
