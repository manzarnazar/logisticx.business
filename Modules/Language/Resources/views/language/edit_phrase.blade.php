@extends('backend.partials.master')

@section('title')
{{ ___('language.title') }} {{ ___('language.edit_phrase') }}
@endsection

@section('maincontent')
<div class="container-fluid  dashboard-content">
    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="page-header">
                <div class="page-breadcrumb">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{route('dashboard.index')}}" class="breadcrumb-link">{{ ___('label.dashboard') }}</a></li>
                            <li class="breadcrumb-item"><a href="{{route('language.index')}}" class="breadcrumb-link">{{ ___('language.title')}}</a></li>
                            <li class="breadcrumb-item"><a href="" class="breadcrumb-link active">{{ ___('language.edit_phrase') }}</a></li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header mb-3">
                    <h4 class="title-site">{{ ___('language.edit_phrase') }} </h4>
                </div>

                <div class="card-body">

                    <form action="{{ route('language.update.phrase', [$lang->code]) }}" method="post">
                        @csrf

                        <input type="hidden" name="code" id="code" value="{{ @$lang->code }}">

                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label class="form-label" for="lang_module">{{ ___('language.module') }}</label>
                                <select class="form-control input-style-1 select2 change-module" id="lang_module" name="lang_module" data-url="{{ route('language.change.module') }}">
                                    @foreach (config('site.translations') as $key => $translation)
                                    <option value="{{ $key }}">{{ ___('language.'.$key)}}</option>
                                    @endforeach
                                </select>
                                @error('lang_module') <small class="text-danger mt-2">{{ $message }}</small> @enderror
                            </div>

                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="exampleDataList" class="form-label ">{{ ___('language.term') }}</label>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="exampleDataList" class="form-label ">{{ ___('language.translated_language') }}</label>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12 term-translated-language" id="termsRow">
                                @foreach ($langData as $key => $row)
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <input class="form-control ot-input" name="name" list="datalistOptions" id="exampleDataList" value="{{ $key }}" disabled>
                                    </div>
                                    <div class="col-md-6 translated_language">
                                        <input class="form-control ot-input" list="datalistOptions" id="exampleDataList" placeholder="{{ $row }}" name="{{ $key }}" value="{{ $row }}">
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>

                        <div class="j-create-btns">
                            <div class="drp-btns">
                                <button type="submit" class="j-td-btn"><i class="fa fa-save"></i> {{ ___('label.update') }} </button>
                                <a href="{{ route('language.index') }}" class="j-td-btn btn-red"> <i class="fa-solid fa-rectangle-xmark"></i> {{ ___('label.cancel') }} </a>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>

@endsection


@push('scripts')

<script src="{{ asset('backend/js/custom/language/language_curd.js')}}"></script>

@endpush
