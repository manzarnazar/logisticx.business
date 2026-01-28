@extends('backend.partials.master')
@section('title')
{{ ___('parcel.parcel') }} {{ ___('label.import') }}
@endsection
@section('maincontent')
<!-- wrapper  -->
<div class="container-fluid">
    <!-- pageheader -->
    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="page-header">
                <div class="page-breadcrumb">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{route('dashboard.index')}}" class="breadcrumb-link">{{ ___('label.dashboard') }}</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('parcel.index') }}" class="breadcrumb-link">{{ ___('parcel.parcel') }}</a></li>
                            <li class="breadcrumb-item"><a href="#" class="breadcrumb-link active">{{ ___('parcel.import') }}</a></li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <div class="row">

        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="form-input-header">
                        <h4 class="title-site"> {{ ___('parcel.parcel') }} {{ ___('parcel.import') }} </h4>
                    </div>

                    <form action="{{ route('parcel.import') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="form-row">

                            @if((auth()->user()->user_type != \App\Enums\UserType::MERCHANT))
                            <div class="col-md-12 form-group importParcel">
                                <label for="merchant_id">{{ ___('merchant.merchant') }}</label>
                                <select id="merchant_id" name="merchant_id" class="form-control" data-url="{{ route('parcel.merchant.get') }}">
                                    <option value="" selected disabled> {{ ___('placeholder.select_merchant')}}</option>
                                </select>
                                @error('merchant_id') <small class="text-danger mt-2">{{ $message }}</small> @enderror
                            </div>
                            @endif

                            <div class="col-md-12 form-group">
                                <label class="label-style-1">{{ ___('label.file') }}<span class="fillable"></span></label>
                                <div class="ot_fileUploader left-side mb-3">
                                    <input class="form-control input-style-1 placeholder" type="text" placeholder="{{ ___('placeholder.attach_file') }}" readonly>
                                    <button class="primary-btn-small-input" type="button">
                                        <label class="j-td-btn" for="fileBrouse">{{ ___('label.browse') }}</label>
                                        <input type="file" class="d-none form-control" name="file" id="fileBrouse" accept=".xls, .xlsx, application/vnd.ms-excel, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet">
                                    </button>
                                </div>
                                @error('file') <div class="text-danger ">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <div class="j-create-btns">
                            <div class="drp-btns">
                                <button type="submit" class="j-td-btn"><i class="fa-solid fa-file-import"></i><span> {{ ___('parcel.import') }}</span></button>
                                <a href="{{ route('parcel.index') }}" class="j-td-btn btn-red"> <i class="fa-solid fa-rectangle-xmark "></i><span>{{ ___('label.cancel') }}</span> </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        @if(session()->has('importErrors'))
        <div class="col-md-6">
            <div class="j-eml-card">
                <h5 class="heading-5">{{ ___('parcel.validation_log')}}</h5>
                @foreach(session()->get('importErrors') as $error)
                <span class="m-3"> {{ $error['message'] }} ( Row:{{ $error['row'] }}, Column : {{ $error['column'] }}) </span>
                @endforeach
            </div>
        </div>
        @else

        <div class="col-md-6">
            <div class="j-eml-card">
                <h5 class="heading-5">{{ ___('common.basic_information')}}</h5>
                <ul class="px-3">
                    @foreach ($notes as $note )
                    <li> {{ $loop->iteration. ". ". $note }}</li>
                    @endforeach
                </ul>
                <button class="btn my-2"> <a href="{{route('parcel.importSample')}}" download class="j-td-btn" data-toggle="tooltip" data-placement="top" title="download">
                        <img src="{{ asset('backend/icons/icon/download-white-5.png') }}" class="jj" alt="no image">
                        <span>{{ ___('parcel.sample') }}</span>
                    </a> </button>
            </div>
        </div>

        @endif

        <!-- end data table  -->
    </div>
</div>
<!-- end wrapper  -->
@endsection()

@push('scripts')

<script src="{{ asset('backend/js/custom/parcel/create.js') }}"></script>

@endpush
