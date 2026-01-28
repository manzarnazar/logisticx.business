@extends('backend.partials.master')
@section('title',___('label.widgets') )
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
                            <li class="breadcrumb-item"><a href="{{route('dashboard.index')}}" class="breadcrumb-link">{{ ___('label.dashboard') }}</a></li>
                            <li class="breadcrumb-item"><a href="" class="breadcrumb-link">{{ ___('label.website_setup') }}</a></li>
                            <li class="breadcrumb-item"><a href="" class="breadcrumb-link">{{ ___('label.widgets') }}</a></li>
                            <li class="breadcrumb-item"><a href="" class="breadcrumb-link active">{{ ___('label.list') }}</a></li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <!-- end pageheader -->
    <div class="row">
        <!-- data table  -->
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="card">

                <div class="card-header mb-3">
                    <h4 class="title-site">{{ ___('label.widgets') }} {{ ___('label.list') }}</h4>
                    @if(hasPermission('widget_create') )
                    <a href="{{route('widgets.create')}}" class="j-td-btn">
                        <img src="{{ asset('backend/icons/icon/plus-white.png') }}" class="jj" alt="no image"> <span>{{ ___('label.add') }} </span>
                    </a>
                    @endif
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead class="bg">
                                <tr>
                                    <th scope="col">#</th>

                                    <th scope="col">{{ ___('label.title') }}</th>
                                    <th scope="col">{{ ___('label.section') }}</th>
                                    <th scope="col">{{ ___('label.position') }}</th>
                                    <th scope="col">{{ ___('label.status') }}</th>
                                    @if(hasPermission('widget_status_update'))
                                    <th scope="col">{{ ___('label.status_update') }}</th>
                                    @endif
                                    @if(hasPermission('widget_update') || hasPermission('widget_delete'))
                                    <th scope="col">{{ ___('label.action') }}</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>

                                @php $i=0; @endphp
                                @forelse ($widgets as $widget )
                                <tr id="row_{{ $widget->id }}">
                                    <td>{{ ++$i; }}</td>
                                    <td>{{ $widget->title }}</td>
                                    <td>{{ ___("label.$widget->section") }}</td>
                                    <td>{!! $widget->position !!}</td>
                                    <td>{!! $widget->my_status !!}</td>

                                    @if(hasPermission('widget_status_update'))
                                    <td>
                                        <a class="nav-link" href="#" role="button" data-toggle="dropdown"> ... </a>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            <ul class=" ">
                                                @if($widget->status == App\Enums\Status::INACTIVE)
                                                <li class="media dropdown-item"> <a href="{{ route('widgets.status.update',$widget->id) }}">{{ ___('label.active')}}</a> </li>
                                                @elseif($widget->status == App\Enums\Status::ACTIVE)
                                                <li class="media dropdown-item"> <a href="{{ route('widgets.status.update',$widget->id) }}">{{ ___('label.inactive')}}</a> </li>
                                                @endif
                                            </ul>
                                        </div>
                                    </td>
                                    @endif
                                    @if(hasPermission('widget_update') || hasPermission('widget_delete'))
                                    <td>
                                        {{-- new action design  --}}
                                        <div class="d-flex" data-toggle="dropdown">
                                            <a class="p-2" href="javascript:void()">
                                                <i class="fa fa-ellipsis-v"></i>
                                            </a>
                                        </div>
                                        <div class="dropdown-menu">
                                            @if(hasPermission('widget_update'))
                                            <a href="{{ route('widgets.edit',$widget->id) }}" class="dropdown-item"><i class="fa fa-edit" aria-hidden="true"></i> {{ ___('label.edit') }}</a>
                                            @endif
                                            @if(hasPermission('widget_delete') )
                                            <a class="dropdown-item" href="javascript:void(0);" onclick="delete_row('admin/website-setup/widgets/delete', {{$widget->id}})">
                                                <i class="fa fa-trash" aria-hidden="true"></i> {{ ___('label.delete') }}
                                            </a>
                                            @endif
                                        </div>
                                        {{-- end new action design  --}}
                                    </td>
                                    @endif
                                </tr>

                                @empty
                                <x-nodata-found :colspan="6" />
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    @if(count($widgets))
                    <x-paginate-show :items="$widgets" />
                    @endif
                    <!-- Pagination -->

                </div>
            </div>
        </div>
    </div>
</div>
@endsection


@push('scripts')
@include('backend.partials.delete-ajax')
@endpush
