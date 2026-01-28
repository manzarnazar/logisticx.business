@extends('backend.partials.master')
@section('title')
{{ ___('label.bank') }} {{ ___('label.list') }}
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
                            <li class="breadcrumb-item"><a href="{{route('banks.index')}}" class="breadcrumb-link">{{ ___('label.bank') }}</a></li>
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
                    <h4 class="title-site">{{ ___('label.bank') }}</h4>
                    @if(hasPermission('bank_create') == true)
                    <a href="{{route('banks.create')}}" class="j-td-btn">
                        <img src="{{ asset('backend') }}/icons/icon/plus-white.png" class="jj" alt="no image"> <span>{{ ___('label.add') }} </span>
                    </a>
                    @endif
                </div>


                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead class="bg">
                                <tr>
                                    <th>{{ ___('label.id') }}</th>
                                    <th>{{ ___('label.bank_name') }}</th>
                                    <th>{{ ___('label.position') }}</th>
                                    <th>{{ ___('label.status') }}</th>
                                    @if(hasPermission('bank_update') == true || hasPermission('bank_delete') == true )
                                    <th>{{ ___('label.actions') }}</th>
                                    @endif
                                </tr>
                            </thead>
                            @php $i=1; @endphp
                            @forelse ($banks as $bank )
                            <tr id="row_{{ $bank->id }}">
                                <td>{{$i++}}</td>
                                <td>{{$bank->bank_name}}</td>
                                <td>{{$bank->position}}</td>
                                <td>{!! $bank->my_status !!}</td>
                                @if(hasPermission('bank_update') == true || hasPermission('bank_delete') == true )
                                <td>
                                    <div class="d-flex" data-toggle="dropdown">
                                        <a class="p-2" href="javascript:void()"> <i class="fa fa-ellipsis-v"></i> </a>
                                    </div>
                                    <div class="dropdown-menu">
                                        @if(hasPermission('bank_update') == true )
                                        <a href="{{route('banks.edit',$bank->id)}}" class="dropdown-item"><i class="fa fa-edit" aria-hidden="true"></i> {{ ___('label.edit') }}</a>
                                        @endif
                                        @if( hasPermission('bank_delete') == true )
                                        <a class="dropdown-item" href="javascript:void(0);" onclick="delete_row('admin/banks/delete', {{$bank->id}})">
                                            <i class="fa fa-trash" aria-hidden="true"></i> {{ ___('label.delete') }}
                                        </a>
                                        @endif
                                    </div>
                                </td>
                                @endif
                            </tr>
                            @empty
                            <x-nodata-found :colspan="5" />
                            @endforelse

                        </table>
                    </div>
                    <!-- pagination component -->
                    @if(count($banks))
                    <x-paginate-show :items="$banks" />
                    @endif
                    <!-- end pagination component -->
                </div>
            </div>
        </div>
        <!-- end data table  -->
    </div>
</div>
<!-- end wrapper-->
@endsection()

@push('scripts')
@include('backend.partials.delete-ajax')
@endpush
