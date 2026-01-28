{{-- <section class="pos-rel hero-single three mt-90 {{ implode(' ', $widget->section_padding) }}" @if($widget->background === 'bg_color') data-background-color="{{ $widget->bg_color }}"
@elseif($widget->background === 'bg_image') data-background="{{ getImage($widget->upload) }}"
@endif> --}}
{{-- <section class="pos-rel hero-two py-150" style="background-image: url('frontend/assets/img/logistics-img/ship-4.jpg');"> --}}
 @php $hero_image = customSection(\Modules\Section\Enums\Type::HERO_SECTION, 'hero_image'); @endphp
<section class="pos-rel hero-two {{ implode(' ', $widget->section_padding) }}" @if($widget->background === 'bg_color') data-background-color="{{ $widget->bg_color }}"
@elseif($widget->background === 'bg_image')
    data-background="{{ getImage($widget->upload) }}"
@else
    style="background-image: url('{{  $hero_image['original'] }}');"
@endif>
{{-- @dd(customSection(\Modules\Section\Enums\Type::HERO_SECTION, 'client_img1')) --}}
    <div class="shape-1 to-left"><img src="{{ asset('frontend/assets/img/logistics-img/plane-1.png') }}" alt=""></div>
    <div class="shape-2 up-move"><img src="{{ asset('frontend/assets/img/shape/contact-two-shape-3.png') }}" alt=""></div>

    <div class="container">
        <div class="row gx-4 gy-5 align-items-center">
            <div class="col-xl-7">
                <div class=" mt-0">
                    <span class="slider-subtitle ">{{ customSection(\Modules\Section\Enums\Type::HERO_SECTION, 'short_title') }}</span>
                    <h2 class="slider-title-2 "> {!! customSection(\Modules\Section\Enums\Type::HERO_SECTION, 'hero_section_title') !!} </h2>
                    <p class="banner-two-text text-light pe-lg-4">{{ customSection(\Modules\Section\Enums\Type::HERO_SECTION, 'hero_section_short_description') }}</p>

                    <div class="d-flex flex-wrap gap-4 gap-lg-5 align-items-center">
                        <a href="{{ customSection(\Modules\Section\Enums\Type::HERO_SECTION, 'link')  }}" class="btn-1 rounded-pill two">{{ customSection(\Modules\Section\Enums\Type::HERO_SECTION, 'button_name') }} <i class="fa-solid fa-arrow-right"></i></a>
                        <div class="satisficed-partner d-flex gap-3 align-items-center ">
                            <ul class="d-flex align-items-center">
                                <li>
                                     @php $client_image_one = customSection(\Modules\Section\Enums\Type::HERO_SECTION, 'client_image_one'); @endphp
                                     {{-- @dd($hero_image) --}}
                                    <div><img src="{{ isset($client_image_one['original']) ? $client_image_one['original'] : asset('frontend/assets/img/testimonial/person-1.png') }}" alt=""></div>
                                </li>
                                <li>
                                     @php $client_image_two = customSection(\Modules\Section\Enums\Type::HERO_SECTION, 'client_image_two'); @endphp
                                    <div><img src="{{ isset($client_image_two['original']) ? $client_image_two['original'] : asset('frontend/assets/img/testimonial/person-2.png') }}" alt=""></div>
                                </li>
                                <li>
                                     @php $client_image_three = customSection(\Modules\Section\Enums\Type::HERO_SECTION, 'client_image_three'); @endphp
                                    <div><img src="{{ isset($client_image_three['original']) ? $client_image_three['original'] : asset('frontend/assets/img/testimonial/person-3.png') }}" alt=""></div>
                                </li>
                            </ul>
                            <div class="counting">
                                <div class="d-flex align-items-center">
                                    <h5 class="">{{ customSection(\Modules\Section\Enums\Type::HERO_SECTION, 'total_satisfied_clients') }}</h5>
                                </div>
                                <p class="mb-0">{{ customSection(\Modules\Section\Enums\Type::HERO_SECTION, 'satisfied_clients_label') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-5">
                <div class="form-box">
                    <form action="{{ route('customer_inquiry.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row g-4">
                            <div class="col-md-6">
                                <div class="input-box position-relative">
                                    <input type="text" name="name" placeholder="{{ ___('placeholder.name') }}" class="form-control">
                                    <div class="icon"><i class="fas fa-user"></i></div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="input-box position-relative">
                                    <input type="tel" name="phone" placeholder="{{ ___('placeholder.phone') }}" class="form-control">
                                    <div class="icon"><i class="fas fa-phone"></i></div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="input-box position-relative">
                                    <input type="email" name="email" placeholder="{{ ___('placeholder.email') }}" class="form-control">
                                    <div class="icon"><i class="fas fa-envelope"></i></div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="input-box position-relative">
                                    <input type="text" name="subject" placeholder="{{___('placeholder.subject')}}" class="form-control">
                                    <div class="icon"><i class="fas fa-envelope-open-text"></i></div>
                                </div>
                            </div>
                            {{-- <div class="col-md-6">
                                <div class="custom-select w-100">
                                    <div class="select-box">
                                        <span class="selected-text">Freight Type</span>
                                    </div>
                                    <ul class="options">
                                        <li>Freight Type 01</li>
                                        <li>Freight Type 02</li>
                                        <li>Freight Type 03</li>
                                        <li>Freight Type 04</li>
                                        <li>Freight Type 05</li>
                                    </ul>
                                </div>
                            </div> --}}

                            {{-- <div class="col-md-6">
                                <div class="custom-select w-100">
                                    <div class="select-box">
                                        <span class="selected-text">Shipment Mode</span>
                                    </div>
                                    <ul class="options">
                                        <li>Air</li>
                                        <li>Sea</li>
                                        <li>Road</li>
                                        <li>Rail</li>
                                    </ul>
                                </div>
                            </div> --}}

                            <div class="col-12">
                                <div class="input-box position-relative">
                                    <textarea name="message" rows="6" placeholder="{{ ___('placeholder.message') }}" class="form-control h-auto"></textarea>
                                    <div class="icon"><i class="fa-regular fa-envelope"></i></div>
                                </div>
                            </div>

                            <div class="col-12 lh-1">
                                <button type="submit" class="btn-1 rounded-pill two">{{ ___('label.submit')}} <i class="fa-solid fa-arrow-right"></i></button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="col-lg-6 mb-4 mb-lg-0 d-none">
                <div class="hero-thumb ps-lg-absolute top-0 bottom-0">
                    @php $hero_image = customSection(\Modules\Section\Enums\Type::HERO_SECTION, 'hero_image'); @endphp
                    @if (config('app.app_demo') == true )
                    <img src="{{ asset('frontend/assets/img/bg/delivery-truck.jpg') }}" loading="lazy" class="img-fluid" alt="">
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>

<div class="container position-relative d-none">
    <div class="shadow p-5 rounded-3 hero-track-bottom ps-lg-absolute translate-middle-lg-y">
        <form action="#" class="w-100">
            @csrf
            <input type="hidden" id="area" name="area" data-url="{{ route('coverage.detectArea') }}" />
            <div class="d-flex justify-content-between gap-3 align-items-center flex-lg-nowrap flex-wrap">
                <div class="form-group pos-rel pe-lg-2 w-100">
                    <select name="pickup_area" id="pickup_area" class="form-control rounded shadow-none">
                        <option value="" @selected(true) @disabled(true)> {{ ___('label.select') }} {{ ___('label.pickup_area') }} </option>

                        @foreach ($coverages as $coverage)
                        <option value="{{ $coverage->id }}" @selected(old('pickup_area')==$coverage->id)> {{ $coverage->name }}</option>
                        <x-coverage-child :coverage="$coverage" name="pickup_area" />
                        @endforeach
                    </select>
                </div>

                <div class="form-group pos-rel pe-lg-2 w-100">
                    <select name="delivery_area" id="delivery_area" class="form-control rounded shadow-none">
                        <option value="" @selected(true) @disabled(true)> {{ ___('label.select') }} {{ ___('label.delivery_area') }}</option>

                        @foreach ($coverages as $coverage)
                        <option value="{{ $coverage->id }}" @selected(old('delivery_area')==$coverage->id)> {{ $coverage->name }}</option>
                        <x-coverage-child :coverage="$coverage" name="delivery_area" />
                        @endforeach
                    </select>
                </div>

                <div class="form-group pos-rel pe-lg-2 w-100">
                    <select name="product_category" id="product_category" class="form-control rounded shadow-none">
                        <option value="" @selected(true) @disabled(true)> {{ ___('label.select') }} {{ ___('charges.product_category') }}</option>

                        @foreach ($productCategories as $category)
                        <option value="{{ $category->product_category_id }}" @selected(old('product_category')==$category->product_category_id)>
                            {{ $category->productCategory->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group pos-rel pe-lg-2 w-100">
                    <select id="service_type" class="form-control input-style-2 form-select" name="service_type" data-url="{{ route('parcel.serviceType') }}">
                        <option value="" @selected(true) @disabled(true)> {{ ___('label.select') }} {{ ___('charges.service_type') }}</option>
                    </select>
                </div>

                <div class="form-group pos-rel w-100">
                    <h6 id="charge" data-url="{{ route('parcel.merchant.charge') }}" class="mb-0" data-currency="{{ settings('currency') }}"> {{ ___('frontend.total_delivery_cost') }} {{ settings('currency') }} {{ ___('frontend.00') }} </h6>
                </div>
            </div>
        </form>
    </div>
</div>
