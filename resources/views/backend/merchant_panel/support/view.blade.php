@extends('backend.partials.master')
@section('title')
{{ ___('common.support') }} {{ ___('label.view') }}
@endsection
@section('maincontent')
<!-- wrapper  -->
<div class="container-fluid  dashboard-content">
    <!-- pageheader -->
    <div class="row">
        <div class="col-md-12 col-sm-12 col-12 m-auto">
            <div class="page-header">
                <div class="page-breadcrumb">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{route('dashboard.index')}}" class="breadcrumb-link">{{ ___('label.dashboard') }}</a></li>
                            <li class="breadcrumb-item"><a href="{{route('merchant-panel.support.index')}}" class="breadcrumb-link">{{ ___('common.support_list') }}</a></li>
                            <li class="breadcrumb-item"><a href="" class="breadcrumb-link active">{{ ___('label.list') }}</a></li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <!-- end pageheader -->
    <div class="row">
        <div class="col-xl-4 col-md-12 col-sm-12 col-12">
            <div class="j-eml-card">
                <h5 class="heading-5">{{ ___('common.basic_information')}}</h5>
                <ul class="j-eml-list">
                    <li>
                        <h6 class="heading-6">{{ ___('label.name')}}</h6>
                        <span>{{@$singleSupport->user->name}}</span>
                    </li>
                    <li>
                        <h6 class="heading-6">{{ ___('label.email') }}</h6>
                        <span>{{ $singleSupport->user->email }}</span>
                    </li>
                    <li>
                        <h6 class="heading-6">{{ ___('common.service') }}</h6>
                        <span>{{ ___('common.'. $singleSupport->service ) }}</span>
                    </li>
                    <li>
                        <h6 class="heading-6">{{ ___('label.department') }}</h6>
                        <span>{{ $singleSupport->department->title }}</span>
                    </li>
                    <li>
                        <h6 class="heading-6">{{ ___('common.priority') }}</h6>
                        <span>{{ $singleSupport->priority }}</span>
                    </li>

                    <li>
                        <h6 class="heading-6">{{ ___('label.date') }}</h6>
                        <span>{{ dateFormat($singleSupport->date) }}</span>
                    </li>

                </ul>
            </div>
        </div>
        <div class="col-xl-8  col-md-12 col-sm-12 col-12">
            <div class="j-eml-card">
                <h5 class="heading-5">{{ $singleSupport->subject }} </h5>
                <div id="accordion">

                    <button class="btn btn-link" data-toggle="collapse" data-target="#collapseOne" aria-expanded="@if($errors->has('message')) true @else false @endif" aria-controls="collapseOne">
                        <i class="fa fa-reply m-2 "></i>{{ ___('common.reply') }}
                    </button>


                    <div class="mx-3 collapse @error('message') show @enderror" id="collapseOne" data-parent="#accordion">

                        <form action="{{ route('merchant-panel.support.reply',['support_id'=>$singleSupport->id]) }}" method="post" enctype="multipart/form-data">
                            @csrf

                            <div class="form-group">
                                <label for="message">{{ ___('common.message')}} <span class="text-danger">*</span></label>
                                <textarea class="form-control input-style-1 summernote " name="message" rows="3" id="message" placeholder="{{ ___('placeholder.enter_message') }}" value="{{ old('message') }}"></textarea>
                                @error('message') <small class="text-danger mt-2">{{ $message }}</small> @enderror
                            </div>

                            <div class="d-flex justify-content-between">

                                <div class="form-group">
                                    <label class="label-style-1" for="attached_file">{{ ___('common.attached_file') }} </label>
                                    <div class="ot_fileUploader left-side mb-3">
                                        <input class="form-control input-style-1 placeholder" type="text" placeholder="{{ ___('common.attached_file') }}" readonly="" id="placeholder">
                                        <button class="primary-btn-small-input" type="button">
                                            <label class="j-td-btn" for="attached_file">{{ ___('label.browse') }}</label>
                                            <input type="file" class="d-none form-control" name="attached_file" id="attached_file" accept="image/*, application/pdf">
                                        </button>
                                    </div>
                                    @error('attached_file') <small class="text-danger mt-2">{{ $message }}</small> @enderror
                                </div>
                                <button type="submit" class="j-td-btn">{{ ___('label.send') }}</button>
                            </div>

                        </form>
                    </div>
                </div>
                {{-- @endif --}}


                @foreach($chats as $chat)
                <div class="m-3 p-2 rounded border border-info">
                    <div class="d-flex justify-content-between">
                        <div>
                            <img src="{{ getImage($chat->user->upload, 'original','default-image-40x40.png' ) }}" alt="user" class="rounded-circle" width="30" height="30">
                            <b>{{@$chat->user->name}}</b>
                            <span class="bullet-badge bullet-badge-primary">{!! $chat->userType !!}</span>
                        </div>
                        <div>
                            <small> {{ dateTimeFormat($chat->created_at)}}</small>
                        </div>
                    </div>
                    <div>
                        <p class="mt-2"> {!! $chat->message !!}</p>
                        @if(@$chat->file)
                        <a href="{{ asset(@$chat->file->original) }}" download="Attachment">
                            <i class="fa-solid fa-cloud-arrow-down"></i> <span>{{ ___('placeholder.download_attachment') }}</span>
                        </a>
                        @endif
                    </div>
                </div>
                @endforeach

                <div class="m-3 p-2 rounded border border-info">
                    <div class="d-flex justify-content-between">
                        <div>
                            <img src="{{ getImage($singleSupport->user->upload, 'original','default-image-40x40.png' ) }}" alt="user" class="rounded-circle" width="30" height="30">
                            <b>{{@$singleSupport->user->name}}</b>
                            <span class="bullet-badge bullet-badge-primary">{!! @$singleSupport->userType !!}</span>
                        </div>
                        <div>
                            <small> {{ dateTimeFormat($singleSupport->created_at)}}</small>
                        </div>
                    </div>
                    <div>
                        <p class="mt-2"> {!! $singleSupport->description !!}</p>

                        @if(@$singleSupport->file)
                        <a href="{{ asset(@$singleSupport->file->original) }}" download="Attachment"> <i class="fa-solid fa-cloud-arrow-down"></i> <span>{{ ___('placeholder.download_attachment') }}</span> </a>
                        @endif

                    </div>
                </div>


            </div>
        </div>
    </div>
</div>
<!-- end wrapper  -->
@endsection()
