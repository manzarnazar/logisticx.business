@extends('backend.partials.master')
@section('title')
{{ ___('common.app_slider') }} {{ ___('label.list') }}
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
                            <li class="breadcrumb-item"><a href="{{route('support.index')}}" class="breadcrumb-link">{{ ___('label.app_slider') }}</a></li>
                            <li class="breadcrumb-item"><a href="" class="breadcrumb-link active">{{ ___('label.list') }}</a></li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <div class="row">

        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">

            <div class="j-parcel-main j-parcel-res">
                <div class="card">
                    <div class="card-header mb-3">
                        <h4 class="title-site">{{ ___('label.app_slider') }}</h4>
                        @if(hasPermission('app_slider_create'))
                        <a href="{{route('app_slider.create')}}" class="j-td-btn">
                            <img src="{{ asset('backend') }}/icons/icon/plus-white.png" class="jj" alt="no image"> <span>{{ ___('label.add') }} </span>
                        </a>
                        @endif
                    </div>

                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table  ">
                                <thead class="bg">
                                    <tr>
                                        <th>{{ ___('label.id') }}</th>
                                        <th>{{ ___('label.title') }}</th>
                                        <th>{{ ___('label.image')}}</th>
                                        <th>{{ ___('label.position')}}</th>
                                        <th>{{ ___('label.description') }}</th>
                                        <th>{{ ___('label.status') }}</th>
                                        @if(hasPermission('support_update') || hasPermission('app_slider_delete'))
                                        <th>{{ ___('label.action') }}</th>
                                        @endif
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $i=1; @endphp
                                    @forelse($app_sliders as $app_slider)
                                    <tr id="row_{{ $app_slider->id }}">
                                        <td>{{$i++}}</td>

                                        <td> {{ @$app_slider->title }} </td>
                                        <td> <img height="40" src="{{ getImage($app_slider->upload, 'original','default-image-80x80.png') }}" alt="logo" class="rounded-2"> </td>
                                        <td> {{ @$app_slider->position }} </td>
                                        <td> {{ @$app_slider->description }} </td>
                                        <td> {!!@$app_slider->MyStatus !!} </td>

                                        @if(hasPermission('app_slider_read') || hasPermission('app_slider_update') || hasPermission('app_slider_delete'))
                                        <td>
                                            <a class="p-2" data-toggle="dropdown" href="javascript:void()"> <i class="fa fa-ellipsis-v"></i> </a>
                                            <div class="dropdown-menu">
                                                @if(hasPermission('app_slider_update'))
                                                <a href="{{route('app_slider.edit',$app_slider->id)}}" class="dropdown-item"><i class="fa fa-edit" aria-hidden="true"></i> {{ ___('label.edit') }}</a>
                                                @endif

                                                @if(hasPermission('app_slider_delete'))
                                                <a class="dropdown-item" href="javascript:void(0);" onclick="delete_row('admin/app-slider/delete', {{$app_slider->id}})"> <i class="fa fa-trash" aria-hidden="true"></i> {{ ___('label.delete') }} </a>
                                                @endif
                                            </div>
                                        </td>
                                        @endif

                                    </tr>
                                    @empty
                                    <x-nodata-found :colspan="7" />
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <!-- pagination component -->
                        @if(count($app_sliders))
                        <x-paginate-show :items="$app_sliders" />
                        @endif
                        <!-- pagination component -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection()
@push('scripts')
@include('backend.partials.delete-ajax')
@endpush
