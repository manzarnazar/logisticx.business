@extends('backend.partials.master')
@section('title')
{{ ___('common.support') }} {{ ___('label.list') }}
@endsection
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
                            <li class="breadcrumb-item"><a href="{{route('#')}}" class="breadcrumb-link">{{ ___('common.support_list') }}</a></li>
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
                    <h4 class="title-site">{{ ___('common.support') }}
                    </h4>
                    <a href="{{route('merchant-panel.support.add')}}" class="j-td-btn">
                        <img src="{{asset('backend')}}/icons/icon/plus-white.png" class="jj" alt="no image">
                        <span>{{ ___('label.add') }}</span>
                    </a>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table  ">
                            <thead class="bg">
                                <tr>
                                    <th>{{ ___('label.id') }}</th>
                                    <th>{{ ___('common.subject') }}</th>
                                    <th>{{ ___('common.service')}}</th>
                                    <th>{{ ___('common.department')}}</th>
                                    <th>{{ ___('common.priority') }}</th>
                                    {{-- <th>{{ ___('common.description') }}</th> --}}
                                    <th>{{ ___('common.date') }}</th>
                                    <th>{{ ___('common.action') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($supports as $key => $support)
                                <tr id="row_{{ $support->id }}">
                                    <td>{{++$key}}</td>
                                    <td> <a href="{{route('merchant-panel.support.view',$support->id)}}">{{$support->subject }}</a> </td>

                                    <td> {{ ___('common.'.$support->service) }} </td>
                                    <td> {{$support->department->title}} </td>
                                    <td>{{$support->priority }}</td>

                                    {{-- <td> {!! $support->description !!} </td> --}}

                                    <td> {{dateFormat($support->date) }} </td>
                                    <td>
                                        <a class="p-2" data-toggle="dropdown" href="javascript:void()"> <i class="fa fa-ellipsis-v"></i> </a>
                                        <div class="dropdown-menu">
                                            <a href="{{route('merchant-panel.support.view',$support->id)}}" class="dropdown-item"><i class="fa fa-eye" aria-hidden="true"></i> {{ ___('label.view') }}</a>
                                            <a href="{{route('merchant-panel.support.edit',$support->id)}}" class="dropdown-item"><i class="fa fa-edit" aria-hidden="true"></i> {{ ___('label.edit') }}</a>
                                            <a class="dropdown-item" href="javascript:void(0);" onclick="delete_row('merchant/support/delete', {{$support->id}})"> <i class="fa fa-trash" aria-hidden="true"></i> {{ ___('label.delete') }} </a>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <x-nodata-found :colspan="7" />
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- pagination component -->
                @if(count($supports))
                <x-paginate-show :items="$supports" />
                @endif
                <!-- end pagination component -->
            </div>
        </div>
        <!-- end data table  -->
    </div>
</div>
<!-- end wrapper  -->
@endsection()

@push('scripts')
@include('backend.partials.delete-ajax')
@endpush
