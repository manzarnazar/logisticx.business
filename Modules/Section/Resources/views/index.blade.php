@extends('backend.partials.master')
@section('title',___('label.sections') )
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
                            <li class="breadcrumb-item"><a href="" class="breadcrumb-link">{{ ___('label.sections') }}</a></li>
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

            <div class="card-header mb-3">
                <h4 class="title-site">{{ ___('label.sections') }} {{ ___('label.list') }}
                </h4>
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table">
                        <thead class="bg">
                            <tr>
                                <th scope="col">{{ ___('label.id')}}</th>
                                <th scope="col">{{ ___('label.type') }}</th>
                                @if(hasPermission('section_update'))
                                <th scope="col">{{ ___('label.action') }}</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>

                            @forelse(@$sections as $key => $row )
                            <tr>
                                <td>{{ ++$key; }}</td>
                                <td>{{ @$row->my_type }}</td>
                                @if(hasPermission('section_update'))
                                <td>
                                    {{-- <span>
                                        <a href="{{ route('section.edit',$row->type) }}" class="mr-4" data-toggle="tooltip" data-placement="top" title="{{ ___('edit') }}">
                                    <i class="fa fa-pencil color-muted"></i>
                                    </a>
                                    </span> --}}

                                    <div class="d-flex" data-toggle="dropdown">
                                        <a class="p-2" href="javascript:void()"> <i class="fa fa-ellipsis-v"></i> </a>
                                    </div>
                                    <div class="dropdown-menu">
                                        @if(hasPermission('section_update'))
                                        <a href="{{ route('section.edit',$row->type) }}" class="dropdown-item"><i class="fa fa-edit" aria-hidden="true"></i> {{ ___('label.edit') }}</a>
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
                @if(count($sections))
                <x-paginate-show :items="$sections" />
                @endif
                <!-- Pagination -->
            </div>

        </div>
    </div>


</div>
@endsection
