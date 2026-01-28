@extends('frontend.master')


@section('title')
{{ ___('label.contact_us') . " | " . settings('name') }}
@endsection

@section('main')

<!-- Start Breadcrumb ============================================ -->
{{-- <div class="site-breadcrumb" data-background="{{ data_get(customSection(\Modules\Section\Enums\Type::BREADCRUMB,'breadcrumb-image'), 'image_one') }}"> --}}
<div class="site-breadcrumb" style="background-image: url('{{ data_get(customSection(\Modules\Section\Enums\Type::CONTACT_US,'Breadcrumb_image'), 'image_one') }}')">
    <div class="container">
        <div class="site-breadcrumb-wpr">
            <h2 class="breadcrumb-title">{{ customSection(\Modules\Section\Enums\Type::BREADCRUMB, 'contactus-title') }}</h2>
            <ul class="breadcrumb-menu clearfix">
                <li><a href="{{route('/')}}">{{ ___('label.home') }}</a></li>
                <li class="active">{{ ___('label.contact_us') }} </li>
            </ul>
        </div>
    </div>
</div>
<!-- End Breadcrumb -->

<!-- Start Contact us ============================================= -->

<section class="new-login-form de-padding d-none">
    <div class="container contact-container">
        <div class="row g-5 align-items-stretch">
            <!-- Left Contact Info -->
            <div class="col-md-5 d-flex flex-grow-1 flex-column pe-lg-5">
                <div class="card contact-box p-lg-5 p-4 h-100">
                    <div class="card-body d-flex flex-column justify-content-center">
                        <div class=" d-flex align-items-start gap-3">
                            <span class="icon text-primary"><i class="fa-solid fa-location-crosshairs"></i></span>
                            <div>
                                <h5 class="">{{ ___('label.our_location') }}</h5>
                                <p>{{ customSection(\Modules\Section\Enums\Type::CONTACT_US, 'address') }}</p>
                            </div>
                        </div>
                        <hr class="horizontal pt-0">

                        <div class=" d-flex align-items-start gap-3">
                            <span class="icon text-primary"><i class="fa-solid fa-envelope"></i></span>
                            <div>
                                <h5 class="">{{ ___('label.email_us') }}</h5>
                                <p>{{ customSection(\Modules\Section\Enums\Type::CONTACT_US, 'email') }}</p>
                            </div>
                        </div>
                        <hr class="horizontal pt-0">

                        <div class=" d-flex align-items-start gap-3">
                            <span class="icon text-primary"><i class="fa-solid fa-phone"></i></span>
                            <div>
                                <h5 class="">{{ ___('label.phone_number') }}</h5>
                                <p>{{ customSection(\Modules\Section\Enums\Type::CONTACT_US, 'phone') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Right Contact Form -->
            <div class="col-md-7 d-flex flex-grow-1 flex-column">
                <div class="section-title mb-3 mb-lg-4">
                    <p class="border-start ps-3 border-3 border-primary text-left lh-1 mb-4 fs-3 text-dark fw-semibold d-inline-block">{{ ___('label.get_in_touch') }}</p>
                    <h2 class="hero-title-3"><span>{{ ___('label.send_us') }}</span> {{ ___('label.a_message') }}</h2>
                </div>
                <div class="card p-0 border-0 contact-form">
                    <div class="card-body p-3">
                        <form action="{{ route('frontend.contactUs.store') }}" class="contact-form-1 contact-form-style-2" method="POST" onsubmit="submitForm(event)" >
                            @csrf

                            <div class="row g-4">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <input type="text" name="name" class="form-control ps-4 rounded" placeholder="Name" value="{{ old('name') }}">
                                        <small class="text-danger mt-2 d-none error-text"></small>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <input type="email" name="email" class="form-control ps-4 rounded" placeholder="Email" value="{{ old('email') }}">
                                        <small class="text-danger mt-2 d-none error-text"></small>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <input type="number" name="phone" class="form-control ps-4 rounded" placeholder="Phone" value="{{ old('phone') }}">
                                        <small class="text-danger mt-2 d-none error-text"></small>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <input type="text" name="address" class="form-control ps-4 rounded" placeholder="Address" value="{{ old('address') }}">
                                        <small class="text-danger mt-2 d-none error-text"></small>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="form-group">
                                        <textarea placeholder="Message" name="message" class="form-control rounded-4 shadow-none ps-4" rows="3">{{ old('message') }}</textarea>
                                        <small class="text-danger mt-2 d-none error-text"></small>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <button type="submit" class="btn-two btn-md fs-4 rounded" data-loading-text="Submitting...">
                                        {{ ___('label.send_message') }}
                                        <span><i class="fa-brands fa-telegram fs-3 ms-2"></i></span>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
</section>

<!-- End Contact us -->


<!------- new contact us start --------->

<section class="py-80">
    <div class="container-fluid p-0">
        <div class="row g-4 align-items-center">
            <!-- Left Info Panel -->
            <div class="col-lg-5 col-lg-5 pe-lg-4">
                <div class="left-panel mx-lg-0 mx-3" style="background-image: url('{{ data_get(customSection(\Modules\Section\Enums\Type::CONTACT_US,'left_info_image'), 'image_one') }}');">
                    <div class=" position-relative">
                        <p class="text-primary fw-bold mb-1">{{ ___('label.CONTACT_US') }}</p>
                        <h2 class="heading-1 fw-bold mb-3">{{ ___('label.SEND_A_MESSAGE') }}</h2>
                        <p class=" mb-0">
                            {{ settings('official_message') }}
                        </p>

                        <!-- Info Rows -->
                        <div class="d-flex align-items-center mt-4 mt-lg-5">
                            <div class="info-icon flex-shrink-0 me-4"><i class="fas fa-location-dot"></i></div>
                            <div>
                                <span class="">{{ ___('label.Office') }}</span>
                                <h5 class="heading-5 mb-0">{{ customSection(\Modules\Section\Enums\Type::CONTACT_US, 'address') }}</h5>
                            </div>
                        </div>

                        <div class="d-flex align-items-center mt-4">
                            <div class="info-icon flex-shrink-0 me-4"><i class="fas fa-clock"></i></div>
                            <div>
                                <span class="">{{ ___('label.Open_Hours') }}</span>
                                <h5 class="heading-5 mb-0">{{ settings('open_hours') }}</h5>
                            </div>
                        </div>

                        <div class="d-flex align-items-center mt-4">
                            <div class="info-icon flex-shrink-0 me-4"><i class="fas fa-phone"></i></div>
                            <div>
                                <span class="">{{ ___('label.Free_Consultation') }}</span>
                                <h5 class="heading-5 mb-0">{{ customSection(\Modules\Section\Enums\Type::CONTACT_US, 'phone') }}</h5>
                            </div>
                        </div>

                        <div class="d-flex align-items-center mt-4">
                            <div class="info-icon flex-shrink-0 me-4"><i class="fas fa-envelope"></i></div>
                            <div>
                                <span class="">{{ ___('label.Email_Us') }}</span>
                                <h5 class="heading-5 mb-0">{{ customSection(\Modules\Section\Enums\Type::CONTACT_US, 'email') }}</h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Form Panel -->
            <div class="col-lg-7">
                <form class="right-panel" action="{{ route('frontend.contactUs.store') }}" onsubmit="submitForm(event)" method="POST">
                    @csrf
                    <div class="content" style="background-image: url('{{ data_get(customSection(\Modules\Section\Enums\Type::CONTACT_US,'right_info_image'), 'image_one') }}');">
                        <div class="row gy-4 gx-3">
                            <div class="col-md-6 position-relative">
                                <label class="form-label">{{ ___('label.Name') }}</label>
                                <div class="position-relative">
                                    <span class="input-icon"><i class="fas fa-user"></i></span>
                                    <input type="text" class="form-control" placeholder="{{ ___('label.your_Name') }}" name="name" />
                                </div>
                            </div>
                            <div class="col-md-6 position-relative">
                                <label class="form-label">{{ ___('label.Email') }}</label>
                                <div class="position-relative">
                                    <span class="input-icon"><i class="fas fa-envelope"></i></span>
                                    <input type="email" class="form-control" placeholder="{{ ___('label.your_Email') }}" name="email" />
                                </div>
                            </div>
                            <div class="col-md-6 position-relative">
                                <label class="form-label"> {{ ___('label.Phone') }}</label>
                                <div class="position-relative">
                                    <span class="input-icon"><i class="fa-solid fa-phone"></i></span>
                                    <input type="text" class="form-control" placeholder="{{ ___('label.Your_Phone_Number') }}" name="phone" />
                                </div>
                            </div>
                            <div class="col-md-6 position-relative">
                                <label class="form-label">{{ ___('label.Subject') }}</label>
                                <div class="position-relative">
                                    <span class="input-icon"><i class="fas fa-pen"></i></span>
                                    <input type="text" class="form-control" name="subject" placeholder="{{ ___('label.your_Subject') }}" />
                                </div>
                            </div>
                            <div class="col-md-6 position-relative">
                                <label class="form-label">{{ ___('label.Address') }}</label>
                                <div class="position-relative">
                                    <span class="input-icon"><i class="fas fa-pen"></i></span>
                                    <input type="text" class="form-control" name="address" placeholder="{{ ___('label.your_Address') }}" />
                                </div>
                            </div>
                            <div class="col-12 position-relative">
                                <label class="form-label">{{ ___('label.Message') }}</label>
                                <div class="position-relative">
                                    <span class="input-icon"><i class="fas fa-message"></i></span>
                                    <textarea class="form-control" rows="5" placeholder="{{ ___('label.your_Message') }}" name="message"></textarea>
                                </div>
                            </div>
                            <div class="col-12 text-start mt-4 position-relative">
                                <button type="submit" class="btn-1 two rounded-pill"> {{ ___('label.Send_Message')}} <i class="fa-solid fa-arrow-right"></i></button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>


<!-- google maps -->

<section class="maps pb-80">
    <div class="container-fluid">
        <iframe src="{{ customSection(\Modules\Section\Enums\Type::CONTACT_US, 'map') }}" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
    </div>
</section>

<!-- google maps -->



@endsection
