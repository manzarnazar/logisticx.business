@extends('backend.partials.master')
@section('title')
{{ ___('common.inquiry') }} {{ ___('label.list') }}
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
                            <li class="breadcrumb-item"><a href="{{route('customer_inquiry.index')}}" class="breadcrumb-link">{{ ___('common.inquiry') }}</a></li>
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
                        <h4 class="title-site">{{ ___('common.inquiry') }}</h4>
                    </div>

                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table  ">
                                <thead class="bg">
                                    <tr>
                                        <th>{{ ___('label.id') }}</th>
                                        <th>{{ ___('common.name') }}</th>
                                        <th>{{ ___('common.phone')}}</th>
                                        <th>{{ ___('common.email')}}</th>
                                        <th>{{ ___('common.subject') }}</th>
                                        <th>{{ ___('common.message') }}</th>
                                        @if(hasPermission('customer_inquiry_update') || hasPermission('customer_inquiry_delete'))
                                        <th>{{ ___('common.action') }}</th>
                                        @endif
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $i=1; @endphp
                                    @forelse($inquires as $inquiry)
                                    <tr id="row_{{ $inquiry->id }}">
                                        <td>{{$i++}}</td>
                                        <td> {{ $inquiry->name }} </td>
                                        <td> {{ $inquiry->phone }} </td>
                                        <td> {{ $inquiry->email }} </td>
                                        <td> {{ $inquiry->subject }} </td>
                                        <td> {{ Str::limit($inquiry->message, 49) }} </td>

                                        @if(hasPermission('customer_inquiry_read') || hasPermission('inquiry_update') || hasPermission('inquiry_delete'))
                                        <td>
                                            <a class="p-2" data-toggle="dropdown" href="javascript:void()"> <i class="fa fa-ellipsis-v"></i> </a>

                                            <div class="dropdown-menu">

                                                @if(hasPermission('customer_inquiry_read'))
                                                <a href="{{ route('customer_inquiry.view', ['id' => $inquiry->id]) }}" title="{{ ___('label.view') }}" class="modalBtn dropdown-item" data-toggle="modal" data-target="#dynamic-modal" data-modal-size="modal-lg"> <i class="fa fa-eye"></i> {{ ___('label.view') }}</a>
                                                @endif

                                                @if(hasPermission('customer_inquiry_delete'))
                                                <a class="dropdown-item" href="javascript:void(0);" onclick="delete_row('admin/customer-inquiry/delete', {{$inquiry->id}})"> <i class="fa fa-trash" aria-hidden="true"></i> {{ ___('label.delete') }} </a>
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
                        @if(count($inquires))
                        <x-paginate-show :items="$inquires" />
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
