@extends('backend.partials.master')
@section('title')
{{ ___('common.ticket') }} {{ ___('label.list') }}
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
                            <li class="breadcrumb-item"><a href="{{route('support.index')}}" class="breadcrumb-link">{{ ___('common.ticket') }}</a></li>
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
                        <h4 class="title-site">{{ ___('common.ticket') }}</h4>
                        @if(hasPermission('support_create'))
                        <a href="{{route('support.add')}}" class="j-td-btn"> <img src="{{ asset('backend') }}/icons/icon/plus-white.png" class="jj" alt="no image"> <span>{{ ___('label.add') }} </span> </a>
                        @endif
                    </div>

                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table  ">
                                <thead class="bg">
                                    <tr>
                                        <th>{{ ___('label.id') }}</th>
                                        <th>{{ ___('common.subject') }}</th>
                                        <th>{{ ___('common.department')}}</th>
                                        <th>{{ ___('common.service')}}</th>
                                        <th>{{ ___('common.priority') }}</th>
                                        <th>{{ ___('common.date') }}</th>
                                        @if(hasPermission('support_update') || hasPermission('support_delete'))
                                        <th>{{ ___('common.action') }}</th>
                                        @endif
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $i=1; @endphp
                                    @forelse($supports as $support)
                                    <tr id="row_{{ $support->id }}">

                                        <td>{{$i++}}</td>

                                        <td><a href="{{ route('support.view',$support->id) }}">{{$support->subject }}</a></td>

                                        <td> {{ @$support->department->title }} </td>

                                        <td> {{ ___('common.'.$support->service) }} </td>

                                        <td>{!! $support->priority_badge !!}</td>

                                        <td>{{dateFormat($support->date) }}</td>

                                        @if(hasPermission('support_read') || hasPermission('support_update') || hasPermission('support_delete'))
                                        <td>
                                            <a class="p-2" data-toggle="dropdown" href="javascript:void()"> <i class="fa fa-ellipsis-v"></i> </a>

                                            <div class="dropdown-menu">

                                                @if(hasPermission('support_read'))
                                                <a href="{{route('support.view',$support->id)}}" class="dropdown-item"><i class="fa fa-eye" aria-hidden="true"></i> {{ ___('label.view') }}</a>
                                                @endif

                                                @if(hasPermission('support_update'))
                                                <a href="{{route('support.edit',$support->id)}}" class="dropdown-item"><i class="fa fa-edit" aria-hidden="true"></i> {{ ___('label.edit') }}</a>
                                                @endif

                                                @if(hasPermission('support_delete'))
                                                <a class="dropdown-item" href="javascript:void(0);" onclick="delete_row('support/delete', {{$support->id}})"> <i class="fa fa-trash" aria-hidden="true"></i> {{ ___('label.delete') }} </a>
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
                        @if(count($supports))
                        <x-paginate-show :items="$supports" />
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
