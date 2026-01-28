@extends('backend.partials.master')
@section('title',___('label.weekend') )
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
                            <li class="breadcrumb-item"><a href="" class="breadcrumb-link">{{ ___('label.weekend') }}</a></li>
                            <li class="breadcrumb-item"><a href="" class="breadcrumb-link active">{{ ___('label.list') }}</a></li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <!-- end pageheader -->

    <div class="j-parcel-main j-parcel-res">
        <div class="card">

            {{-- FAQ Header Title --}}
            <div class="card-header mb-3">
                <h4 class="title-site">{{ ___('label.weekend') }} {{ ___('label.list') }}</h4>
            </div>

            {{-- FAQ Index Body --}}
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table">
                        <thead class="bg">
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">{{ ___('label.name') }}</th>
                                <th scope="col">{{ ___('label.weekend') }}</th>
                                <th scope="col">{{ ___('label.status') }}</th>

                                @if(hasPermission('weekend_update') )
                                <th scope="col">{{ ___('label.action') }}</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($week as $key=>$item )

                            <tr id="row_{{ @$item->id }}">
                                <td>{{ ++$key }}</td>
                                <td>{{ @$item->name }}</td>
                                <td>{!! @$item->weekend !!}</td>
                                <td>{!! @$item->my_status !!}</td>

                                @if(hasPermission('weekend_update') )
                                <td>
                                    <div class="d-flex" data-toggle="dropdown">
                                        <a class="p-2" href="javascript:void()">
                                            <i class="fa fa-ellipsis-v"></i>
                                        </a>
                                    </div>
                                    <div class="dropdown-menu">
                                        @if(hasPermission('weekend_update'))
                                        <a href="{{ route('weekend.edit',@$item->id) }}" class="dropdown-item"><i class="fa fa-edit" aria-hidden="true"></i> {{ ___('label.edit') }}</a>
                                        @endif
                                    </div>
                                </td>
                                @endif
                            </tr>

                            @empty
                            <x-nodata-found :colspan="5" />
                            @endforelse
                        </tbody>
                    </table>
                </div>

            </div>

        </div>
    </div>
</div>
@endsection
