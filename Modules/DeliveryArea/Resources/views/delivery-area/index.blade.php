@extends('backend.partials.master')
@section('title', ___('label.delivery_areas'))
@section('maincontent')
<!-- wrapper  -->
<div class="container-fluid  dashboard-content">
    <!-- pageheader -->

    {{-- Old Breadbrmb --}}
    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="page-header">
                <div class="page-breadcrumb">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item breadcrumb-link"><a href="{{ route('dashboard.index') }}">{{ ___('label.dashboard') }}</a></li>
                            <li class="breadcrumb-item breadcrumb-link"><a href="">{{ ___('label.website_setup') }}</a></li>
                            <li class="breadcrumb-item breadcrumb-link"><a href="">{{ ___('label.delivery_areas') }}</a></li>
                            <li class="breadcrumb-item breadcrumb-link"><a href="" class="breadcrumb-link active">{{ ___('label.list') }}</a></li>
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
                <h4 class="title-site">{{ ___('label.delivery_areas') }} {{ ___('label.list') }}</h4>
                @if (hasPermission('delivery_area_create'))
                <a href="{{ route('delivery_area.create') }}" class="j-td-btn">
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
                                <th scope="col">{{ ___('label.description') }}</th>
                                <th scope="col">{{ ___('label.position') }}</th>
                                <th scope="col">{{ ___('label.status') }}</th>
                                <th scope="col">{{ ___('label.action') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($delivery_areas as $key => $delivery_area )
                            <tr id="row_{{ $delivery_area->id }}">
                                <td>{{ ++$key }}</td>
                                <td>{{ $delivery_area->title }}</td>
                                <td><img class="h-50px w-100 object-fit-cover" src="{{ getImage($delivery_area->upload, 'original', 'default-image-80x80.png') }}" alt="delivery_area_image"></td>
                                <td>{{ Str::limit(strip_tags($delivery_area->short_description), 150) }} </td>
                                <td>{{ $delivery_area->position }}</td>
                                <td>{!! $delivery_area->my_status !!}</td>


                                @if (hasPermission('delivery_area_update') || hasPermission('delivery_area_delete'))
                                <td>
                                    {{-- new action design  --}}
                                    <div class="d-flex" data-toggle="dropdown">
                                        <a class="p-2" href="javascript:void()">
                                            <i class="fa fa-ellipsis-v"></i>
                                        </a>
                                    </div>

                                    <div class="dropdown-menu">
                                        @if (hasPermission('delivery_area_update') == true)
                                        <a href="{{ route('delivery_area.edit', $delivery_area->id) }}" class="dropdown-item">
                                            <i class="fa fa-edit" aria-hidden="true"></i> {{ ___('label.edit') }}</a>
                                        @endif
                                        @if (hasPermission('delivery_area_delete') == true)
                                        <a class="dropdown-item" href="javascript:void(0);" onclick="delete_row('admin/website-setup/delivery-area/delete', {{ $delivery_area->id }})">
                                            <i class="fa fa-trash" aria-hidden="true"></i> {{ ___('label.delete') }}
                                        </a>
                                        @endif
                                    </div>
                                    {{-- end new action design  --}}
                                </td>
                                @endif
                            </tr>

                            @empty
                            <x-nodata-found :colspan="9" />
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @if (count($delivery_areas))
                <x-paginate-show :items="$delivery_areas" />
                @endif
            </div>

        </div>
    </div>

</div>
@endsection

@push('scripts')
@include('backend.partials.delete-ajax')
@endpush
