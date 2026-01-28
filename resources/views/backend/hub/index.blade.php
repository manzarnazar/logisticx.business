@extends('backend.partials.master')
@section('title')
{{ ___('hub.title') }} {{ ___('label.list') }}
@endsection
@section('maincontent')
<!-- wrapper  -->
<div class="container-fluid  dashboard-content">
    <!-- pageheader -->
    <div class="row">
        <div class="col-12">
            <div class="page-header">
                <div class="page-breadcrumb">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{url('/')}}" class="breadcrumb-link">{{ ___('label.dashboard')}}</a></li>
                            <li class="breadcrumb-item"><a href="" class="breadcrumb-link">{{ ___('label.title')}}</a></li>
                            <li class="breadcrumb-item"><a href="" class="breadcrumb-link active">{{ ___('label.list')}}</a></li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{route('hubs.filter')}}" method="post">
                        @csrf

                        <div class="form-row">
                            <div class="form-group col-12 col-lg-4 col-md-4">
                                <label class="label-style-1" for="name">{{ ___('label.name') }}</label>
                                <input type="text" id="name" name="name" placeholder="{{ ___('placeholder.Hub_name') }}" class="form-control input-style-1 " value="{{old('name', request()->name)}}">
                                @error('name') <small class="text-danger mt-2">{{ $message }}</small> @enderror
                            </div>
                            <div class="form-group col-12 col-lg-4 col-md-4">
                                <label class="label-style-1" for="phone">{{ ___('label.phone')}}</label> <span class="text-danger"></span>
                                <input type="text" id="phone" name="phone" placeholder="{{ ___('placeholder.phone') }}" class="form-control input-style-1 " value="{{old('phone', request()->phone)}}">
                                @error('phone')
                                <small class="text-danger mt-2">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="form-group col-4 d-flex align-items-end">
                                <button type="submit" class="j-td-btn mr-2"><i class="fa fa-filter "></i><span>{{ ___('label.filter') }}</span></button>
                                <a href="{{ route('hubs.index') }}" class="j-td-btn btn-red mr-2"><i class="fa fa-eraser"></i><span>{{ ___('label.clear') }}</span></a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="card">

                <div class="card-header mb-3">
                    <h4 class="title-site">{{ ___('hub.title') }}</h4>
                    @if(hasPermission('hub_create') == true )
                    <a href="{{route('hubs.create')}}" class="j-td-btn">
                        <img src="{{ asset('backend') }}/icons/icon/plus-white.png" class="jj" alt="no image"> <span>{{ ___('label.add') }} </span>
                    </a>
                    @endif
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table    ">
                            <thead class="bg">
                                <tr>
                                    <th>{{ ___('label.id')}}</th>
                                    <th>{{ ___('label.name')}}</th>
                                    <th>{{ ___('label.phone')}}</th>
                                    <th>{{ ___('label.address')}}</th>
                                    <th>{{ ___('label.coverage') }}</th>
                                    <th>{{ ___('label.status')}}</th>

                                    @if( hasPermission('hub_update') || hasPermission('hub_delete') || hasPermission('hub_incharge_read') )
                                    <th>{{ ___('label.actions')}}</th>
                                    @endif

                                </tr>
                            </thead>
                            <tbody>
                                @forelse($hubs as $key => $hub)
                                <tr id="row_{{ $hub->id }}">
                                    <td>{{++$key}}</td>
                                    <td><a href="{{route('hub.view',$hub->id)}}"> {{$hub->name}} </a></td>
                                    <td>{{$hub->phone}}</td>
                                    <td>{{$hub->address}}</td>
                                    <td>{{@$hub->coverage->name}}</td>
                                    <td>{!! $hub->my_status !!}</td>

                                    @if( hasPermission('hub_update') || hasPermission('hub_delete') || hasPermission('hub_incharge_read') )
                                    <td>
                                        <div class="d-flex" data-toggle="dropdown">
                                            <a class="p-2" href="javascript:void()"> <i class="fa fa-ellipsis-v"></i> </a>
                                        </div>
                                        <div class="dropdown-menu">

                                            @if(hasPermission('hub_view') == true )
                                            <a href="{{route('hub.view',$hub->id)}}" class="dropdown-item"><i class="fa fa-eye" aria-hidden="true"></i> {{ ___('label.view')}}</a>
                                            @endif

                                            @if(hasPermission('hub_update') == true )
                                            <a href="{{route('hubs.edit',$hub->id)}}" class="dropdown-item"><i class="fa fa-edit" aria-hidden="true"></i> {{ ___('label.edit')}}</a>
                                            @endif

                                            @if(hasPermission('hub_incharge_read') == true )
                                            <a href="{{route('hub-incharge.index',$hub->id)}}" class="dropdown-item"><i class="fa fa-plus-circle" aria-hidden="true"></i> {{ ___('hub.hub_incharge') }}</a>
                                            @endif

                                            @if(hasPermission('hub_delete') == true )
                                            <a class="dropdown-item" href="javascript:void(0);" onclick="delete_row('hub/delete', {{$hub->id}})"> <i class="fa fa-trash" aria-hidden="true"></i> {{ ___('label.delete') }} </a>
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
                    @if(count($hubs))
                    <x-paginate-show :items="$hubs" />
                    @endif
                    <!-- end pagination component -->
                </div>
            </div>
        </div>
    </div>
</div>
<!-- end wrapper  -->
@endsection()

@push('scripts')
@include('backend.partials.delete-ajax')
@endpush
