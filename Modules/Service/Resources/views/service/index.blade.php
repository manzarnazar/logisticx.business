@extends('backend.partials.master')
@section('title', ___('label.service'))

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
                            <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}" class="breadcrumb-link">{{ ___('label.dashboard') }}</a></li>
                            <li class="breadcrumb-item"><a href="" class="breadcrumb-link">{{ ___('label.website_setup') }}</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('service.index') }}" class="breadcrumb-link">{{ ___('label.service') }}</a></li>
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
                <h4 class="title-site">{{ ___('label.service') }} {{ ___('label.list') }}
                </h4>
                @if (hasPermission('service_create'))
                <a href="{{ route('service.create') }}" class="j-td-btn">
                    <img src="{{ asset('backend') }}/icons/icon/plus-white.png" class="jj" alt="no image">
                    <span>{{ ___('label.add') }}</span>
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
                                <th scope="col">{{ ___('label.image') }}</th>
                                <th scope="col">{{ ___('label.short_description') }}</th>
                                <th scope="col">{{ ___('label.description') }}</th>

                                <th scope="col">{{ ___('label.position') }}</th>
                                <th scope="col">{{ ___('label.status') }}</th>

                                @if (hasPermission('service_update') || hasPermission('service_status_update') || hasPermission('service_delete'))
                                <th scope="col">{{ ___('label.action') }}</th>
                                @endif

                            </tr>
                        </thead>

                        <tbody>
                            {{-- @php $i=0; @endphp --}}
                            @forelse ($services as $key =>$service )

                            <tr id="row_{{ $service->id }}">

                                <td>{{ ++$key }}</td>
                                <td>{{ $service->title }}</td>
                                <td>
                                    <img src="{{ getImage($service->upload, 'original','default-image-40x40.png') }}" alt="image" class="rounded" height="40" width="40">
                                </td>
                                <td>{!! Str::limit($service->short_description, 70) !!}</td>
                                <td>{!! Str::limit($service->description, 70) !!}</td>
                                <td>{{ $service->position }}</td>
                                <td>{!! $service->my_status !!}</td>

                                @if (hasPermission('service_update') || hasPermission('service_status_update') || hasPermission('service_delete'))
                                <td>

                                    <div class="d-flex" data-toggle="dropdown">
                                        <a class="p-2" href="javascript:void()">
                                            <i class="fa fa-ellipsis-v"></i>
                                        </a>
                                    </div>

                                    <div class="dropdown-menu">
                                        @if (hasPermission('service_update'))
                                        <a href="{{ route('service.edit', $service->id) }}" class="dropdown-item"><i class="fa fa-edit" aria-hidden="true"></i> {{ ___('label.edit') }}</a>
                                        @endif

                                        @if (hasPermission('service_status_update'))
                                        <a href="{{ route('service.status.update', @$service->id) }}" class="dropdown-item">
                                            @if ($service->status == App\Enums\Status::ACTIVE)
                                            <i class="fa fa-power-off text-danger"></i>
                                            {{ ___('label.inactive') }}
                                            @else
                                            <i class="fa fa-power-off text-danger"></i>
                                            {{ ___('label.active') }}
                                            @endif
                                        </a>
                                        @endif

                                        @if (hasPermission('service_delete'))
                                        <a class="dropdown-item" href="javascript:void(0);" onclick="delete_row('admin/website-setup/service/delete', {{ $service->id }})">
                                            <i class="fa fa-trash" aria-hidden="true"></i> {{ ___('label.delete') }}
                                        </a>
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

                <!-- pagination  -->
                @if (count($services))
                <x-paginate-show :items="$services" />
                @endif

            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
@include('backend.partials.delete-ajax')
@endpush
