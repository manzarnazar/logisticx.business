@extends('backend.partials.master')
@section('title')
    {{ ___('label.social_link') }} {{ ___('label.edit') }}
@endsection

@section('maincontent')
    <div class="container-fluid  dashboard-content">
        <!-- pageheader -->
        <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="page-header">
                    <div class="page-breadcrumb">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}"
                                        class="breadcrumb-link">{{ ___('label.dashboard') }}</a></li>
                                <li class="breadcrumb-item"><a href=""
                                        class="breadcrumb-link">{{ ___('label.website_setup') }}</a></li>
                                <li class="breadcrumb-item "><a href="{{ route('socialLink.index') }}">{{ ___('label.social_link') }} </a>
                                </li>
                                <li class="breadcrumb-item active"><a href="javascript:void(0)" class="active">{{ ___('label.edit') }}</a></li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
        <!-- end pageheader -->

        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="form-input-header">
                        <h4 class="title-site">{{ ___('label.edit') }} {{ ___('label.social_link') }}
                        </h4>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('socialLink.update', ['id' => $sociallink->id]) }}" method="post"
                            enctype="multipart/form-data">
                            @csrf
                            @method('put')
                            <div class="form-row">
                                <div class="col-lg-6">
                                    <div class="form-group ">
                                        <label class="label-style-1">{{ ___('label.name') }} <span class="text-danger">*</span></label>
                                        <input type="text" placeholder="{{ ___('label.enter_name') }}" class="form-control input-style-1"
                                            name="name" value="{{ old('name', $sociallink->name) }}">
                                        @error('name')
                                            <small class="text-danger mt-2">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group ">
                                        <label class="label-style-1">{{ ___('label.icon') }} (Example: <span class="text-warning">fab
                                                fa-facebook-f</span>) <span class="text-danger">*</span></label>
                                        <input type="text" placeholder="{{ ___('label.enter_icon') }}" class="form-control input-style-1"
                                            name="icon" value="{{ old('icon', $sociallink->icon) }}">
                                        @error('icon')
                                            <small class="text-danger mt-2">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group ">
                                        <label class="label-style-1">{{ ___('label.link') }} <span class="text-danger">*</span></label>
                                        <input type="url" placeholder="{{ ___('label.enter_link') }}" class="form-control input-style-1"
                                            name="link" value="{{ old('link', $sociallink->link) }}">
                                        @error('link')
                                            <small class="text-danger mt-2">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="form-group ">
                                        <label class="label-style-1">{{ ___('label.position') }} <span class="text-danger">*</span></label>
                                        <input type="number" placeholder="{{ ___('placeholder.position') }}" class="form-control input-style-1"
                                            name="position" value="{{ old('position', $sociallink->position) }}">
                                        @error('position')
                                            <small class="text-danger mt-2">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group col-md-6">
                                    <label class="label-style-1">{{ ___('label.status') }} <span class="text-danger">*</span></label>
                                    <select name="status" class="form-control input-style-1 select2">
                                        <option value="{{ \App\Enums\Status::ACTIVE }}" @if (old('status', $sociallink->status) == \App\Enums\Status::ACTIVE) selected @endif>
                                            {{ ___('label.active') }} </option>
                                        <option value="{{ \App\Enums\Status::INACTIVE }}" @if (old('status', $sociallink->status) == \App\Enums\Status::INACTIVE) selected @endif>
                                            {{ ___('label.inactive') }} </option>
                                    </select>
                                    @error('status')
                                        <small class="text-danger mt-2">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="j-create-btns ml-1">
                                    <div class="drp-btns">
                                        <button type="submit" class="j-td-btn"><i
                                                class="fa-solid fa-floppy-disk "></i><span>{{ ___('label.update') }}</span></button>
                                        <a href="{{ route('socialLink.index') }}" class="j-td-btn btn-red"> <i
                                                class="fa-solid fa-rectangle-xmark "></i><span>{{ ___('label.cancel') }}</span> </a>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
