@extends('backend.partials.master')
@section('title')
{{ ___('menus.profile') }}
@endsection
@section('maincontent')
<div class="container-fluid  dashboard-content">

    <div class="j-profile-main">
        <div class="row">
            <div class="col-xl-5">
                <div class="row page-titles mx-0">
                    <div class="col-sm-6 p-md-0">
                        <div class="welcome-text wel-flex">
                            <div class="wel-user-pic">
                                <img src="{{ getImage($merchant->user->upload, 'original','default-image-40x40.png' ) }}" class="profile-img" alt="no image">
                            </div>
                            <div class="wel-user-bio">
                                <h5 class="heading-5">{{@$merchant->user->name}}</h5>
                                <p class="mb-0">{{@$merchant->user->email}}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                        {{-- <a href="#" class="j-btn-sm">{{ ___('label.edit') }}</a> --}}
                        {{-- <a href="#profile-settings" data-toggle="tab" class="j-btn-sm active show">{{ ___('label.edit') }}</a> --}}
                    </div>
                </div>
                <div class="j-eml-card">
                    <h5 class="heading-5">Profile Information</h5>
                    <ul class="j-eml-list">
                        <li>
                            <h6 class="heading-6">Name</h6>
                            <span>{{@$merchant->user->name}}</span>
                        </li>

                        <li>
                            <h6 class="heading-6">NID</h6>
                            <span>{{@$merchant->user->nid_number}}</span>
                        </li>
                        <li>
                            <h6 class="heading-6">Address</h6>
                            <span>{{@$merchant->user->address}}</span>
                        </li>
                        <li>
                            <h6 class="heading-6">{{ ___('label.business_name') }}</h6>
                            <span>{{ @$merchant->business_name }}</span>
                        </li>
                        </li>

                        <li>
                            <h6 class="heading-6">{{ ___('label.vat') }}</h6>
                            <span>{{ @settings('currency') }} {{ @$merchant->vat }}</span>
                        </li>

                        <li>
                            <h6 class="heading-6">{{ ___('label.hub') }}</h6>
                            <span>{{@$merchant->user->hub->name}}</span>
                        </li>

                        <li>
                            <h6 class="heading-6">{{ ___('reports.total') }} {{ ___('merchant.merchant') }}</h6>
                            <span>{{@$merchant->activeShops->count()}}</span>
                        </li>

                        <li>
                            <h6 class="heading-6">{{ ___('menus.coverage') }}</h6>
                            <span>{{@$merchant->coverage->name}}</span>
                        </li>

                        <li>
                            <h6 class="heading-6">{{ ___('label.merchant_unique_id') }}</h6>
                            <span>{{@$merchant->merchant_unique_id}}</span>
                        </li>

                        <li>
                            <h6 class="heading-6">{{ ___('label.status') }}</h6>
                            <span>{!! @$merchant->my_status !!}</span>
                        </li>

                    </ul>
                </div>
            </div>
            <div class="col-xl-7">
                <div class="card card-border profile-pd-0">
                    <div class="card-body">
                        <div class="profile-tab">
                            <div class="custom-tab-1">
                                <ul class="nav nav-tabs">
                                    <li class="nav-item"><a href="#profile-settings" data-toggle="tab" class="nav-link active show">{{ ___('label.account_setting') }}</a> </li>
                                    <li class="nav-item"><a href="#password-change" data-toggle="tab" class="nav-link ">{{ ___('menus.change_password') }}</a> </li>
                                </ul>
                                <div class="tab-content">

                                    <div id="profile-settings" class="tab-pane fade active show">
                                        <div class="settings-form j-text-body">
                                            {{-- <h4 class="text-primary">{{ ___('label.account_setting') }}</h4> --}}
                                            <form action="{{route('merchant-profile.update',$merchant->user->id)}}" method="POST" enctype="multipart/form-data" id="basicform">

                                                @csrf
                                                @method('PUT')

                                                <div class="row">
                                                    <div class="form-group col-12 col-md-6">
                                                        <label class="label-style-1" for="name">{{ ___('label.name') }}</label>
                                                        <input id="name" type="text" name="name" placeholder="Enter name" class="form-control input-style-1" value="{{$merchant->user->name}}" require>
                                                        @error('name') <small class="text-danger mt-2">{{ $message }}</small> @enderror
                                                    </div>
                                                    <div class="form-group col-12 col-md-6">
                                                        <label class="label-style-1" for="business_name">{{ ___('label.business_name') }}</label>
                                                        <input id="business_name" type="text" name="business_name" placeholder="Enter business name" class="form-control input-style-1" value="{{$merchant->business_name}}" require>
                                                        @error('business_name') <small class="text-danger mt-2">{{ $message }}</small> @enderror
                                                    </div>
                                                    <div class="form-group col-12 col-md-6">
                                                        <label class="label-style-1" for="email">{{ ___('label.email') }}</label>
                                                        <input id="email" type="text" name="email" placeholder="Enter email" class="form-control input-style-1" value="{{$merchant->user->email}}" require>
                                                        @error('email') <small class="text-danger mt-2">{{ $message }}</small> @enderror
                                                    </div>
                                                    <div class="form-group col-12 col-md-6">
                                                        <label class="label-style-1" for="mobile">{{ ___('label.mobile') }}</label>
                                                        <input id="mobile" type="text" name="mobile" placeholder="Enter mobile" class="form-control input-style-1" value="{{$merchant->user->mobile}}" require>
                                                        @error('mobile') <small class="text-danger mt-2">{{ $message }}</small> @enderror
                                                    </div>


                                                    <div class="form-group col-12 col-md-6">
                                                        <label class="label-style-1" for="address">{{ ___('label.address') }}</label>
                                                        <input id="address" type="text" name="address" placeholder="Enter Address" class="form-control input-style-1" value="{{$merchant->address}}" require>
                                                        @error('address') <small class="text-danger mt-2">{{ $message }}</small> @enderror
                                                    </div>

                                                    <div class="form-group col-12 col-md-6">
                                                        <label class="label-style-1" for="coverage">{{ ___('menus.coverage') }} Area <span class="text-danger">*</span> </label>
                                                        <select name="coverage" id="coverage" class="form-control input-style-1 select2">
                                                            <option value="" @selected(true)>{{ ___('label.select') }}</option>

                                                            @foreach($coverages as $coverage)

                                                            <option value="{{ $coverage->id}}" @selected(old('coverage',$merchant->coverage_id)==$coverage->id)> {{ $coverage->name }}</option>

                                                            <x-coverage-child :coverage="$coverage" name="coverage" :old="$merchant->coverage_id" />

                                                            @endforeach

                                                        </select>
                                                        @error('coverage') <small class="text-danger mt-2">{{ $message }}</small> @enderror
                                                    </div>

                                                    <div class="form-group col-md-6">
                                                        <label class="label-style-1">{{ ___('label.image') }}<span class="fillable"></span></label>
                                                        <div class="ot_fileUploader left-side mb-3">
                                                            <img src="{{ getImage($merchant->user->upload, 'original','default-image-40x40.png' ) }}" alt="user" class="rounded">
                                                            <input class="form-control input-style-1 placeholder" type="text" placeholder="{{ ___('label.image') }}" readonly>
                                                            <button class="primary-btn-small-input" type="button">
                                                                <label class="j-td-btn" for="image_id">{{ ___('label.browse') }}</label>
                                                                <input type="file" class="d-none form-control" name="image_id" id="image_id" accept="image/jpg, image/jpeg, image/png">
                                                            </button>
                                                        </div>
                                                        @error('image_id') <small class="text-danger mt-2">{{ $message }}</small> @enderror
                                                    </div>

                                                    <div class="form-group col-md-6">
                                                        <label class="label-style-1" for="nid">{{ ___('label.nid') }}<span class="fillable"></span></label>
                                                        <div class="ot_fileUploader left-side mb-3">
                                                            <img src="{{ @$merchant->nid}}" alt=" " class="rounded">
                                                            <input class="form-control input-style-1 placeholder" type="text" placeholder="{{ ___('label.nid') }}" readonly>
                                                            <button class="primary-btn-small-input" type="button">
                                                                <label class="j-td-btn" for="nid">{{ ___('label.browse') }}</label>
                                                                <input type="file" class="d-none form-control" name="nid" id="nid" accept="image/*, application/pdf">
                                                            </button>
                                                        </div>
                                                        @error('nid') <small class="text-danger mt-2">{{ $message }}</small> @enderror
                                                    </div>

                                                    <div class="form-group col-md-6">
                                                        <label class="label-style-1" for="trade_license">{{ ___('label.trade_license') }}<span class="fillable"></span></label>
                                                        <div class="ot_fileUploader left-side mb-3">
                                                            <img src="{{ @$merchant->trade}}" alt=" " class="rounded">
                                                            <input class="form-control input-style-1 placeholder" type="text" placeholder="{{ ___('label.trade_license') }}" readonly>
                                                            <button class="primary-btn-small-input" type="button">
                                                                <label class="j-td-btn" for="trade_license">{{ ___('label.browse') }}</label>
                                                                <input type="file" class="d-none form-control" name="trade_license" id="trade_license" accept="image/*, application/pdf">
                                                            </button>
                                                        </div>
                                                        @error('trade_license') <small class="text-danger mt-2">{{ $message }}</small> @enderror
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 ">
                                                        <button type="submit" class="j-td-btn"><i class="fa-solid fa-floppy-disk "></i>{{ ___('label.update') }}</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>

                                    <div id="password-change" class="tab-pane fade ">
                                        <div class="profile-password-change j-text-body">
                                            {{-- <h4 class="text-primary">{{ ___('menus.change_password') }}</h4> --}}
                                            <form action="{{route('merchant-profile.password.update',$merchant->user->id)}}" method="POST" enctype="multipart/form-data">

                                                @method('PUT')
                                                @csrf

                                                <div class="form-row">
                                                    <div class="col-md-6">
                                                        <div class="form-group ">
                                                            <label class="label-style-1" for="old_password">{{ ___('label.old_password') }}</label>
                                                            <input id="old_password" type="password" name="old_password" placeholder="{{ ___('placeholder.enter_old_password') }}" class="form-control input-style-1" value="{{old('old_password')}}" require>
                                                            @error('old_password') <small class="text-danger mt-2">{{ $message }}</small> @enderror
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="label-style-1" for="new_password">{{ ___('label.new_password') }}</label>
                                                            <input id="new_password" type="password" name="new_password" placeholder="{{ ___('placeholder.enter_new_password') }}" class="form-control input-style-1" value="{{old('new_password')}}" require>
                                                            @error('new_password') <small class="text-danger mt-2">{{ $message }}</small> @enderror
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="label-style-1" for="confirm_password">{{ ___('label.confirm_password') }}</label>
                                                            <input id="confirm_password" type="password" name="confirm_password" placeholder="{{ ___('placeholder.enter_confirm_password') }}" value="{{old('confirm_password')}}" class="form-control input-style-1" require>
                                                            @error('confirm_password') <small class="text-danger mt-2">{{ $message }}</small> @enderror
                                                        </div>
                                                    </div>
                                                </div>

                                                <button class="btn btn-primary" type="submit"> <i class="fa-solid fa-floppy-disk "></i>{{ ___('label.update') }}</button>

                                            </form>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- end wrapper  -->
@endsection()


@push('scripts')

<script type="text/javascript">
    $(document).ready(function() {
        var currentURL = window.location.href;
        var profileSettingsTab = $('#profile-settings');
        var passwordChangeTab = $('#password-change');

        if (currentURL.includes('merchant/profile/change-password')) {
            // Activate the "password-change" tab
            profileSettingsTab.removeClass('active show');
            passwordChangeTab.addClass('active show');
        }
    });

</script>

@endpush
