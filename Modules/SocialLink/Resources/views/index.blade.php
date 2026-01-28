@extends('backend.partials.master')
@section('title',___('label.social_link') )

@section('maincontent')

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
                            <li class="breadcrumb-item "><a href="javascript:void(0)">{{ ___('label.social_link') }}</a></li>
                            <li class="breadcrumb-item active"><a href="javascript:void(0)" class="active">{{ ___('label.list') }}</a></li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <!-- end pageheader -->

    <div class="row">
        <div class="col-lg-12">
            <div class="card">

                <div class="card-header mb-3">
                    <h4 class="title-site">{{ ___('label.social_link') }} {{ ___('label.list') }}
                    </h4>
                    @if (hasPermission('social_link_create'))
                    <a href="{{ route('socialLink.create') }}" class="j-td-btn">
                        <img src="{{asset('backend')}}/icons/icon/plus-white.png" class="jj" alt="no image">
                        <span>{{ ___('label.add') }}</span>
                    </a>
                    @endif
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead class='bg'>
                                <tr>
                                    <th scope="col">{{ ___('label.id') }}</th>
                                    <th scope="col">{{ ___('label.name') }}</th>
                                    <th scope="col">{{ ___('label.icon') }}</th>
                                    <th scope="col">{{ ___('label.link') }}</th>
                                    <th scope="col">{{ ___('label.position') }}</th>
                                    <th scope="col">{{ ___('label.status') }}</th>
                                    @if(hasPermission('social_link_update') || hasPermission('social_link_delete'))
                                    <th scope="col">{{ ___('label.action') }}</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>

                                @forelse (@$sociallinks as $key => $row )

                                <tr id="row_{{ $row->id }}">

                                    <td>{{ ++$key; }}</td>
                                    <td>{{ @$row->name }}</td>
                                    <td>{{ @$row->icon }}</td>
                                    <td>{{ @$row->link }}</td>
                                    <td>{!! @$row->position !!}</td>
                                    <td>{!! $row->my_status !!}</td>
                                    @if(hasPermission('social_link_update') || hasPermission('social_link_delete'))
                                    <td>

                                        <div class="d-flex" data-toggle="dropdown">
                                            <a class="p-2" href="javascript:void()">
                                                <i class="fa fa-ellipsis-v"></i>
                                            </a>
                                        </div>
                                        <div class="dropdown-menu">

                                            @if(hasPermission('social_link_update'))
                                            <a href="{{ route('socialLink.edit',$row->id) }}" class="mr-4 dropdown-item">
                                                <i class="fa fa-pencil color-muted"></i> {{ ___('label.edit') }}
                                            </a>
                                            @endif
                                            @if(hasPermission('social_link_delete'))
                                            <a class="dropdown-item" href="javascript:void(0);" onclick="delete_row('admin/website-setup/social-link/delete', {{$row->id}})">
                                                <i class="fa fa-trash" aria-hidden="true"></i> {{ ___('label.delete') }}
                                            </a>
                                            @endif
                                        </div>
                                    </td>
                                    @endif
                                </tr>

                                @empty
                                <x-nodata-found :colspan="8" />
                                @endforelse

                            </tbody>
                        </table>
                    </div>

                    <!-- pagination component -->
                    @if(count($sociallinks))
                    <x-paginate-show :items="$sociallinks" />
                    @endif
                    <!-- end pagination component -->

                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
@include('backend.partials.delete-ajax')
@endpush
