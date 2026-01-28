@extends('backend.partials.master')
@section('title',___('language.title') )

@section('maincontent')

<!-- wrapper  -->
<div class="container-fluid  dashboard-content">
    <!-- pageheader -->
    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="page-header">
                <div class="page-breadcrumb">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}" class="breadcrumb-link">{{ ___('label.dashboard') }}</a></li>
                            <li class="breadcrumb-item"><a href="{{route('language.index')}}" class="breadcrumb-link">{{ ___('language.title')}}</a></li>
                            <li class="breadcrumb-item"><a href="" class="breadcrumb-link active">{{ ___('label.list') }}</a></li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">

            <div class="card">
                <div class="card-header mb-3">
                    <h4 class="title-site">{{ ___('language.title') }} {{ ___('label.list') }}
                    </h4>
                    @if (hasPermission('language_create'))
                    <a href="{{ route('language.create') }}" class="j-td-btn">
                        <img src="{{asset('backend')}}/icons/icon/plus-white.png" class="jj" alt="no image">
                        <span>{{ ___('label.add') }}</span>
                    </a>
                    @endif
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead class="bg">
                                <tr>
                                    <th>{{ ___('label.id') }}</th>
                                    <th>{{ ___('label.flag_icon') }}</th>
                                    <th>{{ ___('label.name') }}</th>
                                    <th>{{ ___('label.code') }}</th>
                                    <th>{{ ___('label.status') }}</th>
                                    @if (
                                    hasPermission('language_update') ||
                                    hasPermission('language_phrase') ||
                                    hasPermission('language_delete'))
                                    <th>{{ ___('label.action') }}</th>
                                    @endif

                                </tr>
                            </thead>
                            <tbody>
                                @php $i=1; @endphp
                                @forelse($languages as $language)


                                <tr id="row_{{ $language->id }}">
                                    <td>{{ ++$i; }}</td>
                                    <td><i class=" {{ @$language->icon_class }} "></i></td>
                                    <td>{{ @$language->name }}</td>
                                    <td>{{ @$language->code }}</td>
                                    <td>{!! @$language->my_status !!}</td>
                                    @if (
                                    hasPermission('language_update') ||
                                    hasPermission('language_phrase') ||
                                    hasPermission('language_delete'))
                                    <td>

                                        <div class="d-flex" data-toggle="dropdown">
                                            <a class="p-2" href="javascript:void()">
                                                <i class="fa fa-ellipsis-v"></i>
                                            </a>
                                        </div>

                                        <div class="dropdown-menu">

                                            @if( hasPermission('language_update') && $language->code !== 'en' && $language->code !== 'bn' )
                                            <a href="{{ route('language.edit',$language->id) }}" class="dropdown-item"><i class="fa fa-edit color-muted" aria-hidden="true"></i> {{ ___('label.edit') }}</a>
                                            @endif

                                            @if( hasPermission('language_phrase'))
                                            <a href="{{ route('language.edit.phrase',$language->id) }}" class="dropdown-item"> <i class="fa fa-edit color-muted"></i> {{ ___('language.edit_phrase') }}</a>
                                            @endif

                                            @if( hasPermission('language_delete') && $language->code !== 'en' && $language->code !== 'bn')
                                            <a class="dropdown-item" href="javascript:void(0);" onclick="delete_row('admin/app-language/delete', {{$language->id}})"> <i class="fa fa-trash" aria-hidden="true"></i> {{ ___('label.delete') }} </a>
                                            @endif
                                        </div>
                                    </td>
                                    @endif

                                </tr>

                                @empty
                                <x-nodata-found :colspan="6" />
                                @endforelse
                            </tbody>

                        </table>
                    </div>
                </div>

                @if(count($languages))
                <x-paginate-show :items="$languages" />
                @endif


            </div>
        </div>
    </div>
</div>

@endsection



@push('scripts')
@include('backend.partials.delete-ajax')
@endpush
